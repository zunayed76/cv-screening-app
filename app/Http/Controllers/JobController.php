<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'type'        => 'required|in:full-time,part-time,contract,remote',
            'description' => 'required|string',
            'deadline'    => 'nullable|date|after_or_equal:today',
        ]);

        $validated['user_id'] = Auth::id();
        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job opportunity posted successfully!');
    }

    public function edit(Job $job)
    {
        // Ensure companies can only edit their own jobs
        abort_if($job->user_id !== Auth::id(), 403);

        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        abort_if($job->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'type'        => 'required|in:full-time,part-time,contract,remote',
            'description' => 'required|string',
            'deadline'    => 'nullable|date',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.index')->with('success', 'Job posting updated successfully!');
    }

    public function destroy(Job $job)
    {
        abort_if($job->user_id !== Auth::id(), 403);

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job posting deleted successfully.');
    }
}