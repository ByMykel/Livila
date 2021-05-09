<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes_reviews', 'review_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getMyReview($movieId)
    {
        $review = Review::where('user_id', Auth::user()->id)
            ->where('movie_id', $movieId)
            ->get();

        return $review;
    }

    public function getFriendsReviews($movieId)
    {
        $user = Auth::user();

        $reviews = Review::whereHas('user', function ($query) use ($user) {
            $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })
            ->where('movie_id', $movieId)
            ->latest()
            ->take(5)
            ->get();

        return $reviews;
    }

    public function getPopularReviews($movieId)
    {
        $reviews = Review::where('movie_id', $movieId)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->latest('likes_count')
            ->take(5)
            ->get();

        return $reviews;
    }

    public function getRecentReviews($movieId)
    {
        $reviews = Review::where('movie_id', $movieId)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return $reviews;
    }
}
