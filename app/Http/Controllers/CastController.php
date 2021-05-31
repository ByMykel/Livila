<?php

namespace App\Http\Controllers;

use App\Services\TMDB\TmdbMoviesInformationApi;
use Inertia\Inertia;

class CastController extends Controller
{
    protected $tmdbApi;

    public function __construct(TmdbMoviesInformationApi $tmdbApi)
    {
        $this->tmdbApi = $tmdbApi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $movie = $this->tmdbApi->getMovieById($id);
        $castMembers = $this->tmdbApi->getMovieCredits($id)['cast'] ?? [];

        return Inertia::render('Cast/Index', [
            'movie' => $movie,
            'castMembers' => $castMembers
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = $this->tmdbApi->getActor($id);

        return Inertia::render('Cast/Show', [
            'actor' => $actor,
            'movies' => $actor['movies']
        ]);
    }
}
