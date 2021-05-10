<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ListMovie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $user;
    protected $activity;

    public function __construct(User $user, Activity $activity)
    {
        $this->user = $user;
        $this->activity = $activity;
    }

    public function show(User $user)
    {
        $user = $this->user->getUser($user);
        $activities = $this->activity->getUserActivity($user);

        return Inertia::render('Users/Show', [
            'user' => $user,
            'activities' => $activities->items(),
            'page' => ['actual' => $activities->currentPage(), 'last' => $activities->lastPage()]
        ]);
    }

    public function follow(User $user)
    {
        $this->activity->handleFollowUser($user);
        $this->user->handleFollow($user);

        return redirect()->back();
    }

    public function following(User $user)
    {
        $following = $user->following()
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])->get();

        return Inertia::render('Users/Following', [
            'user' => $user,
            'following' => $following
        ]);
    }

    public function followers(User $user)
    {
        $followers = $user->followers()
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])->get();

        return Inertia::render('Users/Followers', [
            'user' => $user,
            'followers' => $followers
        ]);
    }
}
