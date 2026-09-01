<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;

// Public Home & Post-Login Dispatcher (Handles Guests & Candidates)
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');
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
Route::middleware(['auth', 'role:company'])->group(function () {
    Route::resource('jobs', JobController::class);
});
require __DIR__.'/auth.php';
