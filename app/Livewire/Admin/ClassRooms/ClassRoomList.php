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
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'selectedYear' => ['except' => ''],
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
            ->where('class_name', 'like', '%' . $this->search . '%')
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
            
        return view('livewire.admin.classrooms.classroom-list', [
            'classrooms' => $classrooms,
            'availableYears' => $availableYears
        ]);
    }
} 