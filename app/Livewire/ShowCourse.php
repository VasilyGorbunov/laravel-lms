<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class ShowCourse extends Component
{
    public $title;

    public function mount(Course $course)
    {
        $this->title = $course->title;
    }
    public function render()
    {
        return view('livewire.show-course');
    }
}
