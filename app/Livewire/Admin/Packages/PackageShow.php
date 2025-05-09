<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Package;
use App\Models\PackageItem;
use Livewire\Component;
use Livewire\WithPagination;

class PackageShow extends Component
{
    use WithPagination;
    
    public Package $package;
    public $search = '';
    
    protected $listeners = ['itemAdded' => '$refresh', 'itemDeleted' => '$refresh'];
    
    public function mount(Package $package)
    {
        $this->package = $package;
    }
    
    public function deleteItem(int $itemId)
    {
        $item = PackageItem::findOrFail($itemId);
        $item->delete();
        
        // The package total will be updated via event listener in the model
        
        $this->dispatch('itemDeleted');
        session()->flash('message', 'Item removed from package successfully.');
    }
    
    public function render()
    {
        $query = $this->package->items()->with(['variant.item', 'variant.color', 'variant.size']);
        
        if (!empty($this->search)) {
            $query->whereHas('variant', function ($q) {
                $q->whereHas('item', function ($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('barcode', 'like', '%' . $this->search . '%');
            });
        }
        
        $items = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('livewire.admin.packages.package-show', [
            'items' => $items,
        ]);
    }
}
