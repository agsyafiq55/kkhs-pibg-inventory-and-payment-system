<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'items_id';

    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    public function variants()
    {
        return $this->hasMany(ItemVariant::class, 'items_id', 'items_id');
    }
} 