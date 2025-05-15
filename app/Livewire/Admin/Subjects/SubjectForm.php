<?php

namespace App\Livewire\Admin\Subjects;

use App\Models\Subject;
use Livewire\Component;
use Illuminate\Support\Str;

class SubjectForm extends Component
{
    public $subject_name;
    public $type = 'core';
    public $for_muslim_only = false;
    public $for_non_muslim_only = false;
    public $subject_id;
    public $isEdit = false;
    
    protected function rules()
    {
        return [
            'subject_name' => 'required|string|max:255',
            'type' => 'required|in:core,elective',
            'for_muslim_only' => 'boolean',
            'for_non_muslim_only' => 'boolean',
        ];
    }
    
    public function mount(Subject $subject = null)
    {
        if ($subject && $subject->exists) {
            $this->subject_id = $subject->subject_id;
            $this->subject_name = $subject->subject_name;
            $this->type = $subject->type;
            $this->for_muslim_only = $subject->for_muslim_only;
            $this->for_non_muslim_only = $subject->for_non_muslim_only;
            $this->isEdit = true;
        }
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function generateSubjectCode()
    {
        if ($this->subject_name) {
            // Generate a code based on subject name (first 3 letters + random number)
            $prefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $this->subject_name), 0, 3));
            $randomNum = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
            $code = $prefix . $randomNum;
            
            // Check if code exists, if so, regenerate
            $count = 0;
            while (Subject::where('subject_code', $code)
                          ->where('subject_id', '!=', $this->subject_id ?? 0)
                          ->exists() && $count < 10) {
                $randomNum = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
                $code = $prefix . $randomNum;
                $count++;
            }
            
            return $code;
        }
        
        return 'SUB' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    }
    
    public function save()
    {
        $validatedData = $this->validate();
        
        // Ensure both Muslim and non-Muslim flags are not set simultaneously
        if ($this->for_muslim_only && $this->for_non_muslim_only) {
            $this->addError('for_muslim_only', 'A subject cannot be for both Muslims only and non-Muslims only');
            return;
        }
        
        try {
            if ($this->isEdit) {
                $subject = Subject::findOrFail($this->subject_id);
                $subject->subject_name = $this->subject_name;
                $subject->type = $this->type;
                $subject->for_muslim_only = $this->for_muslim_only;
                $subject->for_non_muslim_only = $this->for_non_muslim_only;
            } else {
                $subject = new Subject();
                $subject->subject_name = $this->subject_name;
                $subject->subject_code = $this->generateSubjectCode();
                $subject->type = $this->type;
                $subject->for_muslim_only = $this->for_muslim_only;
                $subject->for_non_muslim_only = $this->for_non_muslim_only;
            }
            
            $subject->save();
            
            $message = $this->isEdit ? 'Subject updated successfully' : 'Subject created successfully';
            session()->flash('success', $message);
            
            return redirect()->route('admin.subjects.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.admin.subjects.subject-form');
    }
} 