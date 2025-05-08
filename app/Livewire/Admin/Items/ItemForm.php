<?php

namespace App\Livewire\Admin\Items;

use App\Models\Item;
use Livewire\Component;

class ItemForm extends Component
{
    public Item $item;
    
    public $editing = false;
    
    // Form fields
    public $name;
    public $description;
    public $category_id;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'nullable|string|max:255',
    ];
    
    public function mount($item = null)
    {
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
        $this->description = $this->item->description;
        $this->category_id = $this->item->category_id;
    }
    
    public function save()
    {
        $this->validate();
        
        $this->item->name = $this->name;
        $this->item->description = $this->description;
        $this->item->category_id = $this->category_id;
        
        $this->item->save();
        
        session()->flash('message', $this->editing ? 'Item updated successfully!' : 'Item created successfully!');
        
        return redirect()->route('admin.items.index');
    }
    
    public function render()
    {
        return view('livewire.admin.items.item-form');
    }
}
