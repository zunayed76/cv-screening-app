<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\Job;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        // Example stats - replace with your actual models/queries
        $stats = [
            'total_candidates'  => CandidateProfile::count(),
            'new_candidates'    => CandidateProfile::where('created_at', '>=', now()->subDays(7))->count(),
            'active_jobs'       => Job::where('user_id', auth()->id())->whereDate('deadline', '>=', now())->count(),
            'total_applications'=> 48, // Replace with Application count
        ];

        // Fetch recent candidates or job applications
        $recentCandidates = CandidateProfile::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('company.dashboard', compact('stats', 'recentCandidates'));
    }
}