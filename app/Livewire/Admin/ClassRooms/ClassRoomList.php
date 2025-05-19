<?php

namespace App\Livewire\Admin\ClassRooms;

use App\Models\Classroom;
use App\Models\StudentClassHistory;
use Livewire\Component;
use Livewire\WithPagination;

class ClassRoomList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectedYear;
    public $selectedClassName = '';
    public $selectedForm = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'selectedYear' => ['except' => ''],
        'selectedClassName' => ['except' => ''],
        'selectedForm' => ['except' => ''],
    ];
    
    public function mount()
    {
        // Default to current year
        $this->selectedYear = $this->selectedYear ?: date('Y');
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedYear()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedClassName()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedForm()
    {
        $this->resetPage();
    }
    
    public function deleteClassroom($classroomId)
    {
        $classroom = Classroom::find($classroomId);
        
        // Check if there are students in this class for any year
        if ($classroom->studentClassHistories()->count() > 0) {
            session()->flash('error', 'Cannot delete class that has students. Please remove student class assignments first.');
            return;
        }
        
        $classroom->delete();
        session()->flash('message', 'Class deleted successfully.');
    }

    public function render()
    {
        // Get classrooms with student count for selected year
        $classrooms = Classroom::withCount(['studentClassHistories as students_count' => function($query) {
                $query->where('academic_year', $this->selectedYear);
            }])
            ->where(function($query) {
                $query->where('class_name', 'like', '%' . $this->search . '%')
                      ->orWhere('full_class_name', 'like', '%' . $this->search . '%');
            });
            
        // Apply class name filter if selected
        if (!empty($this->selectedClassName)) {
            $classrooms->where('class_name', $this->selectedClassName);
        }
        
        // Apply form filter if selected
        if (!empty($this->selectedForm)) {
            $classrooms->where('form', $this->selectedForm);
        }
        
        $classrooms = $classrooms->orderBy('form')
            ->orderBy('class_name')
            ->paginate($this->perPage);
        
        // Get available years from the database
        $availableYears = StudentClassHistory::select('academic_year')
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year')
            ->toArray();
        
        // Add current year if not in the list
        if (!in_array(date('Y'), $availableYears)) {
            $availableYears[] = date('Y');
            rsort($availableYears);
        }
        
        // Get all unique class names
        $classNames = Classroom::select('class_name')
            ->distinct()
            ->orderBy('class_name')
            ->pluck('class_name')
            ->toArray();
            
        // Get all unique forms
        $forms = Classroom::select('form')
            ->distinct()
            ->orderBy('form')
            ->pluck('form')
            ->toArray();
            
        return view('livewire.admin.classrooms.classroom-list', [
            'classrooms' => $classrooms,
            'availableYears' => $availableYears,
            'classNames' => $classNames,
            'forms' => $forms
        ]);
    }
} 