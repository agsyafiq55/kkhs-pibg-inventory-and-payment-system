<?php

namespace App\Livewire\Admin\ClassRooms;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\StudentClassHistory;
use Livewire\Component;

class AddStudent extends Component
{
    public Classroom $classroom;
    
    // Form fields
    public $name;
    public $daftar_no;
    public $ic_no;
    public $gender;
    public $islam = false;
    public $previous_school;
    public $scholarship = false;
    public $academic_year;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'academic_year' => 'required|integer|min:2000|max:2100',
        'daftar_no' => 'nullable|string|max:255',
        'ic_no' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:255',
        'islam' => 'nullable|boolean',
        'previous_school' => 'nullable|string|max:255',
        'scholarship' => 'nullable|boolean',
    ];
    
    public function mount(Classroom $classroom)
    {
        $this->classroom = $classroom;
        $this->academic_year = date('Y');
    }
    
    public function save()
    {
        $this->validate();
        
        // Create new student
        $student = new Student([
            'name' => $this->name,
            'daftar_no' => $this->daftar_no,
            'ic_no' => $this->ic_no,
            'gender' => $this->gender,
            'islam' => $this->islam,
            'previous_school' => $this->previous_school,
            'scholarship' => $this->scholarship,
            'class_id' => $this->classroom->class_id,
        ]);
        
        $student->save();
        
        // Create class history record
        StudentClassHistory::create([
            'student_id' => $student->student_id,
            'class_id' => $this->classroom->class_id,
            'academic_year' => $this->academic_year,
        ]);
        
        session()->flash('message', 'Student added successfully!');
        
        // Reset form fields
        $this->reset(['name', 'daftar_no', 'ic_no', 'gender', 'islam', 'previous_school', 'scholarship']);
        
        // Redirect back to classroom show
        return redirect()->route('admin.classrooms.show', $this->classroom->class_id);
    }
    
    public function render()
    {
        return view('livewire.admin.classrooms.add-student');
    }
} 