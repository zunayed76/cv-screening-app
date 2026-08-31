<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CompanyDashboardController;

// Public Candidate Dashboard (Accessible by Guests and Logged-in Candidates)
Route::get('/', function () {
    // Redirect admin and company users directly to their portals
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::user()->role === 'company') {
            return redirect()->route('company.dashboard');
        }
    }

    return view('dashboard'); // Public job portal view
})->name('home');

// Post-Login Route Dispatcher
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('home');
    }

    return match (Auth::user()->role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'company'   => redirect()->route('company.dashboard'),
        'candidate' => view('dashboard'),
        default     => view('dashboard'),
    };
})->name('dashboard');

// Protected Admin Panel
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('vendor.adminlte.page');
    })->name('admin.dashboard');
});

// Protected Company Panel
Route::middleware(['auth', 'role:company,admin'])->prefix('company')->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
});

// Protected Candidate Actions (Applying to jobs)
Route::middleware(['auth', 'role:candidate'])->group(function () {
    // Job application POST routes will be placed here
});

// Profile Management Routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/candidate-profile', [CandidateProfileController::class, 'show'])->name('candidate-profile.show');
    Route::get('/candidate-profile/edit', [CandidateProfileController::class, 'edit'])->name('candidate-profile.edit');
    Route::put('/candidate-profile', [CandidateProfileController::class, 'update'])->name('candidate-profile.update');
    Route::delete('/candidate-profile', [CandidateProfileController::class, 'destroy'])->name('candidate-profile.destroy');
});
require __DIR__.'/auth.php';
