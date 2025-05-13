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
    public $itemTypeFilter = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'itemTypeFilter' => ['except' => ''],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingItemTypeFilter()
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
        $query = Item::query();
        
        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        // Apply item type filter
        if ($this->itemTypeFilter) {
            $query->where('item_type', $this->itemTypeFilter);
        }
        
        $items = $query->orderBy('name')
                      ->paginate($this->perPage);
            
        return view('livewire.admin.items.item-list', [
            'items' => $items
        ]);
    }
} 