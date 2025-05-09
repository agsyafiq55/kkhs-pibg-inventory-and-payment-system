<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'package_item_id';
    
    protected $fillable = [
        'package_id',
        'variant_id',
        'for_muslim_only',
        'for_non_muslim_only',
        'quantity',
        'unit_price',
        'total_price',
        'notes'
    ];

    /**
     * Get the package that this item belongs to
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }

    /**
     * Get the item variant
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ItemVariant::class, 'variant_id', 'variant_id');
    }

    /**
     * Calculate the total price based on quantity and unit price
     */
    public function calculateTotalPrice(): float
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Update the total price attribute
     */
    public function updateTotalPrice(): void
    {
        $this->total_price = $this->calculateTotalPrice();
        $this->save();
    }

    /**
     * Boot method to set up event listeners
     */
    protected static function boot()
    {
        parent::boot();

        // Set up the total price before saving
        static::saving(function ($packageItem) {
            if ($packageItem->isDirty(['quantity', 'unit_price'])) {
                $packageItem->total_price = $packageItem->calculateTotalPrice();
            }
        });

        // Update the package total after saving or deleting a package item
        static::saved(function ($packageItem) {
            if ($packageItem->package) {
                $packageItem->package->updateTotalPrice();
            }
        });

        static::deleted(function ($packageItem) {
            if ($packageItem->package) {
                $packageItem->package->updateTotalPrice();
            }
        });
    }
}
