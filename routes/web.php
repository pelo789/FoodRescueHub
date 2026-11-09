
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\VerificationController;

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

Route::middleware(['auth', 'account.active'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::middleware('administrator')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/verifications', [
                VerificationController::class,
                'index'
            ])->name('verifications.index');

            Route::get('/verifications/{user}/document', [
                VerificationController::class,
                'viewDocument'
            ])->name('verifications.document');

            Route::patch('/verifications/{user}/approve', [
                VerificationController::class,
                'approve'
            ])->name('verifications.approve');

            Route::patch('/verifications/{user}/reject', [
                VerificationController::class,
                'reject'
            ])->name('verifications.reject');
        });

    Route::middleware('organization.verified')->group(function () {
        // Add redistribution feature routes here.
    });
});
