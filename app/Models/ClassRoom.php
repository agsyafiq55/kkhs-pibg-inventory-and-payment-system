<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $primaryKey = 'class_id';
    
    protected $fillable = [
        'class_name',
        'form',
        'stream',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id', 'class_id');
    }
    
    public function studentClassHistories(): HasMany
    {
        return $this->hasMany(StudentClassHistory::class, 'class_id', 'class_id');
    }
    
    public function getStudentsForYear($year = null)
    {
        $year = $year ?? date('Y');
        
        return Student::whereHas('classHistory', function($query) use ($year) {
            $query->where('class_id', $this->class_id)
                  ->where('academic_year', $year);
        })->get();
    }
    
    public function getStudentCountForYear($year = null)
    {
        $year = $year ?? date('Y');
        
        return Student::whereHas('classHistory', function($query) use ($year) {
            $query->where('class_id', $this->class_id)
                  ->where('academic_year', $year);
        })->count();
    }
} 