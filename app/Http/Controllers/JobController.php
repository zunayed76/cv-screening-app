<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser;

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
    /**
     * Display Job Details and candidate rankings calculated by Python AI.
     */
    public function show($id)
    {
        $job = Job::with(['applications.candidate.candidateProfile'])->findOrFail($id);

        // 1. Prepare candidates payload using the cv_text accessor from CandidateProfile model
        $candidatePayload = $job->applications->map(function ($app) {
            return [
                'id'   => $app->id, // JobApplication primary key
                'text' => $app->candidate?->candidateProfile?->cv_text ?? 'No candidate profile details provided.',
            ];
        })->toArray();

        // 2. Post to Python FastAPI AI Scoring service
        if (!empty($candidatePayload)) {
            try {
                $response = Http::timeout(15)->post('http://127.0.0.1:8000/score', [
                    'job_description' => $job->description,
                    'candidates'      => $candidatePayload,
                ]);

                if ($response->successful()) {
                    $rankings = $response->json()['rankings'] ?? [];

                    foreach ($rankings as $rank) {
                        JobApplication::where('id', $rank['candidate_id'])->update([
                            'embedding_score' => $rank['embedding_score'] ?? $rank['score'] ?? 0,
                            'keyword_score'   => $rank['keyword_score'] ?? 0,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Microservice offline: fallback gracefully to last calculated DB scores
            }
        }

        // 3. Retrieve applications ordered by top embedding match
        $applications = JobApplication::with('candidate.candidateProfile')
            ->where('job_id', $job->id)
            ->orderByDesc('embedding_score')
            ->get();

        return view('jobs.show', compact('job', 'applications'));
    }
    public function destroy(Job $job)
    {
        abort_if($job->user_id !== Auth::id(), 403);

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job posting deleted successfully.');
    }
}