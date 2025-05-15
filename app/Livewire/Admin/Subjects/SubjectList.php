<?php

namespace App\Livewire\Admin\Subjects;

use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $typeFilter = '';
    public $perPage = 10;
    public $sortField = 'subject_code';
    public $sortDirection = 'asc';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'sortField' => ['except' => 'subject_code'],
        'sortDirection' => ['except' => 'asc'],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingTypeFilter()
    {
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function deleteSubject($subjectId)
    {
        // Check if subject is being used by any items
        $subject = Subject::findOrFail($subjectId);
        
        if ($subject->items()->count() > 0) {
            session()->flash('error', 'Cannot delete subject as it is associated with one or more items.');
            return;
        }
        
        $subject->delete();
        session()->flash('success', 'Subject deleted successfully.');
    }
    
    public function render()
    {
        $subjects = Subject::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('subject_code', 'like', '%' . $this->search . '%')
                        ->orWhere('subject_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.admin.subjects.subject-list', [
            'subjects' => $subjects
        ]);
    }
} 