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
        }

        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => $page * 2 - 1
        ]);

        if ($response->ok()) {
            $movies['results'] = array_merge($movies['results'], $response->json()['results']);
        }

        return $movies;
    }
}
