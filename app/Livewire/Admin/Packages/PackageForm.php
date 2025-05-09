<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Classroom;
use App\Models\Package;
use Livewire\Component;

class PackageForm extends Component
{
    public Package $package;
    public $editing = false;
    
    // Form fields
    public $package_name = '';
    public $description = '';
    public $class_id = '';
    public $is_active = true;
    
    public $classrooms = [];
    
    protected $rules = [
        'package_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'class_id' => 'required|exists:classes,class_id',
        'is_active' => 'boolean',
    ];
    
    public function mount($package = null)
    {
        $this->classrooms = Classroom::orderBy('class_name')->get();
        
        if ($package) {
            $this->package = $package;
            $this->editing = true;
            $this->fillForm();
        } else {
            $this->package = new Package();
        }
    }
    
    private function fillForm()
    {
        $this->package_name = $this->package->package_name;
        $this->description = $this->package->description;
        $this->class_id = $this->package->class_id;
        $this->is_active = $this->package->is_active;
    }
    
    public function save()
    {
        $this->validate();
        
        $this->package->package_name = $this->package_name;
        $this->package->description = $this->description;
        $this->package->class_id = $this->class_id;
        $this->package->is_active = $this->is_active;
        
        $this->package->save();
        
        session()->flash('message', $this->editing ? 'Package updated successfully.' : 'Package created successfully.');
        
        return redirect()->route('admin.packages.show', $this->package->package_id);
    }
    
    public function render()
    {
        return view('livewire.admin.packages.package-form');
    }
}
