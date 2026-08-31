<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        // Example stats - replace with your actual models/queries
        $stats = [
            'total_candidates'  => CandidateProfile::count(),
            'new_candidates'    => CandidateProfile::where('created_at', '>=', now()->subDays(7))->count(),
            'active_jobs'       => 12, // Replace with your Job model count e.g., Job::where('status', 'active')->count()
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