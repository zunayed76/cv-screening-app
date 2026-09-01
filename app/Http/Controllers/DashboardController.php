<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->role === 'company') {
                return redirect()->route('company.dashboard');
            }
        }

        $jobs = Job::with('company')->latest()->paginate(6);

        // Fetch user candidate profile and existing applications if logged in
        $profile = Auth::check() ? Auth::user()->candidateProfile : null;
        $appliedJobIds = Auth::check() 
            ? JobApplication::where('user_id', Auth::id())->pluck('job_id')->toArray() 
            : [];

        if ($request->ajax()) {
            return view('partials.job-cards', compact('jobs', 'appliedJobIds'))->render();
        }

        return view('dashboard', compact('jobs', 'profile', 'appliedJobIds'));
    }
}