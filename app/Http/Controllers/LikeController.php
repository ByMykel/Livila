<?php

namespace App\Http\Controllers;

use App\Models\ListMovie;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class LikeController extends Controller
{
    protected $tmdbApi;
    protected $movie;
    protected $user;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie, User $user, ListMovie $listMovie)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
        $this->user = $user;
        $this->listMovie = $listMovie;
    }

    public function movies(User $user)
    {
        $moviesIds = $this->movie->getLikedMoviesIds($user);

        $ids = array_map(function ($movie) {
            return $movie->movie_id;
        }, $moviesIds->items());

        $movies = $this->tmdbApi->getMoviesById($ids);

        $movies = $this->movie->markWatchedMovies($movies);
        $movies = $this->movie->markLikedMovies($movies);

        $user = $this->user->getUser($user);

        return Inertia::render('Likes/Movies', [
            'user' => $user,
            'movies' => $movies,
            'page' => ['actual' => $moviesIds->currentPage(), 'last' => $moviesIds->lastPage()]
        ]);
    }

    public function lists(User $user)
    {
        $listsIds = $this->listMovie->getLikedLists($user);

        $ids = array_map(function ($lists) {
            return $lists->list_id;
        }, $listsIds->items());

        $lists = $this->listMovie->getListsByIds($ids);

        foreach ($lists as $index => $list) {
            $lists[$index]['movies_count'] = $this->listMovie->getNumberOfMoviesInAList($list);
            $listMoviesId = $this->listMovie->getMoviesFromAList($list, 5);
            $listsMovies = $this->tmdbApi->getMoviesById($listMoviesId);
            $lists[$index]['movies'] = $listsMovies;
        }

        $user = $this->user->getUser($user);

        return Inertia::render('Likes/Lists', [
            'user' => $user,
            'lists' => $lists,
            'page' => ['actual' => $listsIds->currentPage(), 'last' => $listsIds->lastPage()]
        ]);
    }

    public function reviews(User $user)
    {
        $reviewsId = DB::table('likes_reviews')->where('user_id', $user->id)->latest()->select('review_id')->paginate(8);
        $ids = array_map(function ($reviews) {
            return $reviews->review_id;
        }, $reviewsId->items());
        $reviews = Review::whereIn('id', $ids)->with('user')->withCount('likes')->withcount(['likes as like' => function ($q) {
            return $q->where('user_id', Auth::id());
        }])->latest()->get();

        foreach ($reviews as $index => $review) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $review->movie_id, [
                'api_key' => Config::get('services.tmdb.key'),
                'language' => 'es-ES'
            ]);

            if ($response->ok()) {
                $reviews[$index]['movie'] = $response->json();
            } else {
                unset($reviews[$index]);
            }
        }

        $user = User::where('id', $user->id)->withcount(['followers as follow' => function ($q) {
            return $q->where('follower_id', Auth::id());
        }])->get()[0];

        return Inertia::render('Likes/Reviews', [
            'user' => $user,
            'reviews' => $reviews,
            'page' => ['actual' => $reviewsId->currentPage(), 'last' => $reviewsId->lastPage()]
        ]);
    }
}
