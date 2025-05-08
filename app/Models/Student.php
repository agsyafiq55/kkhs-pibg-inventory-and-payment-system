<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';
    
    protected $fillable = [
        'class_id',
        'name',
        'daftar_no',
        'ic_no',
        'form',
        'stream',
        'gender',
        'islam',
        'previous_school',
        'scholarship',
    ];

    protected $casts = [
        'islam' => 'boolean',
        'scholarship' => 'boolean',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'class_id');
    }
} 