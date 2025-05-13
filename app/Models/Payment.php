<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'package_id',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'notes',
    ];
    
    /**
     * Get the student associated with this payment
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
    
    /**
     * Get the package associated with this payment
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }
    
    /**
     * Check if payment is complete
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'completed';
    }
}
