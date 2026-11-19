<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationVerificationController;
use Illuminate\Support\Facades\Route;

// ROOT ROUTE
Route::get('/', function () {
    return redirect()->route('login');
});

// GUEST ROUTES
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

// AUTHENTICATED AND ACTIVE ACCOUNT ROUTES
Route::middleware(['auth', 'account.active'])->group(function () {

    // UNIFIED DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ADMIN VERIFICATION & USER MANAGEMENT
    Route::middleware('administrator')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/verifications', [
                AdminController::class,
                'index'
            ])->name('verifications.index');

            Route::get('/verifications/{organization}', [
                AdminController::class,
                'show'
            ])->name('verifications.show');

            Route::get('/verifications/{organization}/document', [
                AdminController::class,
                'viewDocument'
            ])->name('verifications.document');

            Route::post('/verifications/{organization}/status', [
                AdminController::class,
                'updateStatus'
            ])->name('verifications.updateStatus');

            Route::get('/users', [
                AdminController::class,
                'users'
            ])->name('users.index');

        });
        Route::get('/organization/verification/document', [
            OrganizationVerificationController::class,
            'viewOwnDocument'
        ])->name('organization.verification.document');

    // ORGANIZATION VERIFICATION RESUBMISSION
    // Must remain outside organization.verified middleware.
    Route::post('/organization/verification/resubmit', [
        OrganizationVerificationController::class,
        'resubmit'
    ])->name('organization.verification.resubmit');

    // ORGANIZATION VERIFICATION PROTECTED ROUTES
    Route::middleware('organization.verified')->group(function () {

        // Food Provider and Recipient Organization
        // Redistribution feature routes will go here.

    });

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});