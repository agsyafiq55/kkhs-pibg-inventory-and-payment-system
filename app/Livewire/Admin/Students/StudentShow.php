<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use App\Models\StudentClassHistory;
use Livewire\Component;

class StudentShow extends Component
{
    public Student $student;
    public $classHistory;
    
    public function mount(Student $student)
    {
        $this->student = $student;
        $this->loadClassHistory();
    }
    
    private function loadClassHistory()
    {
        // Get all class history records for this student, ordered by year (newest first)
        $this->classHistory = StudentClassHistory::where('student_id', $this->student->student_id)
            ->with('classroom')
            ->orderBy('academic_year', 'desc')
            ->get();
    }
    
    public function render()
    {
        return view('livewire.admin.students.student-show');
    }
} 