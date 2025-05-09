<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Classroom;
use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;

class PackageList extends Component
{
    use WithPagination;

    public $search = '';
    public $class_filter = '';
    public $classrooms = [];

    public function mount()
    {
        $this->classrooms = Classroom::orderBy('class_name')->get();
    }

    public function deletePackage($packageId)
    {
        Package::findOrFail($packageId)->delete();
        session()->flash('message', 'Package deleted successfully.');
    }

    public function render()
    {
        $query = Package::query()->with('classroom');
        
        if (!empty($this->search)) {
            $query->where('package_name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }
        
        if (!empty($this->class_filter)) {
            $query->where('class_id', $this->class_filter);
        }
        
        $packages = $query->orderBy('package_name')
            ->paginate(10);

        return view('livewire.admin.packages.package-list', [
            'packages' => $packages
        ]);
    }
}
