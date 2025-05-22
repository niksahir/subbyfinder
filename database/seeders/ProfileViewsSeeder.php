<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileViewsSeeder extends Seeder
{
    public function run()
    {
        $userId = 1;
        $userType = 'contractor';
        $profileType = 'subcontractor_project';
        $profileId = 1;

        $data = [];

        // Create 10 records with different created_at (last 10 days)
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'user_id' => $userId,
                'user_type' => $userType,
                'profile_type' => $profileType,
                'profile_id' => $profileId,
                'created_at' => Carbon::now()->subDays($i),
                'updated_at' => Carbon::now()->subDays($i),
            ];
        }

        DB::table('profile_views')->insert($data);
    }
}
