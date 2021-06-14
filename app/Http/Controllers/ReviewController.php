<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\User;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Inertia\Inertia;

class ReviewController extends Controller
{
    protected $tmdbApi;
    protected $review;
    protected $user;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Review $review, User $user)
    {
        $this->tmdbApi = $tmdbApi;
        $this->review = $review;
        $this->user = $user;
    }

    public function index($id)
    {
        $reviews = $this->review->getRecentReviews($id);
        $movie = $this->tmdbApi->getMovieById($id);

        if (!$movie) {
            return abort(404);
        }

        foreach ($reviews->items() as $index => $_review) {
            $reviews[$index]['movie'] = $movie;
        }

        return Inertia::render('Reviews/Index', [
            'movie' => $movie,
            'reviews' => $reviews->items(),
            'page' => ['actual' => $reviews->currentPage(), 'last' => $reviews->lastPage()]
        ]);
    }

    public function popular($id)
    {
        $reviews = $this->review->getPopularReviews($id);
        $movie = $this->tmdbApi->getMovieById($id);

        if (!$movie) {
            return abort(404);
        }

        foreach ($reviews->items() as $index => $_review) {
            $reviews[$index]['movie'] = $movie;
        }

        return Inertia::render('Reviews/Popular', [
            'movie' => $movie,
            'reviews' => $reviews->items(),
            'page' => ['actual' => $reviews->currentPage(), 'last' => $reviews->lastPage()]
        ]);
    }

    public function friends($id)
    {
        $reviews = $this->review->getFriendsReviews($id);
        $movie = $this->tmdbApi->getMovieById($id);

        if (!$movie) {
            return abort(404);
        }

        if (count($reviews) === 0) {
            return Inertia::render('Reviews/Friends', [
                'movie' => $movie,
                'reviews' => [],
                'page' => ['actual' => 1, 'last' => 1]
            ]);
        }

        foreach ($reviews->items() as $index => $_review) {
            $reviews[$index]['movie'] = $movie;
        }

        return Inertia::render('Reviews/Friends', [
            'movie' => $movie,
            'reviews' => $reviews->items(),
            'page' => ['actual' => $reviews->currentPage(), 'last' => $reviews->lastPage()]
        ]);
    }

    public function store($id, ReviewRequest $request)
    {
        $this->review->createReview($id, $request->review, $request->recommended, $request->spoiler);
        $data['movie'] = $this->tmdbApi->getMovieById($id);

        return redirect()->back();
    }

    public function update($id, Review $review, ReviewRequest $request)
    {
        $this->review->updateReview($review, $request->review, $request->recommended, $request->spoiler);

        return redirect()->back();
    }

    public function destroy($id, Review $review)
    {
        $review->delete();

        return redirect()->back();
    }

    public function handleLike($id, Review $review)
    {
        $data['user'] = User::find($review->user_id);
        $data['movie'] = $this->tmdbApi->getMovieById($id);

        $this->review->handleLike($review);

        return redirect()->back();
    }

    public function reviews(User $user)
    {
        $reviews = $this->review->getUserReviews($user);
        $user = $this->user->getUser($user);

        foreach ($reviews->items() as $index => $review) {
            $reviews[$index]['movie'] = $this->tmdbApi->getMovieById($review->movie_id);
        }

        return Inertia::render('Users/Reviews', [
            'user' => $user,
            'reviews' => $reviews->items(),
            'page' => ['actual' => $reviews->currentPage(), 'last' => $reviews->lastPage()]
        ]);
    }
}
