<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Course::factory()
            ->for(User::factory()->instructor(), 'instructor')
            ->has(Episode::factory()->state(['vimeo_id' => '116716575']), 'episodes')
            ->create();
    }
}
