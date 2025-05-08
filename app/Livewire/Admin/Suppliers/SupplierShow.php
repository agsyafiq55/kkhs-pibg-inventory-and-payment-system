<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierShow extends Component
{
    use WithPagination;
    
    public Supplier $supplier;
    public $search = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    
    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }
    
    public function render()
    {
        $variants = $this->supplier->itemVariants()
            ->when($this->search, function($query) {
                return $query->whereHas('item', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['item', 'color', 'size'])
            ->paginate(10);
            
        return view('livewire.admin.suppliers.supplier-show', [
            'variants' => $variants
        ]);
    }
} 