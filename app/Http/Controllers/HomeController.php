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
        $lastWatchedMovie = $this->movie->getLastWatchedMovies() ?? [];
        $lastWatchedMovie = array_map(function ($movie) {
            return $movie->movie_id;
        }, $this->movie->getLastWatchedMovies() ?? []);
        $recommendedMovies = array_slice($this->tmdbApi->getRecommendedById($lastWatchedMovie) ?? [], 0, 24);
        $recommendedMovies = $this->movie->markWatchedMovies($recommendedMovies);
        $recommendedMovies = $this->movie->markLikedMovies($recommendedMovies);

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
            'recommendedMovies' => $recommendedMovies,
            'trendingMovies' => $trendingMovies,
            'upcomingMovies' => $upcomingMovies,
            'justReviewed' => $justReviewed,
        ]);
    }
}
