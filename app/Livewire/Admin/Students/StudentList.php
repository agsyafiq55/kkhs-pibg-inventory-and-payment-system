<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use App\Models\Classroom;
use Livewire\Component;
use Livewire\WithPagination;

class StudentList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $formFilter = '';
    public $classFilter = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'formFilter' => ['except' => ''],
        'classFilter' => ['except' => ''],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingFormFilter()
    {
        $this->resetPage();
    }
    
    public function updatingClassFilter()
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
        $query = Student::with('classroom');
        
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('ic_no', 'like', '%' . $this->search . '%');
            });
        }
        
        if (!empty($this->formFilter)) {
            $query->where('form', $this->formFilter);
        }
        
        if (!empty($this->classFilter)) {
            $query->where('class_id', $this->classFilter);
        }
        
        $students = $query->orderBy('name')
            ->paginate($this->perPage);
        
        $forms = Student::distinct()->pluck('form')->sort()->toArray();
        $classes = Classroom::orderBy('class_name')->get();
            
        return view('livewire.admin.students.student-list', [
            'students' => $students,
            'forms' => $forms,
            'classes' => $classes
        ]);
    }
} 