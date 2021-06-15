<?php

namespace App\Http\Controllers;

use App\Models\ListMovie;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Inertia\Inertia;

class LikeController extends Controller
{
    protected $tmdbApi;
    protected $movie;
    protected $user;
    protected $listMovie;
    protected $review;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie, User $user, ListMovie $listMovie, Review $review)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
        $this->user = $user;
        $this->listMovie = $listMovie;
        $this->review = $review;
    }

    public function movies(User $user)
    {
        $moviesIds = $this->movie->getLikedMoviesIds($user);

        $ids = array_map(function ($movie) {
            return $movie->movie_id;
        }, $moviesIds->items());

        $movies = $this->tmdbApi->getMoviesById($ids);

        $movies = $this->movie->markWatchedMovies($movies);
        $movies = $this->movie->markLikedMovies($movies);

        $user = $this->user->getUser($user);

        return Inertia::render('Likes/Movies', [
            'user' => $user,
            'movies' => $movies,
            'page' => ['actual' => $moviesIds->currentPage(), 'last' => $moviesIds->lastPage()]
        ]);
    }

    public function lists(User $user)
    {
        $listsIds = $this->listMovie->getLikedLists($user);

        $ids = array_map(function ($lists) {
            return $lists->list_id;
        }, $listsIds->items());

        $lists = $this->listMovie->getListsByIds($ids);

        foreach ($lists as $index => $list) {
            $lists[$index]['movies_count'] = $this->listMovie->getNumberOfMoviesInAList($list);
            $listMoviesId = $this->listMovie->getMoviesFromAList($list, 5);

            $ids = array_map(function ($movie) {
                return $movie->movie_id;
            }, $listMoviesId->items());

            $listsMovies = $this->tmdbApi->getMoviesById($ids);
            $lists[$index]['movies'] = $listsMovies;
        }

        $user = $this->user->getUser($user);

        return Inertia::render('Likes/Lists', [
            'user' => $user,
            'lists' => $lists,
            'page' => ['actual' => $listsIds->currentPage(), 'last' => $listsIds->lastPage()]
        ]);
    }

    public function reviews(User $user)
    {
        $reviewsId = $this->review->getLikedReviews($user);

        $ids = array_map(function ($reviews) {
            return $reviews->review_id;
        }, $reviewsId->items());

        $reviews = $this->review->getReviewsByIds($ids);

        foreach ($reviews as $index => $review) {
            $movie = $this->tmdbApi->getMovieById($review->movie_id);

            if ($movie) {
                $reviews[$index]['movie'] = $movie;
            } else {
                unset($reviews[$index]);
            }
        }

        $user = $this->user->getUser($user);

        return Inertia::render('Likes/Reviews', [
            'user' => $user,
            'reviews' => $reviews,
            'page' => ['actual' => $reviewsId->currentPage(), 'last' => $reviewsId->lastPage()]
        ]);
    }
}
