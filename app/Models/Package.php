<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $primaryKey = 'package_id';
    
    protected $fillable = [
        'package_name',
        'description',
        'class_id',
        'total_price',
        'is_active'
    ];

    /**
     * Get the classroom that this package belongs to
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'class_id');
    }

    /**
     * Get the items in this package
     */
    public function items(): HasMany
    {
        return $this->hasMany(PackageItem::class, 'package_id', 'package_id');
    }

    /**
     * Calculate total price of all items in the package
     */
    public function calculateTotalPrice(): float
    {
        return $this->items()->sum('total_price');
    }

    /**
     * Update the total price attribute
     */
    public function updateTotalPrice(): void
    {
        $this->total_price = $this->calculateTotalPrice();
        $this->save();
    }
}
