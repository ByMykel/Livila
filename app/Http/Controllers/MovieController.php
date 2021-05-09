<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ListMovie;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use App\Services\TMDB\TmdbMoviesInformationApi;

class MovieController extends Controller
{
    protected $tmdbApi;

    public function __construct(TmdbMoviesInformationApi $tmdbApi)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = new Movie();
        $this->listMovie = new ListMovie();
    }

    public function index(Request $request)
    {
        $popular = $this->tmdbApi->getPopular($request->page ?? 1);

        $popular['results'] = $this->movie->markWatchedMovies($popular['results']);
        $popular['results'] = $this->movie->markLikedMovies($popular['results']);

        return Inertia::render('Movies/Index', [
            'popular' => $popular,
            'page' => ['actual' => intval($request->page ?? 1), 'last' => intval($popular['total_pages']) / 2]
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $movie = $this->tmdbApi->getMovie($id);

        $myReview = Review::where('user_id', Auth::user()->id)
            ->where('movie_id', $id)
            ->get();

        $friendsReviews = Review::whereHas('user', function ($query) use ($user) {
            $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })
            ->where('movie_id', $id)
            ->latest()
            ->take(5)
            ->get();

        $popularReviews = Review::where('movie_id', $id)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->latest('likes_count')
            ->take(5)
            ->get();

        $recentReviews = Review::where('movie_id', $id)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        foreach ($friendsReviews as $index => $_review) {
            $friendsReviews[$index]['movie'] = $movie;
        }

        foreach ($popularReviews as $index => $_review) {
            $popularReviews[$index]['movie'] = $movie;
        }

        foreach ($recentReviews as $index => $_review) {
            $recentReviews[$index]['movie'] = $movie;
        }

        $movie = $this->movie->markWatchedMovies([$movie])[0];
        $movie = $this->movie->markLikedMovies([$movie])[0];

        $lists = ListMovie::where('user_id', Auth::user()->id)
            ->get();

        $lists = $this->listMovie->markListWithMovie($lists, $id);

        return Inertia::render('Movies/Show', [
            'movie' => $movie,
            'myReview' => $myReview,
            'friendsReviews' => $friendsReviews,
            'popularReviews' => $popularReviews,
            'recentReviews' => $recentReviews,
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
