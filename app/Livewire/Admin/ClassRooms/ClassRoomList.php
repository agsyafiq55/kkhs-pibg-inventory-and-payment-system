<?php

namespace App\Livewire\Admin\ClassRooms;

use App\Models\Classroom;
use Livewire\Component;
use Livewire\WithPagination;

class ClassRoomList extends Component
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
    
    public function deleteClassroom($classroomId)
    {
        $classroom = Classroom::find($classroomId);
        
        // Check if there are students in this class
        if ($classroom->students()->count() > 0) {
            session()->flash('error', 'Cannot delete class that has students. Please remove students first.');
            return;
        }
        
        $classroom->delete();
        session()->flash('message', 'Class deleted successfully.');
    }

    public function render()
    {
        $classrooms = Classroom::withCount('students')
            ->where('class_name', 'like', '%' . $this->search . '%')
            ->orderBy('class_name')
            ->paginate($this->perPage);
            
        return view('livewire.admin.classrooms.classroom-list', [
            'classrooms' => $classrooms
        ]);
    }
} 