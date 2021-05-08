<?php

namespace App\Http\Controllers;

use App\Models\ListMovie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function movies(Request $request, $query)
    {
        $movies = Http::get('https://api.themoviedb.org/3/search/movie', [
            'api_key' => Config::get('services.tmdb.key'),
            'query' => urlencode($query),
            'page' => $request->page ?? 1
        ])->json();

        return Inertia::render('Search/Movies', [
            'query' => $query,
            'movies' => $movies,
            'page' => ['actual' => $movies['page'], 'last' => $movies['total_pages']]
        ]);
    }

    public function reviews(Request $request, $query)
    {
        $terms = explode(" ", $query);

        $reviews = Review::query()
            ->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orWhere('review', 'like', '%' . $term . '%');
                }
            })
            ->orWhere('review', 'like', '%' . $query . '%')
            ->withcount(['likes as like' => function ($q) {
                return $q->orWhere('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->distinct()
            ->paginate();

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        return Inertia::render('Search/Reviews', [
            'query' => $query,
            'reviews' => $reviews,
            'page' => ['actual' => $reviews->currentPage(), 'last' => $reviews->lastPage()]
        ]);
    }

    public function lists(Request $request, $query)
    {
        $terms = explode(" ", $query);

        $lists = ListMovie::query()
            ->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orWhere('name', 'like', '%' . $term . '%');
                }
            })
            ->orWhere(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orWhere('description', 'like', '%' . $term . '%');
                }
            })
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->distinct()
            ->paginate();

        foreach ($lists as $index => $list) {
            $lists[$index]['movies_count'] = DB::table('lists_movies')->where('list_id', $list->id)->get()->count();
            $moviesId = DB::table('lists_movies')->where('list_id', $list->id)->get()->take(5)->pluck('movie_id');
            $movies = [];

            foreach ($moviesId as $id) {
                $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                    'api_key' => Config::get('services.tmdb.key'),
                ]);

                if ($response->ok()) {
                    $movies[] = $response->json();
                } else {
                    unset($lists[$index]);
                }
            }

            $lists[$index]['movies'] = $movies;
        }

        return Inertia::render('Search/Lists', [
            'query' => $query,
            'lists' => $lists,
            'page' => ['actual' => $lists->currentPage(), 'last' => $lists->lastPage()]
        ]);
    }

    public function members(Request $request, $query)
    {
        $members = User::query()
            ->where('username', 'like', '%' . $query . '%')
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])
            ->withCount('followers')
            ->distinct()
            ->paginate();

        return Inertia::render('Search/Members', [
            'query' => $query,
            'members' => $members,
            'page' => ['actual' => $members->currentPage(), 'last' => $members->lastPage()]
        ]);
    }
}
