<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'subject_id';

    protected $fillable = [
        'subject_code',
        'subject_name',
        'type',
        'for_muslim_only',
        'for_non_muslim_only',
    ];

    protected $casts = [
        'for_muslim_only' => 'boolean',
        'for_non_muslim_only' => 'boolean',
    ];

    // A subject can be for many books
    public function items()
    {
        return $this->hasMany(Item::class, 'subject_id', 'subject_id');
    }
}
