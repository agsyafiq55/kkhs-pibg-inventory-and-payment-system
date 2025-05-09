<?php

namespace App\Livewire\Admin\Items;

use App\Models\Item;
use App\Models\ItemVariant;
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
        'color_id' => 'required',
        'size_id' => 'required',
        'supplier_id' => 'nullable|exists:suppliers,supplier_id',
        'barcode' => 'nullable|string|max:255',
        'stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ];
    
    public function mount(Item $item, $variant = null)
    {
        $this->item = $item;
        $this->items_id = $item->items_id;
        
        // Hardcoded colors and sizes as requested
        $this->colors = [
            ['color_id' => 1, 'color_name' => 'RED'],
            ['color_id' => 2, 'color_name' => 'YELLOW'],
            ['color_id' => 3, 'color_name' => 'PURPLE'],
            ['color_id' => 4, 'color_name' => 'BLUE'],
            ['color_id' => 5, 'color_name' => 'GREEN'],
            ['color_id' => 6, 'color_name' => 'ORANGE'],
        ];
        
        $this->sizes = [
            ['size_id' => 1, 'size_label' => '2XS'],
            ['size_id' => 2, 'size_label' => 'XS'],
            ['size_id' => 3, 'size_label' => 'S'],
            ['size_id' => 4, 'size_label' => 'M'],
            ['size_id' => 5, 'size_label' => 'L'],
            ['size_id' => 6, 'size_label' => 'XL'],
            ['size_id' => 7, 'size_label' => '2XL'],
            ['size_id' => 8, 'size_label' => '3XL'],
            ['size_id' => 9, 'size_label' => '4XL'],
        ];
        
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