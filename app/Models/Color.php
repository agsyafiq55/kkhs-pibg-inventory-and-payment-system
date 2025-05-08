<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $primaryKey = 'color_id';

    protected $fillable = [
        'color_name',
    ];

    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class, 'color_id', 'color_id');
    }
} 