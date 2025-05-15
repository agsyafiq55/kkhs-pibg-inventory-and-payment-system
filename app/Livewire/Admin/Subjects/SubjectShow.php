<?php

namespace App\Livewire\Admin\Subjects;

use App\Models\Subject;
use Livewire\Component;

class SubjectShow extends Component
{
    public Subject $subject;
    
    public function mount(Subject $subject)
    {
        $this->subject = $subject;
    }
    
    public function render()
    {
        // Load associated items
        $items = $this->subject->items()->paginate(5);
        
        return view('livewire.admin.subjects.subject-show', [
            'items' => $items
        ]);
    }
} 