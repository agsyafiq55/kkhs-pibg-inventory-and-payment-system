<?php

namespace App\Livewire\Public;

use App\Models\Student;
use App\Models\Package;
use Livewire\Component;

class StudentLookup extends Component
{
    public $daftarNo = '';
    public $icNumber = '';
    public $student = null;
    public $package = null;
    public $error = '';
    
    public function lookup()
    {
        $this->validate([
            'daftarNo' => 'required',
            'icNumber' => 'required',
        ]);
        
        $this->student = Student::where('daftar_no', $this->daftarNo)
            ->where('ic_no', $this->icNumber)
            ->first();
            
        if (!$this->student) {
            $this->error = 'Student not found. Please check your information and try again.';
            $this->package = null;
            return;
        }
        
        $this->error = '';
        
        // Find the package for this student's classroom
        $this->package = Package::where('class_id', $this->student->class_id)
            ->where('is_active', true)
            ->first();
            
        if (!$this->package) {
            $this->error = 'No active package found for this student\'s classroom.';
        } else {
            // Check if student has already paid
            if ($this->student->hasPaymentForPackage($this->package->package_id)) {
                $this->error = 'You have already paid for this package.';
            }
        }
    }
    
    public function resetForm()
    {
        $this->daftarNo = '';
        $this->icNumber = '';
        $this->student = null;
        $this->package = null;
        $this->error = '';
    }
    
    public function render()
    {
        return view('livewire.public.student-lookup');
    }
}
