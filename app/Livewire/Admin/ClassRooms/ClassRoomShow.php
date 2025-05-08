<?php

namespace App\Livewire\Admin\ClassRooms;

use App\Models\Classroom;
use Livewire\Component;
use Livewire\WithPagination;

class ClassRoomShow extends Component
{
    use WithPagination;
    
    public Classroom $classroom;
    public $search = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    
    public function mount(Classroom $classroom)
    {
        $this->classroom = $classroom;
    }
    
    public function render()
    {
        $students = $this->classroom->students()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);
            
        return view('livewire.admin.classrooms.classroom-show', [
            'students' => $students
        ]);
    }
} 