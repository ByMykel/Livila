<?php

namespace App\Http\Controllers;

use App\Models\LikeMovie;
use App\Models\ListMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
