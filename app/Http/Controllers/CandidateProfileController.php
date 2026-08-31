<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Http\Requests\CandidateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateProfileController extends Controller
{
    // Display the authenticated user's profile
    public function show()
    {
        $profile = auth()->user()->candidateProfile;
        return view('candidate_profile.show', compact('profile'));
    }

    // Show form to edit or create profile
    public function edit()
    {
        $profile = auth()->user()->candidateProfile ?? new CandidateProfile();
        return view('candidate_profile.edit', compact('profile'));
    }

    // Store or Update profile (Upsert pattern)
    public function update(CandidateProfileRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        // Handle CV upload if present
        if ($request->hasFile('cv')) {
            if ($user->candidateProfile?->cv_path) {
                Storage::disk('public')->delete($user->candidateProfile->cv_path);
            }
            $validated['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        // Convert skills input to array if received as a comma-separated string
        // if (isset($validated['skills']) && is_string($validated['skills'])) {
        //     $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        // }

        $user->candidateProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('candidate-profile.show')->with('success', 'Profile updated successfully.');
    }

    // Delete profile and associated file
    public function destroy()
    {
        $profile = auth()->user()->candidateProfile;

        if ($profile) {
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $profile->delete();
        }

        return redirect()->route('candidate-profile.show')->with('success', 'Profile deleted successfully.');
    }
}