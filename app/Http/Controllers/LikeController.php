<?php

namespace App\Http\Controllers;

use App\Models\ListMovie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class LikeController extends Controller
{
    public function Index(User $user)
    {
        $moviesId = DB::table('likes_movies')->where('user_id', $user->id)->latest()->get()->pluck('movie_id')->take(8);
        $reviewsId = DB::table('likes_reviews')->where('user_id', $user->id)->latest()->get()->pluck('review_id')->take(4);
        $listsId = DB::table('likes_lists')->where('user_id', $user->id)->latest()->get()->pluck('list_id')->take(4);

        $reviews = Review::whereIn('id', $reviewsId)->with('user')->withCount('likes')->latest()->get();
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

        return Inertia::render('Likes/Index', [
            'user' => $user,
            'lists' => $lists,
            'reviews' => $reviews,
            'movies' => $movies
        ]);
    }

    public function movies(User $user)
    {
        $moviesId = DB::table('likes_movies')->where('user_id', $user->id)->latest()->get()->pluck('movie_id');

        $movies = [];

        foreach ($moviesId as $id) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        return Inertia::render('Likes/Movies', [
            'movies' => $movies
        ]);
    }

    public function lists(User $user)
    {
        $lists = $user->listsMovies()->get();

        return Inertia::render('Likes/Lists', [
            'lists' => $lists
        ]);
    }

    public function reviews(User $user)
    {
        $reviews = $user->reviews()->get();

        return Inertia::render('Likes/Index', [
            'reviews' => $reviews
        ]);
    }
}
