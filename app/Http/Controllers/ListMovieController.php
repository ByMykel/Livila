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
        $popularLists = ListMovie::withCount('likes')->orderByDesc('likes_count')->get()->take(10);

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
        $movies = [];

        foreach ($moviesId as $id) {
            $movies[] = (Http::get('https://api.themoviedb.org/3/movie/' . $id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]))->json();
        }

        return Inertia::render('Lists/Show', [
            'list' => ListMovie::where('id', $listMovie->id)->with('user')->get(),
            'movies' => $movies
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
            'visibility' => ['required', 'boolean']
        ]);

        $listMovie->update([
            'name' => $request->name,
            'description' => $request->description,
            'visibility' => $request->visibility
        ]);

        return redirect()->back();
    }

    public function destroy(ListMovie $listMovie)
    {
        $listMovie->delete();

        return redirect()->back();
    }

    public function lists(User $user)
    {
        $lists = ListMovie::whereIn('id', $user->listsMovies()->pluck('id'))->orderBy('updated_at', 'DESC')->get();

        return Inertia::render('Users/Lists', [
            'lists' => $lists
        ]);
    }
}
