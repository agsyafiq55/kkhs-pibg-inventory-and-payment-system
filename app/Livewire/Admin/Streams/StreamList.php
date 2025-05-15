<?php

namespace App\Livewire\Admin\Streams;

use App\Models\Stream;
use Livewire\Component;
use Livewire\WithPagination;

class StreamList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $perPage = 10;
    public $sortField = 'stream_name';
    public $sortDirection = 'asc';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'stream_name'],
        'sortDirection' => ['except' => 'asc'],
    ];
    
    public function updatingSearch()
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
    
    public function deleteStream($streamId)
    {
        // Check if stream is being used by any items
        $stream = Stream::findOrFail($streamId);
        
        if ($stream->items()->count() > 0) {
            session()->flash('error', 'Cannot delete stream as it is associated with one or more items.');
            return;
        }
        
        $stream->delete();
        session()->flash('success', 'Stream deleted successfully.');
    }
    
    public function render()
    {
        $streams = Stream::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('stream_name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.admin.streams.stream-list', [
            'streams' => $streams
        ]);
    }
} 