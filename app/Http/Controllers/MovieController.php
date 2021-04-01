<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index()
    {
        $popular = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES'
        ]);

        $trendingWeek = Http::get('https://api.themoviedb.org/3/trending/movie/week', [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES'
        ]);

        return Inertia::render('Movies/Index', [
            'popular' => $popular->json(),
            'trendingWeek' => $trendingWeek->json()
        ]);
    }

    public function show($id)
    {
        $movie = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES'
        ]);

        return Inertia::render('Movies/Show', [
            'movie' => $movie->json()
        ]);
    }

    public function like($id)
    {
        $movie = DB::table('likes_movies')->where('user_id', Auth::user()->id)->where('movie_id', $id);

        if ($movie->first()) {
            $movie->delete();
        } else {
            DB::table('likes_movies')->insert([
                'user_id' => Auth::user()->id,
                'movie_id' => $id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        return redirect()->back();
    }

    public function watch($id)
    {
        $movie = DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $id);

        if ($movie->first()) {
            $movie->delete();
        } else {
            DB::table('movies_watched')->insert([
                'user_id' => Auth::user()->id,
                'movie_id' => $id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        return redirect()->back();
    }

    public function home()
    {
        $friendsId = Auth::user()->following()->get()->pluck('id');
        $moviesId = DB::table('movies_watched')->whereIn('user_id', $friendsId)->get()->pluck('movie_id');

        $friendsReviews = Review::whereIn('user_id', $friendsId)->latest()->get();
        $friendsWatched = [];

        foreach ($moviesId as $id) {
            $friendsWatched[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        return Inertia::render('Home', [
            'friendsReviews' => $friendsReviews,
            'friendsWatched' => $friendsWatched
        ]);
    }

    public function watched(User $user)
    {
        $watchedIds = DB::table('movies_watched')->where('user_id', $user->id)->latest()->get()->pluck('movie_id');
        $watched = [];

        foreach ($watchedIds as $id) {
            $watched[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        return Inertia::render('Users/Watched', [
            'watched' => $watched
        ]);
    }
}
