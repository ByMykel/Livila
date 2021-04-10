<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class LikeController extends Controller
{
    public function Index(User $user)
    {
        $moviesId = DB::table('likes_movies')->where('user_id', $user->id)->latest()->get()->pluck('movie_id')->take(5);

        $lists = $user->listsMovies()->get()->take(5);
        $reviews = $user->reviews()->get()->take(5);
        $movies = [];

        foreach ($moviesId as $id) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
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
