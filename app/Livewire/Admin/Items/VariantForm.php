<?php

namespace App\Livewire\Admin\Items;

use App\Models\Color;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\Size;
use App\Models\Supplier;
use Livewire\Component;

class VariantForm extends Component
{
    public ItemVariant $variant;
    public Item $item;
    
    public $editing = false;
    
    // Form fields
    public $items_id;
    public $color_id;
    public $size_id;
    public $supplier_id;
    public $barcode;
    public $stock;
    public $price;
    
    // Collections for dropdowns
    public $colors;
    public $sizes;
    public $suppliers;
    
    protected $rules = [
        'color_id' => 'nullable|exists:colors,color_id',
        'size_id' => 'nullable|exists:sizes,size_id',
        'supplier_id' => 'nullable|exists:suppliers,supplier_id',
        'barcode' => 'nullable|string|max:255',
        'stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ];
    
    public function mount(Item $item, $variant = null)
    {
        $this->item = $item;
        $this->items_id = $item->items_id;
        
        $this->colors = Color::orderBy('color_name')->get();
        $this->sizes = Size::orderBy('size_label')->get();
        $this->suppliers = Supplier::orderBy('supplier_name')->get();
        
        if ($variant) {
            $this->variant = $variant;
            $this->editing = true;
            $this->fillFormFields();
        } else {
            $this->variant = new ItemVariant();
            $this->stock = 0;
            $this->price = 0;
        }
    }
    
    private function fillFormFields()
    {
        $this->color_id = $this->variant->color_id;
        $this->size_id = $this->variant->size_id;
        $this->supplier_id = $this->variant->supplier_id;
        $this->barcode = $this->variant->barcode;
        $this->stock = $this->variant->stock;
        $this->price = $this->variant->price;
    }
    
    public function save()
    {
        $this->validate();
        
        $this->variant->items_id = $this->items_id;
        $this->variant->color_id = $this->color_id;
        $this->variant->size_id = $this->size_id;
        $this->variant->supplier_id = $this->supplier_id;
        
        if (!empty($this->barcode)) {
            $this->variant->barcode = $this->barcode;
        }
        
        $this->variant->stock = $this->stock;
        $this->variant->price = $this->price;
        
        $this->variant->save();
        
        session()->flash('message', $this->editing ? 'Variant updated successfully!' : 'Variant created successfully!');
        
        return redirect()->route('admin.items.show', $this->item->items_id);
    }
    
    public function render()
    {
        return view('livewire.admin.items.variant-form');
    }
} 