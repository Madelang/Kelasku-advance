<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('users', UserController::class)->names('users');
    Route::resource('admins', AdminController::class)->names('admins');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';



Route::fallback(function () {
    if (!request()->is('public/*')) {
        return redirect('/login');
    }
    abort(404);
});
