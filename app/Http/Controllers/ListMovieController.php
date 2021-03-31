<?php

namespace App\Http\Controllers;

use App\Models\ListMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popularLists = ListMovie::withCount('likes')->orderByDesc('likes_count')->get()->take(10);

        dd($popularLists);
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
     * @param  \App\Models\ListMovie $listMovie
     * @return \Illuminate\Http\Response
     */
    public function show(ListMovie $listMovie)
    {
        // $id = Auth::user()->listsMovies()->where('id', 1)->pluck('id')[0];
        $moviesId = DB::table('lists_movies')->where('list_id', $listMovie->id)->get();
        $movies = [];

        foreach ($moviesId as $movie) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $movie->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        dd([$listMovie, $movies]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListMovie  $listMovie
     * @return \Illuminate\Http\Response
     */
    public function edit(ListMovie $listMovie)
    {
        dd("edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ListMovie $listMovie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListMovie $listMovie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListMovie $listMovie
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListMovie $listMovie)
    {
        //
    }
}
