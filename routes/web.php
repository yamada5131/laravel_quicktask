<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resources([
        'users' => UserController::class,
    ]);

    Route::get('/users/{user}/posts', [PostController::class, 'index'])->middleware(CheckAdmin::class);
    Route::get('/users/{user}/posts/create', [PostController::class, 'create'])->middleware(CheckAdmin::class);
    Route::post('/users/{user}/posts', [PostController::class, 'store'])->middleware(CheckAdmin::class);
});

// Route::get('language/{locale}', function ($locale) {
//     App::setLocale($locale);
//     Session::put('locale', $locale);
//
//     return redirect()->back();
// });

require __DIR__ . '/auth.php';
