<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListMovieRequest;
use App\Http\Requests\UpdateListMovieRequest;
use App\Models\ListMovie;
use App\Models\Movie;
use App\Models\User;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListMovieController extends Controller
{
    protected $tmdbApi;
    protected $movie;
    protected $listMovie;
    protected $user;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie, ListMovie $listMovie, User $user)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
        $this->listMovie = $listMovie;
        $this->user = $user;
    }

    public function index()
    {
        $recentLists = $this->listMovie->getRecentLists();

        foreach ($recentLists->items() as $index => $list) {
            $recentLists[$index]['movies_count'] = $this->listMovie->getNumberOfMoviesInAList($list);
            $listMoviesIds = $this->listMovie->getMoviesFromAList($list, 5);

            $ids = array_map(function ($movie) {
                return $movie->movie_id;
            }, $listMoviesIds->items());

            $listsMovies = $this->tmdbApi->getMoviesById($ids);
            $recentLists[$index]['movies'] = $listsMovies;
        }

        return Inertia::render('Lists/Index', [
            'recentLists' => $recentLists->items(),
            'page' => ['actual' => $recentLists->currentPage(), 'last' => $recentLists->lastPage()]
        ]);
    }

    public function popular()
    {
        $popularLists = $this->listMovie->getPopularLists();

        foreach ($popularLists->items() as $index => $list) {
            $popularLists[$index]['movies_count'] = $this->listMovie->getNumberOfMoviesInAList($list);
            $listMoviesIds = $this->listMovie->getMoviesFromAList($list, 5);

            $ids = array_map(function ($movie) {
                return $movie->movie_id;
            }, $listMoviesIds->items());

            $listsMovies = $this->tmdbApi->getMoviesById($ids);
            $popularLists[$index]['movies'] = $listsMovies;
        }

        return Inertia::render('Lists/Popular', [
            'popularLists' => $popularLists->items(),
            'page' => ['actual' => $popularLists->currentPage(), 'last' => $popularLists->lastPage()]
        ]);
    }

    public function friends()
    {
        $friendsLists = $this->listMovie->getFriendsLists();

        if (count($friendsLists) === 0) {
            return Inertia::render('Lists/Friends', [
                'friendsLists' => [],
                'page' => ['actual' => 1, 'last' => 1]
            ]);
        }

        foreach ($friendsLists->items() as $index => $list) {
            $friendsLists[$index]['movies_count'] = $this->listMovie->getNumberOfMoviesInAList($list);
            $listMoviesIds = $this->listMovie->getMoviesFromAList($list, 5);

            $ids = array_map(function ($movie) {
                return $movie->movie_id;
            }, $listMoviesIds->items());

            $listsMovies = $this->tmdbApi->getMoviesById($ids);
            $friendsLists[$index]['movies'] = $listsMovies;
        }

        return Inertia::render('Lists/Friends', [
            'friendsLists' => $friendsLists->items(),
            'page' => ['actual' => $friendsLists->currentPage(), 'last' => $friendsLists->lastPage()]
        ]);
    }

    public function create()
    {
        return Inertia::render('Lists/Create');
    }

    public function store(StoreListMovieRequest $request)
    {
        $list = $this->listMovie->createListMovie($request->name, $request->description, $request->visibility);

        if ($request->returnBack) {
            return redirect()->back();
        }

        return redirect()->route('lists.show', $list->id);
    }

    public function show(ListMovie $listMovie)
    {
        if (Auth::id() != $listMovie->user_id && !$listMovie->visibility) {
            return abort(403);
        }

        $moviesIds = $this->listMovie->getMoviesFromAList($listMovie);

        $ids = array_map(function ($movie) {
            return $movie->movie_id;
        }, $moviesIds->items());

        $watchedMoviesCount = $this->listMovie->getNumberOfWatchedMoviesInAList($ids);

        $movies = $this->tmdbApi->getMoviesById($ids);
        $movies = $this->movie->markWatchedMovies($movies);
        $movies = $this->movie->markLikedMovies($movies);

        $list = $this->listMovie->getListById($listMovie->id);

        return Inertia::render('Lists/Show', [
            'list' => $list,
            'movies' => $movies,
            'watchedMoviesCount' => $watchedMoviesCount,
            'page' => ['actual' => $moviesIds->currentPage(), 'last' => $moviesIds->lastPage()]
        ]);
    }

    public function edit(ListMovie $listMovie)
    {
        if (Auth::id() !== $listMovie->user_id) {
            return abort(403);
        }

        $moviesId = $this->listMovie->getAllMoviesInAList($listMovie);
        $movies = $this->tmdbApi->getMoviesById($moviesId);

        return Inertia::render('Lists/Edit', [
            'list' => $listMovie,
            'movies' => $movies
        ]);
    }

    public function update(UpdateListMovieRequest $request, ListMovie $listMovie)
    {
        if (Auth::id() !== $listMovie->user_id) {
            return abort(403);
        }

        $this->listMovie->updateListMovie($listMovie, $request->name, $request->description, $request->visibility, $request->removedMovies);

        return redirect()->route('lists.show', $listMovie->id);
    }

    public function destroy(ListMovie $listMovie)
    {
        if (Auth::id() !== $listMovie->user_id) {
            return abort(403);
        }
        
        $listMovie->delete();

        return redirect()->route('lists');
    }

    public function lists(User $user)
    {
        $listsIds = $this->listMovie->getUserLists($user);

        foreach ($listsIds->items() as $index => $list) {
            $listsIds[$index]['movies_count'] = $this->listMovie->getNumberOfMoviesInAList($list);
            $listMoviesIds = $this->listMovie->getMoviesFromAList($list, 5);

            $ids = array_map(function ($movie) {
                return $movie->movie_id;
            }, $listMoviesIds->items());

            $listsMovies = $this->tmdbApi->getMoviesById($ids);
            $listsIds[$index]['movies'] = $listsMovies;
        }

        $user = $this->user->getUser($user);

        return Inertia::render('Users/Lists', [
            'user' => $user,
            'lists' => $listsIds->items(),
            'page' => ['actual' => $listsIds->currentPage(), 'last' => $listsIds->lastPage()]
        ]);
    }

    public function handleList(ListMovie $listMovie, $id)
    {
        $data = $listMovie;
        $data['movie'] = $this->tmdbApi->getMovieById($id);

        $this->listMovie->handleListed($listMovie, $id);

        return redirect()->back();
    }

    public function handleLike(ListMovie $listMovie)
    {
        $data = $listMovie;
        $data['user'] = User::find($listMovie->user_id);

        $this->listMovie->handleLike($listMovie);

        return redirect()->back();
    }
}
