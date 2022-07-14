<?php

use App\Http\Controllers\LikesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;


Route::redirect('/', 'login');
Route::redirect('/', 'register');

Route::get('/hola', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/', [PageController::class, 'home'])->name('home');

/*Own videos*/
Route::get('{user:name}', [UserController::class, 'index'])->name('userVideos');
Route::resource('videos', VideoController::class);
Route::post('subscribe', [UserController::class, 'subscribe']);
Route::delete('unsubscribe', [UserController::class, 'unsubscribe'])->name('unsubscribe');
Route::post('videos/subscribe', [VideoController::class, 'subscribe']);
Route::post('videos/like', [VideoController::class, 'like'])->name('like');
Route::delete('unlike', [VideoController::class, 'unlike'])->name('unlike');
Route::post('videos/dislike', [VideoController::class, 'dislike'])->name('dislike');
Route::delete('undislike', [VideoController::class, 'undislike'])->name('undislike');
