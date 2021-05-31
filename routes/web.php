<?php

use App\Http\Controllers\CastController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ListMovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('search/{query?}')->group(function () {
    Route::get('/', [SearchController::class, 'movies'])->name('search');
    Route::get('/reviews', [SearchController::class, 'reviews'])->name('search.reviews');
    Route::get('/lists', [SearchController::class, 'lists'])->name('search.lists');
    Route::get('/members', [SearchController::class, 'members'])->name('search.members');
});

Route::prefix('lists')->group(function () {
    Route::get('/', [ListMovieController::class, 'index'])->name('lists');
    Route::get('/popular', [ListMovieController::class, 'popular'])->name('lists.popular');
    Route::get('/friends', [ListMovieController::class, 'friends'])->name('lists.friends')->middleware(['auth:sanctum', 'verified']);
    Route::get('/create', [ListMovieController::class, 'create'])->name('lists.create')->middleware(['auth:sanctum', 'verified']);
    Route::post('/store', [ListMovieController::class, 'store'])->name('lists.store')->middleware(['auth:sanctum', 'verified']);

    Route::prefix('{listMovie}')->group(function () {
        Route::get('/', [ListMovieController::class, 'show'])->name('lists.show');
        Route::post('/like', [ListMovieController::class, 'handleLike'])->name('lists.like')->middleware(['auth:sanctum', 'verified']);
        Route::post('/store/{movie}', [ListMovieController::class, 'handleList'])->name('lists.store.movie');

        Route::middleware(['auth:sanctum', 'verified'])->group(function () {
            Route::get('/edit', [ListMovieController::class, 'edit'])->name('lists.edit')->middleware(['auth:sanctum', 'verified']);
            Route::post('/update', [ListMovieController::class, 'update'])->name('lists.update')->middleware(['auth:sanctum', 'verified']);
            Route::delete('/destroy', [ListMovieController::class, 'destroy'])->name('lists.destroy')->middleware(['auth:sanctum', 'verified']);
        });
    });
});

Route::prefix('cast')->group(function () {
    Route::get('/{id}', [CastController::class, 'show'])->name('cast.show');
});

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('movies');

    Route::prefix('{movie}')->group(function () {
        Route::get('/', [MovieController::class, 'show'])->name('movies.show');

        Route::prefix('cast')->group(function () {
            Route::get('/', [CastController::class, 'index'])->name('cast.index');
        });

        Route::middleware(['auth:sanctum', 'verified'])->group(function () {
            Route::post('/like', [MovieController::class, 'handleLike'])->name('movies.like');
            Route::post('/watch', [MovieController::class, 'handleWatch'])->name('movies.watch');
        });

        Route::prefix('reviews')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('movies.reviews.index');
            Route::get('/popular', [ReviewController::class, 'popular'])->name('movies.reviews.popular');
            Route::get('/friends', [ReviewController::class, 'friends'])->name('movies.reviews.friends')->middleware(['auth:sanctum', 'verified']);
            Route::post('/store', [ReviewController::class, 'store'])->name('movies.reviews.store')->middleware(['auth:sanctum', 'verified']);


            Route::prefix('{review}')->group(function () {
                Route::middleware(['auth:sanctum', 'verified'])->group(function () {
                    Route::post('/update', [ReviewController::class, 'update'])->name('movies.reviews.update');
                    Route::delete('/destroy', [ReviewController::class, 'destroy'])->name('movies.reviews.destroy');
                    Route::post('/like', [ReviewController::class, 'handleLike'])->name('movies.reviews.like');
                });
            });
        });
    });
});

Route::prefix('u')->group(function () {
    Route::prefix('{user:username}')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('user');
        Route::post('/follow', [UserController::class, 'follow'])->name('user.follow')->middleware(['auth:sanctum', 'verified']);
        Route::get('/following', [UserController::class, 'following'])->name('user.following');
        Route::get('/followers', [UserController::class, 'followers'])->name('user.followers');
        Route::get('/watched', [MovieController::class, 'watchedMovies'])->name('user.watched');
        Route::get('/reviews', [ReviewController::class, 'reviews'])->name('user.reviews');
        Route::get('/lists', [ListMovieController::class, 'lists'])->name('user.lists');

        Route::prefix('likes')->group(function () {
            Route::get('/movies', [LikeController::class, 'movies'])->name('user.likes.movies');
            Route::get('/lists', [LikeController::class, 'lists'])->name('user.likes.lists');
            Route::get('/reviews', [LikeController::class, 'reviews'])->name('user.likes.reviews');
        });
    });
});
