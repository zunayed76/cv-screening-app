<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $user = Auth::user();

        // Check if candidate profile and CV exist
        if (!$user->candidateProfile || !$user->candidateProfile->cv_path) {
            return back()->with('error', 'You must complete your candidate profile and upload your CV before applying.');
        }

        JobApplication::firstOrCreate([
            'user_id' => $user->id,
            'job_id'  => $job->id,
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }
}