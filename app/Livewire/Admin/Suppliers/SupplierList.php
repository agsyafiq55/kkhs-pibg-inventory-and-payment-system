<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierList extends Component
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
    
    public function deleteSupplier($supplierId)
    {
        $supplier = Supplier::find($supplierId);
        
        if ($supplier) {
            // Check if supplier has any item variants
            $variantCount = $supplier->itemVariants()->count();
            
            if ($variantCount > 0) {
                session()->flash('error', "Cannot delete supplier. It is associated with {$variantCount} item variants.");
                return;
            }
            
            $supplier->delete();
            session()->flash('message', 'Supplier deleted successfully.');
        } else {
            session()->flash('error', 'Supplier not found.');
        }
    }

    public function render()
    {
        $suppliers = Supplier::where('supplier_name', 'like', '%' . $this->search . '%')
            ->orWhere('contact_info', 'like', '%' . $this->search . '%')
            ->orderBy('supplier_name')
            ->paginate($this->perPage);
            
        return view('livewire.admin.suppliers.supplier-list', [
            'suppliers' => $suppliers
        ]);
    }
} 