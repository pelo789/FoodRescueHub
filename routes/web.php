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

    // Unified Dashboard Redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.verifications');
        }
        return view('dashboard');
    })->name('dashboard');

    // ADMIN VERIFICATION MANAGEMENT ROUTES
    Route::get('/admin/verifications', [AdminController::class, 'index'])->name('admin.verifications');
    Route::get('/admin/verifications/{id}', [AdminController::class, 'show'])->name('admin.verifications.show');
    Route::post('/admin/verifications/{id}/update', [AdminController::class, 'updateStatus'])->name('admin.verifications.update');

    // PROTECTED ACTION ROUTES (Only verified organizations & admins)
    Route::middleware('verified.org')->group(function () {
        // Place future Food Provider & Recipient action routes here
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // New Admin Verification Routes (Protected by 'auth')
    Route::get('/admin/verifications', [AdminController::class, 'index'])
        ->name('admin.verifications');
        
    Route::post('/admin/users/{id}/verify', [AdminController::class, 'updateVerificationStatus'])
        ->name('admin.users.verify');
});