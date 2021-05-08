<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
                    $query->where('review', 'like', '%' . $term . '%');
                }
            })
            ->orWhere('review', 'like', '%' . $query . '%')
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
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
}
