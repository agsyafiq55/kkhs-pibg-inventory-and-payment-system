<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class ItemVariant extends Model
{
    use HasFactory;

    protected $primaryKey = 'variant_id';
    protected $table = 'item_variants';

    protected $fillable = [
        'items_id',
        'color_id',
        'size_id',
        'supplier_id',
        'barcode',
        'stock',
        'price',
    ];

    protected $appends = [
        'barcode_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($variant) {
            if (empty($variant->barcode)) {
                $variant->barcode = static::generateUniqueBarcode();
            }
        });
    }

    public static function generateUniqueBarcode()
    {
        $prefix = 'SCH';
        $year = date('Y');
        $random = mt_rand(10000, 99999);
        
        $barcode = $prefix . $year . $random;
        
        // Check if barcode already exists
        while (static::where('barcode', $barcode)->exists()) {
            $random = mt_rand(10000, 99999);
            $barcode = $prefix . $year . $random;
        }
        
        return $barcode;
    }

    public function getBarcodeImageAttribute()
    {
        if (!$this->barcode) {
            return null;
        }
        
        try {
            return DNS1D::getBarcodeSVG($this->barcode, 'C128', 2, 50);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getBarcodeHtmlAttribute()
    {
        if (!$this->barcode) {
            return null;
        }
        
        try {
            return DNS1D::getBarcodeHTML($this->barcode, 'C128', 2, 50);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getBarcodePngAttribute()
    {
        if (!$this->barcode) {
            return null;
        }
        
        try {
            return DNS1D::getBarcodePNG($this->barcode, 'C128', 2, 50);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'items_id', 'items_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'size_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
} 