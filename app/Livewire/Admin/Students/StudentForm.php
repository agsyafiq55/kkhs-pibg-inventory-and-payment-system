<?php

namespace App\Livewire\Admin\Students;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\StudentClassHistory;
use Livewire\Component;

class StudentForm extends Component
{
    public Student $student;
    
    public $classrooms;
    public $editing = false;
    
    // Form fields
    public $name;
    public $class_id;
    public $academic_year;
    public $daftar_no;
    public $ic_no;
    public $gender;
    public $islam = false;
    public $previous_school;
    public $scholarship = false;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'class_id' => 'required|exists:classes,class_id',
        'academic_year' => 'required|integer|min:2000|max:2100',
        'daftar_no' => 'nullable|string|max:255',
        'ic_no' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:255',
        'islam' => 'nullable|boolean',
        'previous_school' => 'nullable|string|max:255',
        'scholarship' => 'nullable|boolean',
    ];
    
    public function mount($student = null)
    {
        $this->classrooms = Classroom::orderBy('class_name')->get();
        $this->academic_year = date('Y');
        
        if ($student) {
            $this->student = $student;
            $this->editing = true;
            $this->fillFormFields();
        } else {
            $this->student = new Student();
        }
    }
    
    private function fillFormFields()
    {
        $this->name = $this->student->name;
        $this->class_id = $this->student->class_id;
        $this->daftar_no = $this->student->daftar_no;
        $this->ic_no = $this->student->ic_no;
        $this->gender = $this->student->gender;
        $this->islam = $this->student->islam;
        $this->previous_school = $this->student->previous_school;
        $this->scholarship = $this->student->scholarship;
        
        // Get current class history for this year
        $classHistory = $this->student->getCurrentClassHistory();
        if ($classHistory) {
            $this->class_id = $classHistory->class_id;
            $this->academic_year = $classHistory->academic_year;
        }
    }
    
    public function save()
    {
        $this->validate();
        
        $this->student->name = $this->name;
        $this->student->daftar_no = $this->daftar_no;
        $this->student->ic_no = $this->ic_no;
        $this->student->gender = $this->gender;
        $this->student->islam = $this->islam;
        $this->student->previous_school = $this->previous_school;
        $this->student->scholarship = $this->scholarship;
        
        // Save the student first to get an ID if it's a new student
        $this->student->save();
        
        // Update or create the class history record
        StudentClassHistory::updateOrCreate(
            [
                'student_id' => $this->student->student_id,
                'academic_year' => $this->academic_year
            ],
            ['class_id' => $this->class_id]
        );
        
        // Also update the current class_id on the student record for quick access
        $this->student->class_id = $this->class_id;
        $this->student->save();
        
        session()->flash('message', $this->editing ? 'Student updated successfully!' : 'Student created successfully!');
        
        return redirect()->route('admin.students.index');
    }
    
    public function render()
    {
        return view('livewire.admin.students.student-form');
    }
} 