<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $primaryKey = 'stream_id';

    protected $fillable = [
        'stream_name',
        'description',
    ];

    // A stream can have many items
    public function items()
    {
        return $this->hasMany(Item::class, 'stream_id', 'stream_id');
    }
}
