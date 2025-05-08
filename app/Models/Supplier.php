<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'contact_info',
    ];

    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class, 'supplier_id', 'supplier_id');
    }
} 