<?php

namespace App\Livewire\Admin\Items;

use App\Models\Item;
use App\Models\ItemVariant;
use Livewire\Component;
use Livewire\WithPagination;

class ItemShow extends Component
{
    use WithPagination;
    
    public Item $item;
    public $search = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    
    public function mount(Item $item)
    {
        $this->item = $item;
    }
    
    public function deleteVariant($variantId)
    {
        $variant = ItemVariant::find($variantId);
        
        if ($variant) {
            $variant->delete();
            session()->flash('message', 'Variant deleted successfully.');
        } else {
            session()->flash('error', 'Variant not found.');
        }
        
        $this->resetPage();
    }
    
    public function render()
    {
        $variants = $this->item->variants()
            ->when($this->search, function($query) {
                return $query->where('barcode', 'like', '%' . $this->search . '%');
            })
            ->with(['color', 'size', 'supplier'])
            ->paginate(10);
            
        return view('livewire.admin.items.item-show', [
            'variants' => $variants
        ]);
    }
} 