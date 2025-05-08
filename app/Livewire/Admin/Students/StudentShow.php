<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use Livewire\Component;

class StudentShow extends Component
{
    public Student $student;
    
    public function mount(Student $student)
    {
        $this->student = $student;
    }
    
    public function render()
    {
        return view('livewire.admin.students.student-show');
    }
} 