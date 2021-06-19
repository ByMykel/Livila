<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'movies_watched';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isWatched($id)
    {
        return DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $id)->count() === 1;
    }

    public function markWatchedMovies($movies)
    {
        if (!Auth::user()) {
            return $movies;
        }

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
        if (!Auth::user()) {
            return $movies;
        }

        foreach ($movies as $index => $movie) {
            $movies[$index]['liked'] = $this->isLiked($movie['id']);
        }

        return $movies;
    }

    public function markAsLiked($id)
    {
        DB::table('likes_movies')->insert([
            'user_id' => Auth::user()->id,
            'movie_id' => $id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    public function unmarkAsLiked($id)
    {
        DB::table('likes_movies')->where('user_id', Auth::user()->id)->where('movie_id', $id)->delete();
    }

    public function handleLike($id)
    {
        $isLiked = $this->isLiked($id);

        if ($isLiked) {
            $this->unmarkAsLiked($id);
            return;
        }

        $this->markAsLiked($id);
    }

    public function markAsWatched($id)
    {
        DB::table('movies_watched')->insert([
            'user_id' => Auth::user()->id,
            'movie_id' => $id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    public function unmarkAsWatched($id)
    {
        DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $id)->delete();
    }

    public function handleWatch($id)
    {
        $isWatched = $this->isWatched($id);

        if ($isWatched) {
            $this->unmarkAsWatched($id);
            return;
        }

        $this->markAsWatched($id);
    }

    public function getWatchedMoviesIds(User $user)
    {
        return DB::table('movies_watched')->where('user_id', $user->id)->latest()->select('movie_id')->paginate(40);
    }

    public function getLikedMoviesIds(User $user)
    {
        return DB::table('likes_movies')->where('user_id', $user->id)->latest()->select('movie_id')->paginate(40);
    }

    public function getLastWatchedMovies()
    {
        if (!Auth::user()) {
            return [];
        }

        return DB::table('movies_watched')->where('user_id', Auth::id())->latest()->select('movie_id')->take(10)->get()->toArray(); 
    }
}
