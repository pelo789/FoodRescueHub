
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('login');
});

// GUEST ROUTES (Login & Register)
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

// AUTHENTICATED ROUTES
Route::middleware('auth')->group(function () {

    // UNIFIED DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ADMIN VERIFICATION MANAGEMENT
    Route::get('/admin/verifications', [AdminController::class, 'index'])
        ->name('admin.verifications');

    Route::get('/admin/verifications/{id}', [AdminController::class, 'show'])
        ->name('admin.verifications.show');

    Route::post('/admin/verifications/{id}/update', [AdminController::class, 'updateStatus'])
        ->name('admin.verifications.update');

    // PROTECTED ACTION ROUTES
    Route::middleware('verified.org')->group(function () {
        // Food Provider & Recipient Organization routes
    });

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
