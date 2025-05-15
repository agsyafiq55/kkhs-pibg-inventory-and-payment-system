<?php

namespace App\Livewire\Admin\Streams;

use App\Models\Stream;
use Livewire\Component;

class StreamShow extends Component
{
    public Stream $stream;
    
    public function mount(Stream $stream)
    {
        $this->stream = $stream;
    }
    
    public function render()
    {
        return view('livewire.admin.streams.stream-show', [
            'stream' => $this->stream,
            'items' => $this->stream->items()->paginate(10)
        ]);
    }
} 