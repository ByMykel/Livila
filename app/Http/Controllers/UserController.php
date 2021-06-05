<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

    public function following(User $user, Request $request)
    {
        $following = $this->user->getUserFollowing($user);
        $user = $this->user->getUser($user);

        return Inertia::render('Users/Following', [
            'user' => $user,
            'following' => $following->items(),
            'page' => ['actual' => $following->currentPage(), 'last' => $following->lastPage()]
        ]);
    }

    public function followers(User $user, Request $request)
    {
        $followers = $this->user->getUserFollowers($user);
        $user = $this->user->getUser($user);

        return Inertia::render('Users/Followers', [
            'user' => $user,
            'followers' => $followers->items(),
            'page' => ['actual' => $followers->currentPage(), 'last' => $followers->lastPage()]
        ]);
    }
}
