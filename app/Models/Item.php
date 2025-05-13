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
        'item_type',
        'description',
        'subject_id',
        'stream_id',
        'form',
        'has_variants',
    ];

    protected $casts = [
        'has_variants' => 'boolean',
    ];

    public function variants()
    {
        return $this->hasMany(ItemVariant::class, 'items_id', 'items_id');
    }
    
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }
    
    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id', 'stream_id');
    }
    
    // Check if this item is a book
    public function isBook()
    {
        return $this->item_type === 'Book';
    }
    
    // Check if this item is a school supply
    public function isSchoolSupply()
    {
        return $this->item_type === 'School Supply';
    }
} 