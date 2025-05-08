<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $primaryKey = 'size_id';

    protected $fillable = [
        'size_label',
    ];

    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class, 'size_id', 'size_id');
    }
} 