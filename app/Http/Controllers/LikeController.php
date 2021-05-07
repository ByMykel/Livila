<?php

namespace App\Http\Controllers;

use App\Models\ListMovie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class LikeController extends Controller
{
    public function Index(User $user)
    {
        $moviesId = DB::table('likes_movies')->where('user_id', $user->id)->latest()->get()->pluck('movie_id');
        $reviewsId = DB::table('likes_reviews')->where('user_id', $user->id)->latest()->get()->pluck('review_id')->take(4);
        $listsId = DB::table('likes_lists')->where('user_id', $user->id)->latest()->get()->pluck('list_id')->take(4);

        $reviews = Review::whereIn('id', $reviewsId)->with('user')->withCount('likes')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->latest()->get();
        $lists = ListMovie::whereIn('id', $listsId)->with('user')->withCount('likes')->latest()->get();
        $movies = [];

        foreach ($moviesId as $id) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        foreach ($lists as $index => $list) {
            $lists[$index]['movies_count'] = DB::table('lists_movies')->where('list_id', $list->id)->get()->count();
            $listMoviesId = DB::table('lists_movies')->where('list_id', $list->id)->get()->take(5)->pluck('movie_id');
            $listsMovies = [];

            foreach ($listMoviesId as $id) {
                $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                    'api_key' => Config::get('services.tmdb.key'),
                    'language' => 'es-ES'
                ]);

                if ($response->ok()) {
                    $listsMovies[] = $response->json();
                } else {
                    unset($lists[$index]);
                }
            }

            $lists[$index]['movies'] = $listsMovies;
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Likes/Index', [
            'user' => $user,
            'lists' => $lists,
            'reviews' => $reviews,
            'movies' => $movies
        ]);
    }

    public function movies(User $user)
    {
        $moviesId = DB::table('likes_movies')->where('user_id', $user->id)->latest()->select('movie_id')->paginate(40);
        $movies = [];

        foreach ($moviesId->items() as $index => $movie) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $movie->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Likes/Movies', [
            'user' => $user,
            'movies' => $movies,
            'page' => ['actual' => $moviesId->currentPage(), 'last' => $moviesId->lastPage()]
        ]);
    }

    public function lists(User $user)
    {
        $listsId = DB::table('likes_lists')->where('user_id', $user->id)->latest()->select('list_id')->paginate(8);
        $ids = array_map(function ($lists) {
            return $lists->list_id;
        }, $listsId->items());
        $lists = ListMovie::whereIn('id', $ids)->with('user')->withCount('likes')->latest()->get();

        foreach ($lists as $index => $list) {
            $lists[$index]['movies_count'] = DB::table('lists_movies')->where('list_id', $list->id)->get()->count();
            $listMoviesId = DB::table('lists_movies')->where('list_id', $list->id)->get()->take(5)->pluck('movie_id');
            $listsMovies = [];

            foreach ($listMoviesId as $id) {
                $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                    'api_key' => Config::get('services.tmdb.key'),
                    'language' => 'es-ES'
                ]);

                if ($response->ok()) {
                    $listsMovies[] = $response->json();
                } else {
                    unset($lists[$index]);
                }
            }

            $lists[$index]['movies'] = $listsMovies;
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Likes/Lists', [
            'user' => $user,
            'lists' => $lists,
            'page' => ['actual' => $listsId->currentPage(), 'last' => $listsId->lastPage()]
        ]);
    }

    public function reviews(User $user)
    {
        $reviewsId = DB::table('likes_reviews')->where('user_id', $user->id)->latest()->select('review_id')->paginate(8);
        $ids = array_map(function ($reviews) {
            return $reviews->review_id;
        }, $reviewsId->items());
        $reviews = Review::whereIn('id', $ids)->with('user')->withCount('likes')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->latest()->get();

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Likes/Reviews', [
            'user' => $user,
            'reviews' => $reviews,
            'page' => ['actual' => $reviewsId->currentPage(), 'last' => $reviewsId->lastPage()]
        ]);
    }
}
