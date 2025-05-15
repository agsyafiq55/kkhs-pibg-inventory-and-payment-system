<?php

namespace App\Livewire\Admin\Streams;

use App\Models\Stream;
use Livewire\Component;

class StreamForm extends Component
{
    public $stream_name;
    public $description;
    public $stream_id;
    public $isEdit = false;
    
    protected function rules()
    {
        return [
            'stream_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }
    
    public function mount(Stream $stream = null)
    {
        if ($stream && $stream->exists) {
            $this->stream_id = $stream->stream_id;
            $this->stream_name = $stream->stream_name;
            $this->description = $stream->description;
            $this->isEdit = true;
        }
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function save()
    {
        $validatedData = $this->validate();
        
        try {
            if ($this->isEdit) {
                $stream = Stream::findOrFail($this->stream_id);
                $stream->stream_name = $this->stream_name;
                $stream->description = $this->description;
            } else {
                $stream = new Stream();
                $stream->stream_name = $this->stream_name;
                $stream->description = $this->description;
            }
            
            $stream->save();
            
            $message = $this->isEdit ? 'Stream updated successfully' : 'Stream created successfully';
            session()->flash('success', $message);
            
            return redirect()->route('admin.streams.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.admin.streams.stream-form');
    }
} 