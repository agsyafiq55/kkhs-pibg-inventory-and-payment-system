<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class StudentList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function deleteStudent($studentId)
    {
        Student::find($studentId)->delete();
        session()->flash('message', 'Student deleted successfully.');
    }

    public function render()
    {
        $students = Student::with('classroom')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('ic_no', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate($this->perPage);
            
        return view('livewire.admin.students.student-list', [
            'students' => $students
        ]);
    }
} 