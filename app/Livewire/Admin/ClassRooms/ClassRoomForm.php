<?php

namespace App\Livewire\Admin\ClassRooms;

use App\Models\Classroom;
use Livewire\Component;

class ClassRoomForm extends Component
{
    public Classroom $classroom;
    
    public $editing = false;
    
    // Form fields
    public $class_name = '';
    public $form = '';
    public $stream = '';
    public $full_class_name = '';
    
    protected $rules = [
        'class_name' => 'required|string|max:255',
        'form' => 'required|string|max:255',
        'stream' => 'nullable|string|max:255',
    ];
    
    public function mount($classroom = null)
    {
        if ($classroom) {
            $this->classroom = $classroom;
            $this->editing = true;
            $this->fillFormFields();
        } else {
            $this->classroom = new Classroom();
        }
    }
    
    private function fillFormFields()
    {
        $this->class_name = $this->classroom->class_name;
        $this->form = $this->classroom->form;
        $this->stream = $this->classroom->stream;
        $this->updateFullClassName();
    }
    
    public function updatedForm()
    {
        $this->updateFullClassName();
    }
    
    public function updatedClassName()
    {
        $this->updateFullClassName();
    }
    
    public function updateFullClassName()
    {
        if (!empty($this->form) && !empty($this->class_name)) {
            $this->full_class_name = $this->form . ' ' . $this->class_name;
        } else {
            $this->full_class_name = '';
        }
    }
    
    public function save()
    {
        $this->validate();
        
        // Update the full class name one last time to ensure it's current
        $this->updateFullClassName();
        
        // Save the full class name instead of just the class name
        $this->classroom->class_name = $this->full_class_name;
        $this->classroom->form = $this->form;
        $this->classroom->stream = $this->stream;
        
        $this->classroom->save();
        
        session()->flash('message', $this->editing ? 'Class updated successfully!' : 'Class created successfully!');
        
        return redirect()->route('admin.classrooms.index');
    }
    
    public function render()
    {
        return view('livewire.admin.classrooms.classroom-form');
    }
} 