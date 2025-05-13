<?php

namespace App\Livewire\Public;

use App\Models\Student;
use App\Models\Package;
use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class PaymentProcessor extends Component
{
    public $student;
    public $package;
    public $paymentIntent = null;
    public $paymentError = '';
    public $paymentSuccess = false;
    
    public function mount($studentId, $packageId)
    {
        $this->student = Student::findOrFail($studentId);
        $this->package = Package::findOrFail($packageId);
        
        // Check if student has already paid for this package
        if ($this->student->hasPaymentForPackage($this->package->package_id)) {
            $this->paymentSuccess = true;
            return;
        }
        
        // Check if student's class matches package class
        if ($this->student->class_id !== $this->package->class_id) {
            $this->paymentError = 'This package is not available for your classroom.';
            return;
        }
    }
    
    public function processPayment()
    {
        // This would normally integrate with Stripe API
        // For now, we'll just create a successful payment record
        
        try {
            // Create a new payment record
            $payment = Payment::create([
                'student_id' => $this->student->student_id,
                'package_id' => $this->package->package_id,
                'amount' => $this->package->total_price,
                'payment_method' => 'stripe',
                'transaction_id' => 'manual-' . time(), // Placeholder until Stripe integration
                'payment_status' => 'completed',
                'notes' => 'Manually processed payment for testing',
            ]);
            
            $this->paymentSuccess = true;
            
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            $this->paymentError = 'An error occurred while processing your payment. Please try again.';
        }
    }
    
    public function render()
    {
        return view('livewire.public.payment-processor');
    }
}
