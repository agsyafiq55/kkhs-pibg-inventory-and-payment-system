<?php

namespace App\Livewire\Admin\Items;

use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\Subject;
use App\Models\Stream;
use App\Models\Supplier;
use Livewire\Component;

class ItemForm extends Component
{
    public Item $item;
    
    public $editing = false;
    
    // Form fields
    public $name;
    public $item_type = 'School Supply';
    public $description;
    public $subject_id;
    public $stream_id;
    public $form;
    public $has_variants = true;
    
    // Variant fields (for non-variant items or first variant)
    public $stock = 0;
    public $price = 0;
    public $barcode;
    public $supplier_id;
    
    // For multiple variants
    public $variants = [];
    public $variantCount = 1;
    
    // Collections for dropdowns
    public $colors;
    public $sizes;
    public $suppliers;
    public $subjects;
    public $streams;
    public $forms = [1, 2, 3, 4, 5];
    
    // Store variants when switching to Book type
    private $storedVariants = [];
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'item_type' => 'required|in:Book,School Supply',
        'description' => 'nullable|string',
        'subject_id' => 'nullable|required_if:item_type,Book|exists:subjects,subject_id',
        'stream_id' => 'nullable|exists:streams,stream_id',
        'form' => 'nullable|required_if:item_type,Book',
        'has_variants' => 'boolean',
        'stock' => 'required_if:has_variants,false|integer|min:0',
        'price' => 'required_if:has_variants,false|numeric|min:0',
        'barcode' => 'nullable|string|max:255',
        'supplier_id' => 'nullable|exists:suppliers,supplier_id',
    ];
    
    public function mount($item = null)
    {
        // Initialize collections for dropdowns
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
        $this->subjects = Subject::orderBy('subject_name')->get();
        $this->streams = Stream::orderBy('stream_name')->get();
        
        // Initialize the first variant
        $this->addVariant();
        
        if ($item) {
            $this->item = $item;
            $this->editing = true;
            $this->fillFormFields();
        } else {
            $this->item = new Item();
        }
    }
    
    private function fillFormFields()
    {
        $this->name = $this->item->name;
        $this->item_type = $this->item->item_type;
        $this->description = $this->item->description;
        $this->subject_id = $this->item->subject_id;
        $this->stream_id = $this->item->stream_id;
        $this->form = $this->item->form;
        $this->has_variants = $this->item->has_variants;
        
        // If editing and there are no variants, we need to create one
        if ($this->editing && !$this->has_variants) {
            // Check if there's a single variant already
            $variant = $this->item->variants()->first();
            if ($variant) {
                $this->stock = $variant->stock;
                $this->price = $variant->price;
                $this->barcode = $variant->barcode;
                $this->supplier_id = $variant->supplier_id;
            }
        }
    }
    
    public function addVariant()
    {
        $this->variants[] = [
            'color_id' => null,
            'size_id' => null,
            'stock' => 0,
            'price' => 0,
            'barcode' => '',
            'supplier_id' => null,
        ];
    }
    
    public function removeVariant($index)
    {
        if (count($this->variants) > 1) {
            unset($this->variants[$index]);
            $this->variants = array_values($this->variants); // Re-index the array
        }
    }
    
    public function updatedHasVariants()
    {
        if (!$this->has_variants) {
            // Reset variants to just one
            $this->variants = array_slice($this->variants, 0, 1);
        }
    }
    
    public function updatedItemType()
    {
        // If type is Book, variants typically don't apply
        if ($this->item_type === 'Book') {
            // Store the current variants for later use
            if (!empty($this->variants)) {
                $this->storedVariants = $this->variants;
            }
            $this->has_variants = false;
        } else if ($this->item_type === 'School Supply') {
            // Default to having variants for School Supplies
            $this->has_variants = true;
            
            // Restore variants if available, otherwise add a new one
            if (!empty($this->storedVariants)) {
                $this->variants = $this->storedVariants;
            } else if (empty($this->variants)) {
                $this->addVariant();
            }
        }
    }
    
    // Auto-generate book name when form or subject changes
    public function updatedSubjectId()
    {
        $this->updateBookName();
    }
    
    public function updatedForm()
    {
        $this->updateBookName();
    }
    
    private function updateBookName()
    {
        if ($this->item_type === 'Book' && $this->subject_id && $this->form) {
            $subject = Subject::find($this->subject_id);
            if ($subject) {
                $this->name = $subject->subject_name . ' FORM ' . $this->form;
            }
        }
    }
    
    public function save()
    {
        $this->validate();
        
        // Auto-update book name before saving
        if ($this->item_type === 'Book' && $this->subject_id && $this->form) {
            $subject = Subject::find($this->subject_id);
            if ($subject) {
                $this->name = $subject->subject_name . ' FORM ' . $this->form;
            }
        }
        
        $this->item->name = $this->name;
        $this->item->item_type = $this->item_type;
        $this->item->description = $this->description;
        $this->item->has_variants = $this->has_variants;
        
        // Subject, stream, and form are only relevant for books
        if ($this->item_type === 'Book') {
            $this->item->subject_id = $this->subject_id;
            $this->item->stream_id = $this->stream_id;
            $this->item->form = $this->form;
        } else {
            $this->item->subject_id = null;
            $this->item->stream_id = null;
            $this->item->form = null;
        }
        
        $this->item->save();
        
        if (!$this->has_variants) {
            // Create/update a single variant for this item
            $variant = $this->item->variants()->first() ?? new ItemVariant();
            $variant->items_id = $this->item->items_id;
            $variant->color_id = null;
            $variant->size_id = null;
            $variant->stock = $this->stock;
            $variant->price = $this->price;
            
            if (!empty($this->barcode)) {
                $variant->barcode = $this->barcode;
            }
            
            $variant->supplier_id = $this->supplier_id;
            $variant->save();
        } else if (!$this->editing) {
            // Only create variants when adding a new item
            foreach ($this->variants as $variantData) {
                $variant = new ItemVariant();
                $variant->items_id = $this->item->items_id;
                $variant->color_id = $variantData['color_id'] ?: null;
                $variant->size_id = $variantData['size_id'] ?: null;
                $variant->stock = $variantData['stock'];
                $variant->price = $variantData['price'];
                
                if (!empty($variantData['barcode'])) {
                    $variant->barcode = $variantData['barcode'];
                }
                
                $variant->supplier_id = $variantData['supplier_id'];
                $variant->save();
            }
        }
        
        session()->flash('message', $this->editing ? 'Item updated successfully!' : 'Item created successfully!');
        
        if ($this->editing) {
            return redirect()->route('admin.items.show', $this->item->items_id);
        } else {
            return redirect()->route('admin.items.index');
        }
    }
    
    public function render()
    {
        return view('livewire.admin.items.item-form');
    }
}
