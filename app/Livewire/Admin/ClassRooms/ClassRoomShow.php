<?php

namespace App\Livewire\Admin\ClassRooms;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\StudentClassHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ClassRoomShow extends Component
{
    use WithPagination;
    
    public Classroom $classroom;
    public $search = '';
    public $academic_year;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'academic_year' => ['except' => ''],
    ];
    
    public function mount(Classroom $classroom)
    {
        $this->classroom = $classroom;
        $this->academic_year = $this->academic_year ?: date('Y');
    }
    
    public function render()
    {
        // Use query builder approach instead of collection for pagination
        $students = Student::whereHas('classHistory', function($query) {
                $query->where('class_id', $this->classroom->class_id)
                      ->where('academic_year', $this->academic_year);
            })
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('ic_no', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(10);
            
        return view('livewire.admin.classrooms.classroom-show', [
            'students' => $students,
            'availableYears' => $this->getAvailableYears(),
        ]);
    }
    
    private function getAvailableYears()
    {
        // Get distinct academic years from the database for this class
        $dbYears = StudentClassHistory::where('class_id', $this->classroom->class_id)
            ->select('academic_year')
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year')
            ->toArray();
        
        // Add current year if not present
        $currentYear = (int) date('Y');
        if (!in_array($currentYear, $dbYears)) {
            $dbYears[] = $currentYear;
        }
        
        // Add next year for planning
        $nextYear = $currentYear + 1;
        if (!in_array($nextYear, $dbYears)) {
            $dbYears[] = $nextYear;
        }
        
        // Sort years descending
        rsort($dbYears);
        
        return $dbYears;
    }
    
    public function setAcademicYear($year)
    {
        $this->academic_year = (int) $year;
        $this->resetPage();
    }
} 