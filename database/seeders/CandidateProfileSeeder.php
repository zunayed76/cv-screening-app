<?php

namespace Database\Seeders;

use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CandidateProfileSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wipe old files in storage
        Storage::disk('public')->deleteDirectory('cvs');
        Storage::disk('public')->makeDirectory('cvs');

        // 2. Truncate table
        Schema::disableForeignKeyConstraints();
        CandidateProfile::truncate();
        Schema::enableForeignKeyConstraints();

        // 3. Fetch or generate candidates
        $candidates = User::where('role', 'candidate')->get();

        if ($candidates->isEmpty()) {
            $candidates = User::factory()->count(10)->create([
                'role' => 'candidate',
            ]);
        }

        // 4. Create 1 PDF profile per user
        foreach ($candidates as $user) {
            CandidateProfile::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}