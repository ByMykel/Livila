<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Inertia\Inertia;

class HomeController extends Controller
{
    protected $tmdbApi;
    protected $movie;
    protected $review;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie, Review $review)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
        $this->review = $review;
    }

    public function index()
    {
        $movies = $this->tmdbApi->getPopular()['results'];
        $randomMovie = array_rand($movies, 1);

        $movie = $movies[$randomMovie];

        $trendingMovies = array_slice($this->tmdbApi->getTrendingMoviesToday()['results'], 0, 16);
        $trendingMovies = $this->movie->markWatchedMovies($trendingMovies);
        $trendingMovies = $this->movie->markLikedMovies($trendingMovies);

        $upcomingMovies = array_slice($this->tmdbApi->getUpcomingMovies()['results'], 0, 16);
        $upcomingMovies = $this->movie->markWatchedMovies($upcomingMovies);
        $upcomingMovies = $this->movie->markLikedMovies($upcomingMovies);

        $justReviewedIds = $this->review->getLatestReviews();
        $justReviewed = $this->tmdbApi->getMoviesById($justReviewedIds);
        $justReviewed = $this->movie->markWatchedMovies($justReviewed);
        $justReviewed = $this->movie->markLikedMovies($justReviewed);

        return Inertia::render('Home', [
            'movie' => $movie,
            'trendingMovies' => $trendingMovies,
            'upcomingMovies' => $upcomingMovies,
            'justReviewed' => $justReviewed,
        ]);
    }
}
