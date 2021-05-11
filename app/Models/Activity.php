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

    public function getMyActivity()
    {
        $activities = Auth::user()
            ->activities()
            ->with('user')
            ->paginate(40);

        return $activities;
    }

    public function getUserActivity(User $user)
    {
        $activities = User::find($user->id)
            ->activities()
            ->with('user')
            ->paginate(40);

        return $activities;
    }

    public function getFriendsActivity()
    {
        $user = Auth::user();

        $activities = Activity::whereHas('user', function ($query) use ($user) {
            return $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })
            ->latest()
            ->with('user')
            ->paginate(40);

        return $activities;
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

    public function isFollowUser(User $user)
    {
        return DB::table('activities')->where('type', 'followUser')->where('user_id', Auth::user()->id)->where('data->id',  $user->id)->count() === 1;
    }

    public function createFollowUser(User $user)
    {
        Activity::create(['type' => 'followUser', 'user_id' => Auth::user()->id, 'data' => $user]);
    }

    public function deleteFollowUser(User $user)
    {
        DB::table('activities')->where('type', 'followUser')->where('user_id', Auth::user()->id)->where('data->id', $user->id)->delete();
    }

    public function handleFollowUser(User $user)
    {
        $isFollowUser = $this->isFollowUser($user);

        if ($isFollowUser) {
            $this->deleteFollowUser($user);
            return;
        }

        $this->createFollowUser($user);
    }

    public function isLikeReview(Review $review)
    {
        return DB::table('activities')->where('type', 'likeReview')->where('user_id', Auth::id())->where('data->user->id',  $review->user_id)->where('data->movie->id',  $review->movie_id)->count() === 1;
    }

    public function createLikeReview($data)
    {
        Activity::create(['type' => 'likeReview', 'user_id' => Auth::id(), 'data' => $data]);
    }

    public function deleteLikeReview(Review $review)
    {
        return DB::table('activities')->where('type', 'likeReview')->where('user_id', Auth::id())->where('data->user->id',  $review->user_id)->where('data->movie->id',  $review->movie_id)->delete();
    }

    public function handleLikeReview(Review $review, $data)
    {
        $isLikeReview = $this->isLikeReview($review);

        if ($isLikeReview) {
            $this->deleteLikeReview($review);
            return;
        }

        $this->createLikeReview($data);
    }
}
