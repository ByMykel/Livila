<?php

namespace App\Services\TMDB;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TmdbMoviesInformationApi
{
    public function getPopular($page = 1)
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => $page * 2
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        } else {
            return abort(404);
        }

        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => $page * 2 - 1
        ]);

        if ($response->ok()) {
            $movies['results'] = array_merge($movies['results'], $response->json()['results']);
        } else {
            return abort(404);
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
            $movies[] = $this->getMovieById($id);
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
}
