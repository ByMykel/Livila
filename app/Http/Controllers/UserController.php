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
    public function show(User $user)
    {
        $moviesId = DB::table('movies_watched')->where('user_id', $user->id)->latest()->get()->take(4)->pluck('movie_id');

        $reviews = Review::where('user_id', $user->id)->latest()->get()->take(4);
        $lists = ListMovie::whereIn('id', $user->listsMovies()->pluck('id'))->orderBy('updated_at', 'DESC')->get()->take(4);
        $watched = [];

        foreach ($moviesId as $id) {
            $watched[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Users/Show', [
            'user' => $user,
            'reviews' =>  $reviews,
            'lists' =>  $lists,
            'watched' =>  $watched
        ]);
    }

    public function follow(User $user)
    {
        if (Auth::user()->following()->find($user)) {
            Auth::user()->following()->detach($user);

            DB::table('activities')->where('type', 'followUser')->where('user_id', Auth::user()->id)->where('data->id',  $user->id)->delete();
        } else {
            Auth::user()->following()->attach($user);

            Activity::create(['type' => 'followUser', 'user_id' => Auth::user()->id, 'data' => $user]);
        }

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
