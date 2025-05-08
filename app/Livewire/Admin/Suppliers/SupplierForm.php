<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class SupplierForm extends Component
{
    public Supplier $supplier;
    
    public $editing = false;
    
    // Form fields
    public $supplier_name;
    public $contact_info;
    
    protected $rules = [
        'supplier_name' => 'required|string|max:255',
        'contact_info' => 'nullable|string',
    ];
    
    public function mount($supplier = null)
    {
        if ($supplier) {
            $this->supplier = $supplier;
            $this->editing = true;
            $this->fillFormFields();
        } else {
            $this->supplier = new Supplier();
        }
    }
    
    private function fillFormFields()
    {
        $this->supplier_name = $this->supplier->supplier_name;
        $this->contact_info = $this->supplier->contact_info;
    }
    
    public function save()
    {
        $this->validate();
        
        $this->supplier->supplier_name = $this->supplier_name;
        $this->supplier->contact_info = $this->contact_info;
        
        $this->supplier->save();
        
        session()->flash('message', $this->editing ? 'Supplier updated successfully!' : 'Supplier created successfully!');
        
        return redirect()->route('admin.suppliers.index');
    }
    
    public function render()
    {
        return view('livewire.admin.suppliers.supplier-form');
    }
} 