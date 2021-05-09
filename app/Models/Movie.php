<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    use HasFactory;

    public function isWatched($id)
    {
        return DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $id)->count() === 1;
    }

    public function markWatchedMovies($movies)
    {
        foreach ($movies as $index => $movie) {
            $movies[$index]['watched'] = $this->isWatched($movie['id']);
        }

        return $movies;
    }

    public function isLiked($id)
    {
        return DB::table('likes_movies')->where('user_id', Auth::user()->id)->where('movie_id', $id)->count() === 1;
    }

    public function markLikedMovies($movies)
    {
        foreach ($movies as $index => $movie) {
            $movies[$index]['liked'] = $this->isLiked($movie['id']);
        }

        return $movies;
    }
}
