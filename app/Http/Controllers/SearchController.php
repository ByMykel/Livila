<?php

namespace App\Http\Controllers;

use App\Models\ListMovie;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    protected $tmdbApi;
    protected $movie;
    protected $review;
    protected $listMovie;
    protected $user;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie, Review $review, ListMovie $listMovie, User $user)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
        $this->review = $review;
        $this->listMovie = $listMovie;
        $this->user = $user;
    }

    public function getSuggestedMovies($query)
    {
        $movies = $this->tmdbApi->getMoviesByName(urlencode($query), 1);
        return array_slice($movies['results'], 0, 6);
    }

    public function movies(Request $request, $query)
    {
        $movies = $this->tmdbApi->getMoviesByName(urlencode($query), max(1, $request->page ?? 1));

        if ($movies) {
            $movies['results'] = $this->movie->markWatchedMovies($movies['results']);
            $movies['results'] = $this->movie->markLikedMovies($movies['results']);
        }

        return Inertia::render('Search/Movies', [
            'query' => $query,
            'movies' => $movies,
            'page' => ['actual' => $movies['page'] ?? 1, 'last' => $movies['total_pages'] ?? 1]
        ]);
    }

    public function members(Request $request, $query)
    {
        $members = $this->user->getUserByName($query);

        return Inertia::render('Search/Members', [
            'query' => $query,
            'members' => $members,
            'page' => ['actual' => $members->currentPage(), 'last' => $members->lastPage()]
        ]);
    }
}
