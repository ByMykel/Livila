<?php

namespace App\Http\Controllers;

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
        $popularLists = ListMovie::with('user')->withCount('likes')->orderByDesc('likes_count')->get();

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

        return Inertia::render('Lists/Index', [
            'popularLists' => $popularLists
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

        Auth::user()->listsMovies()->create([
            'name' => $request->name,
            'description' => $request->description,
            'visibility' => $request->visibility
        ]);

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

        $list = ListMovie::where('id', $listMovie->id)->with('user')->withCount('likes')->get();

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
        } else {
            DB::table('lists_movies')->insert([
                'list_id' => $listMovie->id,
                'movie_id' => $id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        return redirect()->back();
    }
}
