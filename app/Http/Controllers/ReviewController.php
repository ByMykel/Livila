<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function index($id)
    {
        $reviewsId = Review::where('movie_id', $id)->with('user')->withCount('likes')->withCount('comments')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->orderBy('updated_at', 'desc')->paginate(8);
        $reviews = $reviewsId->items();

        $movie = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES',
            'append_to_response' => 'videos,credits'
        ])->json();

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        return Inertia::render('Reviews/Index', [
            'movie' => $movie,
            'reviews' => $reviews,
            'page' => ['actual' => $reviewsId->currentPage(), 'last' => $reviewsId->lastPage()]
        ]);
    }

    public function popular($id)
    {
        $reviewsId = Review::where('movie_id', $id)->with('user')->withCount('likes')->withCount('comments')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->orderBy('likes_count', 'desc')->paginate(8);
        $reviews = $reviewsId->items();

        $movie = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES',
            'append_to_response' => 'videos,credits'
        ])->json();

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        return Inertia::render('Reviews/Popular', [
            'movie' => $movie,
            'reviews' => $reviews,
            'page' => ['actual' => $reviewsId->currentPage(), 'last' => $reviewsId->lastPage()]
        ]);
    }

    public function friends($id)
    {
        $reviewsId = Review::whereIn('user_id', Auth::user()->following()->get()->pluck('id'))->where('movie_id', $id)->with('user')->withCount('likes')->withCount('comments')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->orderBy('updated_at', 'desc')->paginate(8);
        $reviews = $reviewsId->items();

        $movie = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES',
            'append_to_response' => 'videos,credits'
        ])->json();

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        return Inertia::render('Reviews/Friends', [
            'movie' => $movie,
            'reviews' => $reviews,
            'page' => ['actual' => $reviewsId->currentPage(), 'last' => $reviewsId->lastPage()]
        ]);
    }

    public function store($id, Request $request)
    {
        $request->validate([
            'review' => ['required', 'string'],
            'recommended' => ['required', 'boolean'],
            'spoiler' => ['required', 'boolean']
        ]);

        $review = Auth::user()->reviews()->create([
            'movie_id' => $id,
            'review' => $request->review,
            'recommended' => $request->recommended,
            'spoiler' => $request->spoiler
        ]);

        $data = $review;
        $data['movie'] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES'
        ]))->json();
        

        Activity::create(['type' => 'createReview', 'user_id' => Auth::user()->id, 'data' => $data]);

        return redirect()->back();
    }

    public function update($id, Review $review, Request $request)
    {
        $request->validate([
            'review' => ['required', 'string'],
            'recommended' => ['required', 'boolean'],
            'spoiler' => ['required', 'boolean']
        ]);

        $review->update([
            'review' => $request->review,
            'recommended' => $request->recommended,
            'spoiler' => $request->spoiler
        ]);

        return redirect()->back();
    }

    public function destroy($id, Review $review)
    {
        DB::table('activities')->where('type', 'createReview')->where('user_id', Auth::user()->id)->where('data->movie_id',  $id)->delete();
        
        $review->delete();

        return redirect()->back();
    }

    public function like($id, Review $review)
    {
        $q = DB::table('likes_reviews')->where('user_id', Auth::user()->id)->where('review_id', $review->id);

        if ($q->first()) {
            $q->delete();

            DB::table('activities')->where('type', 'likeReview')->where('user_id', Auth::user()->id)->where('data->user_id',  $review->user_id)->where('data->movie_id',  $review->movie_id)->delete();
        } else {
            DB::table('likes_reviews')->insert([
                'user_id' => Auth::user()->id,
                'review_id' => $review->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);

            $data = $review;
            $data['user'] = User::find($review->user_id);
            $data['movie'] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();

            Activity::create(['type' => 'likeReview', 'user_id' => Auth::user()->id, 'data' => $data]);
        }

        return redirect()->back();
    }

    public function reviews(User $user)
    {
        $reviewsId = Review::where('user_id', $user->id)->with('user')->withCount('likes')->withCount('comments')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->orderBy('updated_at', 'desc')->paginate(8);
        $reviews = $reviewsId->items();

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Users/Reviews', [
            'user' => $user,
            'reviews' => $reviews,
            'page' => ['actual' => $reviewsId->currentPage(), 'last' => $reviewsId->lastPage()]
        ]);
    }
}
