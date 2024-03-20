<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
        ]);
//        $course = Course::factory()
//            ->for(User::factory()->instructor(), 'instructor')
//            ->has(Episode::factory(3)->state(new Sequence(
//                ['vimeo_id' => '116716575'],
//                ['vimeo_id' => '116716575'],
//                ['vimeo_id' => '116716575'],
//            )), 'episodes')
//            ->create();
    }
}
