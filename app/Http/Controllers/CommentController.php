<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $data = $comment;
        $data['review'] = $review;
        $data['user'] = User::find($review->user_id);

        Activity::create(['type' => 'commentReview', 'user_id' => Auth::user()->id, 'data' => $data]);

        return redirect()->back();
    }

    public function destroy($id, Review $review, Comment $comment)
    {
        DB::table('activities')->where('type', 'commentReview')->where('data->id',  $comment->id)->delete();

        $comment->delete();

        return redirect()->back();
    }
}
