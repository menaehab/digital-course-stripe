<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseShow extends Component
{
    public $course;
    public function mount($slug)
    {
        $this->course = Course::where('slug', $slug)->first();
    }
    public function render()
    {
        return view('livewire.course-show');
    }
}