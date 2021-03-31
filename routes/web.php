<?php

use App\Http\Controllers\ListMovieController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [MovieController::class, 'home'])->name('home');

Route::prefix('lists')->group(function () {
    Route::get('/', [ListMovieController::class, 'index'])->name('lists');
    Route::get('/create', [ListMovieController::class, 'create'])->name('lists.create')->middleware(['auth:sanctum', 'verified']);

    Route::prefix('{listMovie}')->group(function () {
        Route::get('/', [ListMovieController::class, 'show'])->name('lists.show');

        Route::middleware(['auth:sanctum', 'verified'])->group(function () {
            Route::get('/edit', [ListMovieController::class, 'edit'])->name('lists.edit');
            Route::get('/update', [ListMovieController::class, 'update'])->name('lists.update');
            Route::get('/destroy', [ListMovieController::class, 'destroy'])->name('lists.destroy');
        });
    });
});

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('movies');

    Route::prefix('{movie}')->group(function () {
        Route::get('/', [MovieController::class, 'show'])->name('movies.show');

        Route::middleware(['auth:sanctum', 'verified'])->group(function () {
            Route::get('/like', [MovieController::class, 'like'])->name('movies.like');
            Route::get('/watch', [MovieController::class, 'watch'])->name('movies.watch');
        });

        Route::prefix('reviews')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('movies.reviews.index');

            Route::middleware(['auth:sanctum', 'verified'])->group(function () {
                Route::prefix('{review}')->group(function () {
                    Route::get('/', [ReviewController::class, 'show'])->name('movies.reviews.show');
                    Route::get('/like', [ReviewController::class, 'like'])->name('movies.reviews.like');
                });
            });
        });
    });
});

Route::prefix('user')->group(function () {

    Route::prefix('{user:username}')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('user');
        Route::post('/follow', [UserController::class, 'follow'])->name('user.follow')->middleware(['auth:sanctum', 'verified']);
        Route::get('/following', [UserController::class, 'following'])->name('user.following');
        Route::get('/followers', [UserController::class, 'followers'])->name('user.followers');
        Route::get('/movies', [MovieController::class, 'movies'])->name('user.movies');
        Route::get('/reviews', [ReviewController::class, 'reviews'])->name('user.reviews');
        Route::get('/lists', [ListMovieController::class, 'lists'])->name('user.lists');

        Route::prefix('likes')->group(function () {
            Route::get('/', [LikeController::class, 'index'])->name('user.likes');
            Route::get('/movies', [LikeController::class, 'movies'])->name('user.likes.movies');
            Route::get('/lists', [LikeController::class, 'lists'])->name('user.likes.lists');
            Route::get('/reviews', [LikeController::class, 'reviews'])->name('user.likes.reviews');
        });
    });
});
