<?php

use App\Livewire\CourseList;
use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('render successfully', function () {
    Livewire::test(CourseList::class)
        ->assertStatus(200);
});

it('show a list of all courses', function () {
    $course = Course::factory(3)
        ->state(new Sequence(
            [ 'title' => 'Course A'],
            [ 'title' => 'Course B'],
            [ 'title' => 'Course C'],
        ))
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['length_in_minutes' => 10]), 'episodes')
        ->create();

    Livewire::test(CourseList::class)
        ->assertSeeText(
            'Course A',
            'Course B',
            'Course C',
        );
});
