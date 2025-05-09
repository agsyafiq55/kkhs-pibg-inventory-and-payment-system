<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\Package;
use App\Models\PackageItem;
use Livewire\Component;

class PackageItemForm extends Component
{
    public Package $package;
    public $packageItem;
    public $editing = false;
    
    // Form fields
    public $variant_id;
    public $for_muslim_only = false;
    public $for_non_muslim_only = false;
    public $quantity = 1;
    public $unit_price;
    public $notes;
    
    // Data collections for dropdowns
    public $items = [];
    public $variants = [];
    public $selectedItem = null;
    
    protected $rules = [
        'variant_id' => 'required|exists:item_variants,variant_id',
        'for_muslim_only' => 'boolean',
        'for_non_muslim_only' => 'boolean',
        'quantity' => 'required|integer|min:1',
        'unit_price' => 'required|numeric|min:0',
        'notes' => 'nullable|string',
    ];
    
    public function mount(Package $package, $itemId = null)
    {
        $this->package = $package;
        $this->items = Item::orderBy('name')->get();
        
        if ($itemId) {
            $this->packageItem = PackageItem::findOrFail($itemId);
            $this->editing = true;
            $this->fillForm();
            
            // Load variants for the selected item
            $this->selectedItem = $this->packageItem->variant->items_id;
            $this->loadVariants();
        } else {
            $this->packageItem = new PackageItem();
            $this->unit_price = 0;
        }
    }
    
    private function fillForm()
    {
        $this->variant_id = $this->packageItem->variant_id;
        $this->for_muslim_only = $this->packageItem->for_muslim_only;
        $this->for_non_muslim_only = $this->packageItem->for_non_muslim_only;
        $this->quantity = $this->packageItem->quantity;
        $this->unit_price = $this->packageItem->unit_price;
        $this->notes = $this->packageItem->notes;
    }
    
    public function updatedSelectedItem($value)
    {
        if ($value) {
            $this->loadVariants();
            $this->variant_id = null; // Reset the variant selection
        }
    }
    
    public function updatedVariantId($value)
    {
        if ($value) {
            $variant = ItemVariant::find($value);
            if ($variant) {
                $this->unit_price = $variant->price;
            }
        }
    }
    
    private function loadVariants()
    {
        if ($this->selectedItem) {
            $this->variants = ItemVariant::where('items_id', $this->selectedItem)
                ->with(['color', 'size'])
                ->get();
        } else {
            $this->variants = [];
        }
    }
    
    public function save()
    {
        $this->validate();

        // Check that both religion flags aren't set
        if ($this->for_muslim_only && $this->for_non_muslim_only) {
            $this->addError('for_muslim_only', 'An item cannot be for both Muslim and non-Muslim students only.');
            return;
        }
        
        $this->packageItem->package_id = $this->package->package_id;
        $this->packageItem->variant_id = $this->variant_id;
        $this->packageItem->for_muslim_only = $this->for_muslim_only;
        $this->packageItem->for_non_muslim_only = $this->for_non_muslim_only;
        $this->packageItem->quantity = $this->quantity;
        $this->packageItem->unit_price = $this->unit_price;
        $this->packageItem->notes = $this->notes;
        
        // Total price is calculated in the model's boot method
        
        $this->packageItem->save();
        
        $this->dispatch('itemAdded');
        
        session()->flash('message', $this->editing ? 'Package item updated successfully.' : 'Item added to package successfully.');
        
        return redirect()->route('admin.packages.show', $this->package->package_id);
    }
    
    public function render()
    {
        return view('livewire.admin.packages.package-item-form');
    }
}
