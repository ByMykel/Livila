<?php

namespace App\Http\Controllers;

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
    protected $review;
    protected $user;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie, ListMovie $listMovie, Review $review, User $user)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
        $this->listMovie = $listMovie;
        $this->review = $review;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $popular = $this->tmdbApi->getMovies($request->page ?? 1);

        $popular['results'] = $this->movie->markWatchedMovies($popular['results']);
        $popular['results'] = $this->movie->markLikedMovies($popular['results']);

        return Inertia::render('Movies/Index', [
            'popular' => $popular,
            'page' => ['actual' => intval($request->page ?? 1), 'last' => floor(intval($popular['total_pages']) / 2)]
        ]);
    }

    public function show($id)
    {
        $movie = $this->tmdbApi->getMovieById($id);

        if (!$movie) {
            return abort(404);
        }

        $similarMovies = array_slice($this->tmdbApi->getSimilarById($id)['results'], 0, 8);
        $similarMovies = $this->movie->markWatchedMovies($similarMovies);
        $similarMovies = $this->movie->markLikedMovies($similarMovies);

        $myReview = $this->review->getMyReview($id);
        $friendsReviews = $this->review->getFriendsReviews($id, 5);
        $friendsReviews = count($friendsReviews) > 0 ? $friendsReviews->items() : [];

        $popularReviews = $this->review->getPopularReviews($id, 5);
        $recentReviews = $this->review->getRecentReviews($id, 5);

        foreach ($friendsReviews as $index => $_review) {
            $friendsReviews[$index]['movie'] = $movie;
        }

        foreach ($popularReviews->items() as $index => $_review) {
            $popularReviews[$index]['movie'] = $movie;
        }

        foreach ($recentReviews->items() as $index => $_review) {
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
            'popularReviews' => $popularReviews->items(),
            'recentReviews' => $recentReviews->items(),
            'lists' => $lists,
            'similarMovies' => $similarMovies
        ]);
    }

    public function handleLike($id)
    {
        $movie = $this->tmdbApi->getMovieById($id);

        $this->movie->handleLike($id);

        return redirect()->back();
    }

    public function handleWatch($id)
    {
        $movie = $this->tmdbApi->getMovieById($id);

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
        $movies = $this->movie->markWatchedMovies($movies);
        $movies = $this->movie->markLikedMovies($movies);

        return Inertia::render('Users/Watched', [
            'user' => $user,
            'watched' => $movies,
            'page' => ['actual' => $moviesIds->currentPage(), 'last' => $moviesIds->lastPage()]
        ]);
    }
}
