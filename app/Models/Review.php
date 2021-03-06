<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['created_at_human'];

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

    public function getCreatedAtHumanAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }

        return "";
    }

    public function getMyReview($movieId)
    {
        if (!Auth::user()) {
            return [];
        }

        $review = Review::where('user_id', Auth::id())
            ->where('movie_id', $movieId)
            ->get();

        return $review;
    }

    public function getUserReviews(User $user)
    {
        $reviews = Review::where('user_id', $user->id)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->orderBy('updated_at', 'desc')
            ->with('user')
            ->withCount('likes')
            ->paginate(15);

        return $reviews;
    }

    public function getFriendsReviews($movieId, $numberOfReviews = 40)
    {
        if (!Auth::user()) {
            return [];
        }

        $user = Auth::user();

        $reviews = Review::whereHas('user', function ($query) use ($user) {
            $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })
            ->where('movie_id', $movieId)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->latest()
            ->paginate($numberOfReviews);

        return $reviews;
    }

    public function getPopularReviews($movieId, $numberOfReviews = 40)
    {
        $reviews = Review::where('movie_id', $movieId)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->latest('likes_count')
            ->paginate($numberOfReviews);

        return $reviews;
    }

    public function getRecentReviews($movieId, $numberOfReviews = 40)
    {
        $reviews = Review::where('movie_id', $movieId)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->orderBy('updated_at', 'desc')
            ->paginate($numberOfReviews);

        return $reviews;
    }

    public function getLikedReviews(User $user)
    {
        $reviews = DB::table('likes_reviews')
            ->where('user_id', $user->id)
            ->latest()
            ->select('review_id')
            ->paginate(15);

        return $reviews;
    }

    public function getReviewsByIds($ids)
    {
        $reviews = Review::whereIn('id', $ids)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->latest()
            ->get();

        return $reviews;
    }

    public function isLiked(Review $review)
    {
        return  DB::table('likes_reviews')->where('user_id', Auth::user()->id)->where('review_id', $review->id)->count() === 1;
    }

    public function markAsLiked(Review $review)
    {
        DB::table('likes_reviews')->insert([
            'user_id' => Auth::user()->id,
            'review_id' => $review->id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    public function unmarkAsLiked(Review $review)
    {
        DB::table('likes_reviews')->where('user_id', Auth::user()->id)->where('review_id', $review->id)->delete();
    }

    public function handleLike(Review $review)
    {
        $isLiked = $this->isLiked($review);

        if ($isLiked) {
            $this->unmarkAsLiked($review);
            return;
        }

        $this->markAsLiked($review);
    }

    public function createReview($movieId, $review, $recommended, $spoiler)
    {
        Auth::user()->reviews()->create([
            'movie_id' => $movieId,
            'review' => $review,
            'recommended' => $recommended,
            'spoiler' => $spoiler
        ]);
    }

    public function updateReview(Review $review, $reviewText, $recommended, $spoiler)
    {
        $review->update([
            'review' => $reviewText,
            'recommended' => $recommended,
            'spoiler' => $spoiler
        ]);
    }

    public function getLatestReviews()
    {
        $reviews = Review::latest()
            ->take(8)
            ->pluck('movie_id');

        return $reviews;
    }
}
