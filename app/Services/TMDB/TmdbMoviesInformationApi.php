<?php

namespace App\Services\TMDB;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TmdbMoviesInformationApi
{
    public function getMovies($page = 1)
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => Config::get('services.tmdb.key'),
            'include_adult' => false,
            'page' => $page * 2 - 1
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        } else {
            return abort(404);
        }

        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => Config::get('services.tmdb.key'),
            'include_adult' => false,
            'page' => $page * 2
        ]);

        if ($response->ok()) {
            $movies['results'] = array_merge($movies['results'], $response->json()['results']);
        }

        return $movies;
    }

    public function getTrendingMoviesToday()
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/trending/movie/day', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => 1
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies;
    }

    public function getUpcomingMovies()
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/movie/upcoming', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => 1
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies;
    }

    public function getMovieById($id)
    {
        $movie = [];

        $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'append_to_response' => 'videos,credits'
        ]);

        if ($response->ok()) {
            $movie = $response->json();
        }

        return $movie;
    }

    public function getMoviesById($moviesIds)
    {
        $movies = [];

        foreach ($moviesIds as $id) {
            $movie = $this->getMovieById($id);
            
            if ($movie) {
                $movies[] = $movie;
            }
        }

        return $movies;
    }

    public function getMoviesByName($query, $page = 1)
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/search/movie', [
            'api_key' => Config::get('services.tmdb.key'),
            'query' => $query,
            'page' => $page
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies;
    }

    public function getSimilarById($id, $page = 1)
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/movie/' . $id . '/similar', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => $page
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies;
    }

    public function getRecommendedById($id, $page = 1)
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/movie/' . $id . '/recommendations', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => $page
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies;
    }

    public function getMovieCredits($id)
    {
        $credits = [];

        $response = Http::get('https://api.themoviedb.org/3/movie/' . $id . '/credits', [
            'api_key' => Config::get('services.tmdb.key')
        ]);

        if ($response->ok()) {
            $credits = $response->json();
        }

        return $credits;
    }

    public function getActor($id)
    {
        $actor = [];

        $response = Http::get('https://api.themoviedb.org/3/person/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
        ]);

        if ($response->ok()) {
            $actor = $response->json();
        }

        $response = Http::get('https://api.themoviedb.org/3/person/' . $id . '/movie_credits', [
            'api_key' => Config::get('services.tmdb.key'),
        ]);

        if ($response->ok() && isset($actor)) {
            $actor['movies'] = $response->json()['cast'];
        }

        return $actor;
    }
}
