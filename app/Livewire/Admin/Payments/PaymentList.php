<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Classroom;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $status = '';
    public $classFilter = '';
    public $perPage = 10;
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatus()
    {
        $this->resetPage();
    }
    
    public function updatingClassFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $payments = Payment::query()
            ->with(['student', 'student.classroom', 'package'])
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('daftar_no', 'like', '%' . $this->search . '%')
                        ->orWhere('ic_no', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('payment_status', $this->status);
            })
            ->when($this->classFilter, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('class_id', $this->classFilter);
                });
            })
            ->latest()
            ->paginate($this->perPage);
            
        $statuses = ['pending', 'completed', 'failed'];
        $classes = Classroom::all();
        
        return view('livewire.admin.payments.payment-list', compact('payments', 'statuses', 'classes'));
    }
}
