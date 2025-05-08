<?php

namespace App\Livewire\Admin\Items;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class ItemList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function deleteItem($itemId)
    {
        Item::find($itemId)->delete();
        session()->flash('message', 'Item deleted successfully.');
    }

    public function render()
    {
        $items = Item::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate($this->perPage);
            
        return view('livewire.admin.items.item-list', [
            'items' => $items
        ]);
    }
} 