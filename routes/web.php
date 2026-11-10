<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return view('admin.verifications.index');
        } elseif ($user->role === 'food_provider') {
            return view('provider.dashboard');
        } else {
            return view('recipient.dashboard');
        }
    })->name('dashboard');

    // Admin Verification Management Routes
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        // If you haven't set up a Gate/middleware for 'can:admin', we can protect it using role checks in the controller.
    });

    // Let's protect admin routes explicitly checking role in controller or simple middleware closure:
    Route::get('/admin/verifications', [AdminController::class, 'index'])->name('admin.verifications');
    Route::get('/admin/verifications/{id}', [AdminController::class, 'show'])->name('admin.verifications.show');
    Route::post('/admin/verifications/{id}/update', [AdminController::class, 'updateStatus'])->name('admin.verifications.update');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});