<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ListMovie;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\TMDB\TmdbMoviesInformationApi;

class MovieController extends Controller
{
    protected $tmdbApi;
    protected $movie;
    protected $listMovie;
    protected $activity;
    protected $review;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie, ListMovie $listMovie, Activity $activity, Review $review, User $user)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
        $this->listMovie = $listMovie;
        $this->activity = $activity;
        $this->review = $review;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $popular = $this->tmdbApi->getPopular($request->page ?? 1);

        $popular['results'] = $this->movie->markWatchedMovies($popular['results']);
        $popular['results'] = $this->movie->markLikedMovies($popular['results']);

        return Inertia::render('Movies/Index', [
            'popular' => $popular,
            'page' => ['actual' => intval($request->page ?? 1), 'last' => intval($popular['total_pages']) / 2]
        ]);
    }

    public function show($id)
    {
        $movie = $this->tmdbApi->getMovie($id);

        $myReview = $this->review->getMyReview($id);
        $friendsReviews = $this->review->getFriendsReviews($id);
        $popularReviews = $this->review->getPopularReviews($id);
        $recentReviews = $this->review->getRecentReviews($id);

        foreach ($friendsReviews as $index => $_review) {
            $friendsReviews[$index]['movie'] = $movie;
        }

        foreach ($popularReviews as $index => $_review) {
            $popularReviews[$index]['movie'] = $movie;
        }

        foreach ($recentReviews as $index => $_review) {
            $recentReviews[$index]['movie'] = $movie;
        }

        $movie = $this->movie->markWatchedMovies([$movie])[0];
        $movie = $this->movie->markLikedMovies([$movie])[0];

        $lists = $this->listMovie->getMyLists();
        $lists = $this->listMovie->markListWithMovie($lists, $id);

        return Inertia::render('Movies/Show', [
            'movie' => $movie,
            'myReview' => $myReview,
            'friendsReviews' => $friendsReviews,
            'popularReviews' => $popularReviews,
            'recentReviews' => $recentReviews,
            'lists' => $lists
        ]);
    }

    public function handleLike($id)
    {
        $movie = $this->tmdbApi->getMovie($id);

        $this->activity->handleLikeMovieActivity($movie);
        $this->movie->handleLike($id);

        return redirect()->back();
    }

    public function handleWatch($id)
    {
        $movie = $this->tmdbApi->getMovie($id);

        $this->activity->handleWatchMovieActivity($movie);
        $this->movie->handleWatch($id);

        return redirect()->back();
    }

    public function watchedMovies(User $user)
    {
        $user = $this->user->getUser($user);

        $moviesIds = $this->movie->getWatchedMoviesIds($user);

        $ids = array_map(function ($movie) {
            return $movie->movie_id;
        }, $moviesIds->items());

        $movies = $this->tmdbApi->getMoviesById($ids);

        return Inertia::render('Users/Watched', [
            'user' => $user,
            'watched' => $movies,
            'page' => ['actual' => $moviesIds->currentPage(), 'last' => $moviesIds->lastPage()]
        ]);
    }
}
