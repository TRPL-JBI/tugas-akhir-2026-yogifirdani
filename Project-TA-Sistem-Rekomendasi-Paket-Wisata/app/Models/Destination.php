<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $fillable = [
        'destination_name',
        'slug',
        'city',
        'address',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot method to automatically generate a unique slug on save.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->destination_name) . '-' . time();
            }
        });
    }
}
