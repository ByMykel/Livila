<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show(User $user)
    {
        $user = $this->user->getUser($user);

        return Inertia::render('Users/Show', [
            'user' => $user,
        ]);
    }

    public function follow(User $user)
    {
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
