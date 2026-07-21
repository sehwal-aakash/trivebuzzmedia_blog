<?php

use App\Http\Controllers\Api\Admin\AdminApiController;
use App\Http\Controllers\Api\Author\PostApiController as AuthorPostApiController;
use App\Http\Controllers\Api\Public\CategoryApiController;
use App\Http\Controllers\Api\Public\CommentApiController;
use App\Http\Controllers\Api\Public\PostApiController as PublicPostApiController;
use App\Http\Controllers\Api\Public\TagApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public APIs (Rate limited)
Route::middleware('throttle:60,1')->name('api.')->group(function () {
    Route::get('/posts', [PublicPostApiController::class, 'index'])->name('posts.index');
    Route::get('/posts/{slug}', [PublicPostApiController::class, 'show'])->name('posts.show');
    Route::get('/categories', [CategoryApiController::class, 'index'])->name('categories.index');
    Route::get('/tags', [TagApiController::class, 'index'])->name('tags.index');
    Route::post('/comments', [CommentApiController::class, 'store'])->name('comments.store');
});

// Author APIs (Auth protected)
Route::middleware(['auth', 'role:approved_author,admin,editor,super_admin'])->prefix('author')->name('api.author.')->group(function () {
    Route::apiResource('posts', AuthorPostApiController::class);
});

// Admin APIs (Auth protected)
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/dashboard', [AdminApiController::class, 'dashboard'])->name('dashboard');
    Route::post('/applications/{application}/approve', [AdminApiController::class, 'approveAuthor'])->name('applications.approve');
    Route::post('/applications/{application}/reject', [AdminApiController::class, 'rejectAuthor'])->name('applications.reject');
});
