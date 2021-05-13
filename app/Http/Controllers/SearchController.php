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

    public function movies(Request $request, $query)
    {
        $movies = $this->tmdbApi->getMoviesByName(urlencode($query), $request->page ?? 1);
        $movies['results'] = $this->movie->markWatchedMovies($movies['results']);
        $movies['results'] = $this->movie->markLikedMovies($movies['results']);

        return Inertia::render('Search/Movies', [
            'query' => $query,
            'movies' => $movies,
            'page' => ['actual' => $movies['page'], 'last' => $movies['total_pages']]
        ]);
    }

    public function reviews(Request $request, $query)
    {
        $reviews = $this->review->getReviewsByName($query);

        foreach ($reviews as $index => $review) {
            $reviews[$index]['movie'] = $this->tmdbApi->getMovieById($review->movie_id);
        }

        return Inertia::render('Search/Reviews', [
            'query' => $query,
            'reviews' => $reviews,
            'page' => ['actual' => $reviews->currentPage(), 'last' => $reviews->lastPage()]
        ]);
    }

    public function lists(Request $request, $query)
    {
        $lists = $this->listMovie->getListsByName($query);

        foreach ($lists as $index => $list) {
            $lists[$index]['movies_count'] = $this->listMovie->getNumberOfMoviesInAList($list);
            $listMoviesId = $this->listMovie->getMoviesFromAList($list, 5);

            $ids = array_map(function ($movie) {
                return $movie->movie_id;
            }, $listMoviesId->items());

            $listsMovies = $this->tmdbApi->getMoviesById($ids);
            $lists[$index]['movies'] = $listsMovies;
        }

        return Inertia::render('Search/Lists', [
            'query' => $query,
            'lists' => $lists,
            'page' => ['actual' => $lists->currentPage(), 'last' => $lists->lastPage()]
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
