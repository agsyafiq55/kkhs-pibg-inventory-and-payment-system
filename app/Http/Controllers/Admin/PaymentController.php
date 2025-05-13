<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Package;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index()
    {
        return view('admin.payments.index');
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }
    
    /**
     * Show the form for creating a new payment
     */
    public function create()
    {
        $students = Student::all();
        $packages = Package::where('is_active', true)->get();
        
        return view('admin.payments.create', compact('students', 'packages'));
    }
    
    /**
     * Store a newly created payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'package_id' => 'required|exists:packages,package_id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $payment = Payment::create($validated);
        
        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Payment created successfully.');
    }
    
    /**
     * Show the form for editing the specified payment
     */
    public function edit(Payment $payment)
    {
        $students = Student::all();
        $packages = Package::all();
        
        return view('admin.payments.edit', compact('payment', 'students', 'packages'));
    }
    
    /**
     * Update the specified payment
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'package_id' => 'required|exists:packages,package_id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $payment->update($validated);
        
        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }
}
