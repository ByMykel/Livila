<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ListMovie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES',
            'page' => intval($request->page ?? 1) * 2 - 1
        ]);

        if ($response->ok()) {
            $popular = $response->json();
        } else {
            dd(404);
        }

        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES',
            'page' => intval($request->page ?? 1) * 2
        ]);

        if ($response->ok()) {
            $popular['results'] = array_merge($popular['results'], $response->json()['results']);
        } else {
            dd(404);
        }

        foreach ($popular['results'] as $index => $movie) {
            $likedMovie = DB::table('likes_movies')->where('user_id', Auth::user()->id)->where('movie_id', $movie['id'])->count() === 1;
            $watchedMovie = DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $movie['id'])->count() === 1;

            if ($likedMovie) {
                $popular['results'][$index]['liked'] = true;
            } else {
                $popular['results'][$index]['liked'] = false;
            }

            if ($watchedMovie) {
                $popular['results'][$index]['watched'] = true;
            } else {
                $popular['results'][$index]['watched'] = false;
            }
        }

        return Inertia::render('Movies/Index', [
            'popular' => $popular,
            'page' => ['actual' => intval($request->page ?? 1), 'last' => intval($popular['total_pages']) / 2]
        ]);
    }

    public function show($id)
    {
        $friendsId = Auth::user()->following()->get()->pluck('id');

        $myReview = Review::where('user_id', Auth::user()->id)->where('movie_id', $id)->get();
        $friendsReviews = Review::whereIn('user_id', $friendsId)->where('movie_id', $id)->with('user')->withCount('likes')->withCount('comments')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->latest()->take(4)->get();
        $popularReviews = Review::where('movie_id', $id)->with('user')->withCount('likes')->withCount('comments')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->orderBy('likes_count', 'desc')->take(4)->get();
        $recentReviews = Review::where('movie_id', $id)->with('user')->withCount('likes')->withCount('comments')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->orderBy('updated_at', 'desc')->take(4)->get();

        $movie = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
            'language' => 'es-ES',
            'append_to_response' => 'videos,credits'
        ])->json();

        foreach ($friendsReviews as $index => $movieReview) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $movieReview->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $friendsReviews[$index]['movie'] = $response->json();
            } else {
                unset($friendsReviews[$index]);
            }
        }

        foreach ($popularReviews as $index => $movieReview) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $movieReview->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $popularReviews[$index]['movie'] = $response->json();
            } else {
                unset($popularReviews[$index]);
            }
        }

        foreach ($recentReviews as $index => $movieReview) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $movieReview->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $recentReviews[$index]['movie'] = $response->json();
            } else {
                unset($recentReviews[$index]);
            }
        }

        $liked = DB::table('likes_movies')->where('user_id', Auth::user()->id)->where('movie_id', $id)->count() === 1;
        $watched = DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $id)->count() === 1;

        $lists = ListMovie::where('user_id', Auth::user()->id)->get();

        foreach ($lists as $index => $list) {
            $lists[$index]['contains_movie'] = DB::table('lists_movies')->where('list_id', $list->id)->where('movie_id', $id)->count() === 1;
        }

        return Inertia::render('Movies/Show', [
            'movie' => $movie,
            'myReview' => $myReview,
            'friendsReviews' => $friendsReviews,
            'popularReviews' => $popularReviews,
            'recentReviews' => $recentReviews,
            'liked' => $liked,
            'watched' => $watched,
            'lists' => $lists
        ]);
    }

    public function like($id)
    {
        $movie = DB::table('likes_movies')->where('user_id', Auth::user()->id)->where('movie_id', $id);

        if ($movie->first()) {
            $movie->delete();

            DB::table('activities')->where('type', 'likeMovie')->where('user_id', '=', Auth::user()->id)->where('data->id', '=', $id)->delete();
        } else {
            DB::table('likes_movies')->insert([
                'user_id' => Auth::user()->id,
                'movie_id' => $id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);

            $data = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();

            Activity::create(['type' => 'likeMovie', 'user_id' => Auth::user()->id, 'data' => $data]);
        }

        return redirect()->back();
    }

    public function watch($id)
    {
        $movie = DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $id);

        if ($movie->first()) {
            $movie->delete();

            DB::table('activities')->where('type', 'watchMovie')->where('user_id', Auth::user()->id)->where('data->id', $id)->delete();
        } else {
            DB::table('movies_watched')->insert([
                'user_id' => Auth::user()->id,
                'movie_id' => $id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);

            $data = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();

            Activity::create(['type' => 'watchMovie', 'user_id' => Auth::user()->id, 'data' => $data]);
        }

        return redirect()->back();
    }

    public function watched(User $user)
    {
        $watchedIds = DB::table('movies_watched')->where('user_id', $user->id)->latest()->select('movie_id')->paginate(40);
        $watched = [];

        foreach ($watchedIds->items() as $index => $movie) {
            $watched[] = (Http::get('https://api.themoviedb.org/3/movie/' . $movie->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Users/Watched', [
            'user' => $user,
            'watched' => $watched,
            'page' => ['actual' => $watchedIds->currentPage(), 'last' => $watchedIds->lastPage()]
        ]);
    }
}
