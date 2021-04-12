<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store($id, Review $review, Request $request)
    {
        $request->validate([
            'comment' => ['required', 'string']
        ]);

        $comment = Auth::user()->comments()->create([
            'user_id' => Auth::user()->id,
            'review_id' => $review->id,
            'comment' => $request->comment
        ]);

        return redirect()->back();
    }

    public function destroy($id, Review $review, Comment $comment)
    {
        $comment->delete();

        return redirect()->back();
    }
}
