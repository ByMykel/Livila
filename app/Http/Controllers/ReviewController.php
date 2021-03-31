<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'recommended' => ['required', 'boolean']
        ]);

        $review = Auth::user()->reviews()->create([
            'movie_id' => $id,
            'review' => $request->review,
            'recommended' => $request->recommended
        ]);

        return redirect()->back();
    }

    public function show($id, Review $review)
    {
        return Inertia::render('Reviews/Show', [
            'review' => $review
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'review' => ['required', 'string'],
            'recommended' => ['required', 'boolean']
        ]);

        $review->update([
            'review' => $request->review,
            'recommended' => $request->recommended
        ]);

        return redirect()->back();
    }

    public function destroy(Review $review)
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
