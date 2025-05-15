<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';
    
    protected $fillable = [
        'class_id',
        'name',
        'daftar_no',
        'ic_no',
        'gender',
        'islam',
        'previous_school',
        'scholarship',
        'stripe_customer_id',
    ];

    protected $casts = [
        'islam' => 'boolean',
        'scholarship' => 'boolean',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'class_id');
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_id', 'student_id');
    }
    
    public function classHistory(): HasMany
    {
        return $this->hasMany(StudentClassHistory::class, 'student_id', 'student_id');
    }
    
    public function getCurrentClassHistory($year = null)
    {
        $year = $year ?? date('Y');
        
        return $this->classHistory()
            ->where('academic_year', $year)
            ->first();
    }
    
    public function getClassForYear($year = null)
    {
        $year = $year ?? date('Y');
        
        $classHistory = $this->getCurrentClassHistory($year);
        
        return $classHistory ? $classHistory->classroom : null;
    }
    
    public function isInClass($classId, $year = null)
    {
        $year = $year ?? date('Y');
        
        return $this->classHistory()
            ->where('class_id', $classId)
            ->where('academic_year', $year)
            ->exists();
    }
    
    public function hasPaymentForPackage(int $packageId): bool
    {
        return $this->payments()
            ->where('package_id', $packageId)
            ->where('payment_status', 'completed')
            ->exists();
    }
} 