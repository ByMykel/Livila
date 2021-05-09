<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['created_at_human'];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime:H:i · M d, Y'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtHumanAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }

        return "";
    }

    public function isLikeMovie($movie)
    {
        return DB::table('activities')->where('type', 'likeMovie')->where('user_id', '=', Auth::user()->id)->where('data->id', '=', $movie['id'])->count() === 1;
    }

    public function createLikeMovie($movie)
    {
        Activity::create(['type' => 'likeMovie', 'user_id' => Auth::user()->id, 'data' => $movie]);
    }

    public function deleteLikeMovie($movie)
    {
        DB::table('activities')->where('type', 'likeMovie')->where('user_id', '=', Auth::user()->id)->where('data->id', '=', $movie['id'])->delete();
    }

    public function handleLikeMovieActivity($movie)
    {
        $isLikeMovie = $this->isLikeMovie($movie);

        if ($isLikeMovie) {
            $this->deleteLikeMovie($movie);
            return;
        }

        $this->createLikeMovie($movie);
    }

    public function isWatchMovie($movie)
    {
        return DB::table('activities')->where('type', 'watchMovie')->where('user_id', Auth::user()->id)->where('data->id', $movie['id'])->count() === 1;
    }

    public function createWatchMovie($movie)
    {
        Activity::create(['type' => 'watchMovie', 'user_id' => Auth::user()->id, 'data' => $movie]);
    }

    public function deleteWatchMovie($movie)
    {
        DB::table('activities')->where('type', 'watchMovie')->where('user_id', Auth::user()->id)->where('data->id', $movie['id'])->delete();
    }

    public function handleWatchMovieActivity($movie)
    {
        $isWatchMovie = $this->isWatchMovie($movie);

        if ($isWatchMovie) {
            $this->deleteWatchMovie($movie);
            return;
        }

        $this->createWatchMovie($movie);
    }
}
