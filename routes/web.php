<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ListMovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ActivityController::class, 'index'])->name('home');

Route::prefix('lists')->group(function () {
    Route::get('/', [ListMovieController::class, 'index'])->name('lists');
    Route::get('/create', [ListMovieController::class, 'create'])->name('lists.create')->middleware(['auth:sanctum', 'verified']);
    Route::post('/store', [ListMovieController::class, 'store'])->name('lists.store')->middleware(['auth:sanctum', 'verified']);

    Route::prefix('{listMovie}')->group(function () {
        Route::get('/', [ListMovieController::class, 'show'])->name('lists.show');
        Route::post('/like', [ListMovieController::class, 'like'])->name('lists.like');
        Route::post('/store/{movie}', [ListMovieController::class, 'list'])->name('lists.store.movie');

        Route::middleware(['auth:sanctum', 'verified'])->group(function () {
            Route::get('/edit', [ListMovieController::class, 'edit'])->name('lists.edit');
            Route::post('/update', [ListMovieController::class, 'update'])->name('lists.update');
            Route::delete('/destroy', [ListMovieController::class, 'destroy'])->name('lists.destroy');
        });
    });
});

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('movies');

    Route::prefix('{movie}')->group(function () {
        Route::get('/', [MovieController::class, 'show'])->name('movies.show');

        Route::middleware(['auth:sanctum', 'verified'])->group(function () {
            Route::post('/like', [MovieController::class, 'like'])->name('movies.like');
            Route::post('/watch', [MovieController::class, 'watch'])->name('movies.watch');
        });

        Route::prefix('reviews')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('movies.reviews.index');
            Route::get('/popular', [ReviewController::class, 'popular'])->name('movies.reviews.popular');
            Route::get('/friends', [ReviewController::class, 'friends'])->name('movies.reviews.friends');
            Route::post('/store', [ReviewController::class, 'store'])->name('movies.reviews.store')->middleware(['auth:sanctum', 'verified']);


            Route::prefix('{review}')->group(function () {
                Route::middleware(['auth:sanctum', 'verified'])->group(function () {
                    Route::post('/update', [ReviewController::class, 'update'])->name('movies.reviews.update');
                    Route::delete('/destroy', [ReviewController::class, 'destroy'])->name('movies.reviews.destroy');
                    Route::post('/like', [ReviewController::class, 'like'])->name('movies.reviews.like');
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
        Route::get('/watched', [MovieController::class, 'watched'])->name('user.watched');
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
