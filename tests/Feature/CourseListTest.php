<?php

use App\Livewire\CourseList;
use App\Models\Course;
use App\Models\Episode;
use App\Models\User;

it('render successfully', function () {
    $course = Course::factory(3)
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['length_in_minutes' => 10]), 'episodes')
        ->create();

    Livewire::test(CourseList::class)
        ->assertStatus(200);
});
