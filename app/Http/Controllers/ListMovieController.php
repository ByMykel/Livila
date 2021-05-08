<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ListMovie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ListMovieController extends Controller
{
    public function index()
    {
        $recentLists = ListMovie::with('user')->withCount('likes')->latest()->paginate();

        foreach ($recentLists as $index => $list) {
            $recentLists[$index]['movies_count'] = DB::table('lists_movies')->where('list_id', $list->id)->get()->count();
            $moviesId = DB::table('lists_movies')->where('list_id', $list->id)->get()->take(5)->pluck('movie_id');
            $movies = [];

            foreach ($moviesId as $id) {
                $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                    'api_key' => Config::get('services.tmdb.key'),
                    'language' => 'es-ES'
                ]);

                if ($response->ok()) {
                    $movies[] = $response->json();
                } else {
                    unset($recentLists[$index]);
                }
            }

            $recentLists[$index]['movies'] = $movies;
        }

        return Inertia::render('Lists/Index', [
            'recentLists' => $recentLists,
            'page' => ['actual' => $recentLists->currentPage(), 'last' => $recentLists->lastPage()]
        ]);
    }

    public function popular()
    {
        $popularLists = ListMovie::with('user')->withCount('likes')->orderByDesc('likes_count')->paginate();

        foreach ($popularLists as $index => $list) {
            $popularLists[$index]['movies_count'] = DB::table('lists_movies')->where('list_id', $list->id)->get()->count();
            $moviesId = DB::table('lists_movies')->where('list_id', $list->id)->get()->take(5)->pluck('movie_id');
            $movies = [];

            foreach ($moviesId as $id) {
                $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                    'api_key' => Config::get('services.tmdb.key'),
                    'language' => 'es-ES'
                ]);

                if ($response->ok()) {
                    $movies[] = $response->json();
                } else {
                    unset($popularLists[$index]);
                }
            }

            $popularLists[$index]['movies'] = $movies;
        }

        return Inertia::render('Lists/Popular', [
            'popularLists' => $popularLists,
            'page' => ['actual' => $popularLists->currentPage(), 'last' => $popularLists->lastPage()]
        ]);
    }

    public function friends()
    {
        $user = Auth::user();

        $friendsLists = ListMovie::whereHas('user', function ($query) use ($user) {
            $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })->with('user')->withCount('likes')->paginate();

        foreach ($friendsLists as $index => $list) {
            $friendsLists[$index]['movies_count'] = DB::table('lists_movies')->where('list_id', $list->id)->get()->count();
            $moviesId = DB::table('lists_movies')->where('list_id', $list->id)->get()->take(5)->pluck('movie_id');
            $movies = [];

            foreach ($moviesId as $id) {
                $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                    'api_key' => Config::get('services.tmdb.key'),
                    'language' => 'es-ES'
                ]);

                if ($response->ok()) {
                    $movies[] = $response->json();
                } else {
                    unset($friendsLists[$index]);
                }
            }

            $friendsLists[$index]['movies'] = $movies;
        }

        return Inertia::render('Lists/Friends', [
            'friendsLists' => $friendsLists,
            'page' => ['actual' => $friendsLists->currentPage(), 'last' => $friendsLists->lastPage()]
        ]);
    }

    public function create()
    {
        return Inertia::render('Lists/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'visibility' => ['required', 'boolean']
        ]);

        $list = Auth::user()->listsMovies()->create([
            'name' => $request->name,
            'description' => $request->description,
            'visibility' => $request->visibility
        ]);

        Activity::create(['type' => 'createList', 'user_id' => Auth::user()->id, 'data' => $list]);

        return redirect()->back();
    }

    public function show(ListMovie $listMovie)
    {
        $moviesId = DB::table('lists_movies')->where('list_id', $listMovie->id)->get()->pluck('movie_id');
        $watchedMoviesCount = DB::table('movies_watched')->where('user_id', Auth::user()->id)->whereIn('movie_id', $moviesId)->get()->count();
        $movies = [];

        foreach ($moviesId as $id) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        foreach ($movies as $index => $movie) {
            $likedMovie = DB::table('likes_movies')->where('user_id', Auth::user()->id)->where('movie_id', $movie['id'])->count() === 1;
            $watchedMovie = DB::table('movies_watched')->where('user_id', Auth::user()->id)->where('movie_id', $movie['id'])->count() === 1;

            if ($likedMovie) {
                $movies[$index]['liked'] = true;
            } else {
                $movies[$index]['liked'] = false;
            }

            if ($watchedMovie) {
                $movies[$index]['watched'] = true;
            } else {
                $movies[$index]['watched'] = false;
            }
        }

        $list = ListMovie::where('id', $listMovie->id)->with('user')->withCount('likes')
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->get();

        return Inertia::render('Lists/Show', [
            'list' => $list[0],
            'movies' => $movies,
            'watchedMoviesCount' => $watchedMoviesCount
        ]);
    }

    public function edit(ListMovie $listMovie)
    {
        $moviesId = DB::table('lists_movies')->where('list_id', $listMovie->id)->get()->pluck('movie_id');
        $movies = [];

        foreach ($moviesId as $id) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        return Inertia::render('Lists/Edit', [
            'list' => $listMovie,
            'movies' => $movies
        ]);
    }

    public function update(Request $request, ListMovie $listMovie)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'visibility' => ['required', 'boolean'],
            'removedMovies.*' => ['integer']
        ]);

        $listMovie->update([
            'name' => $request->name,
            'description' => $request->description,
            'visibility' => $request->visibility
        ]);

        DB::table('lists_movies')->where('list_id', $listMovie->id)->whereIn('movie_id', $request->removedMovies)->delete();

        return redirect()->back();
    }

    public function destroy(ListMovie $listMovie)
    {
        DB::table('activities')->where('type', 'createList')->where('user_id', Auth::user()->id)->where('data->id',  $listMovie->id)->delete();

        $listMovie->delete();

        return redirect()->back();
    }

    public function lists(User $user)
    {
        $listsId = ListMovie::where('user_id', $user->id)->with('user')->withCount('likes')->orderBy('updated_at', 'desc')->paginate(8);
        $lists = $listsId->items();

        foreach ($listsId->items() as $index => $list) {
            $lists[$index]['movies_count'] = DB::table('lists_movies')->where('list_id', $list->id)->get()->count();
            $moviesId = DB::table('lists_movies')->where('list_id', $list->id)->get()->take(5)->pluck('movie_id');
            $movies = [];

            foreach ($moviesId as $id) {
                $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                    'api_key' => Config::get('services.tmdb.key'),
                    'language' => 'es-ES'
                ]);

                if ($response->ok()) {
                    $movies[] = $response->json();
                } else {
                    unset($lists[$index]);
                }
            }

            $lists[$index]['movies'] = $movies;
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Users/Lists', [
            'user' => $user,
            'lists' => $lists,
            'page' => ['actual' => $listsId->currentPage(), 'last' => $listsId->lastPage()]
        ]);
    }

    public function list(ListMovie $listMovie, $id)
    {
        $movie = DB::table('lists_movies')->where('list_id', $listMovie->id)->where('movie_id', $id);

        if ($movie->first()) {
            $movie->delete();

            DB::table('activities')->where('type', 'addList')->where('user_id', Auth::user()->id)->where('data->id',  $listMovie->id)->delete();
        } else {
            DB::table('lists_movies')->insert([
                'list_id' => $listMovie->id,
                'movie_id' => $id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);

            $data = $listMovie;
            $data['movie'] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();;

            Activity::create(['type' => 'addList', 'user_id' => Auth::user()->id, 'data' => $data]);
        }

        return redirect()->back();
    }

    public function like(ListMovie $listMovie)
    {
        $list = DB::table('likes_lists')->where('user_id', Auth::user()->id)->where('list_id', $listMovie->id);

        if ($list->first()) {
            $list->delete();

            DB::table('activities')->where('type', 'likeList')->where('user_id', Auth::user()->id)->where('data->id', $listMovie->id)->delete();
        } else {
            DB::table('likes_lists')->insert([
                'user_id' => Auth::user()->id,
                'list_id' => $listMovie->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);

            $data = $listMovie;
            $data['user'] = User::find($listMovie->user_id);

            Activity::create(['type' => 'likeList', 'user_id' => Auth::user()->id, 'data' => $data]);
        }

        return redirect()->back();
    }
}
