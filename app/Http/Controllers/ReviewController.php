<?php

namespace App\Http\Controllers;

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
        $reviews = Review::where('movie_id', $id)->get();

        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews
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

        return redirect()->back();
    }

    public function show($id, Review $review)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES'
        ]);

        if ($response->ok()) {
            $review = Review::where('id', $review->id)->with('user')->get();
            $review[0]['movie'] = $response->json();
        } else {
            dd(404);
        }

        return Inertia::render('Reviews/Show', [
            'review' => $review
        ]);
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
        $review->delete();

        return redirect()->back();
    }

    public function like($id)
    {
        $review = DB::table('likes_reviews')->where('user_id', Auth::user()->id)->where('review_id', $id);

        if ($review->first()) {
            $review->delete();
        } else {
            DB::table('likes_reviews')->insert([
                'user_id' => Auth::user()->id,
                'review_id' => $id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        return redirect()->back();
    }

    public function reviews(User $user)
    {
        $reviews = $user->reviews()->get();

        return Inertia::render('Users/Reviews', [
            'reviews' => $reviews
        ]);
    }
}
