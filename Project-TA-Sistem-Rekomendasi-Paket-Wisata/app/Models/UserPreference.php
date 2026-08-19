<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = [
        'session_id',
        'category_id',
        'tour_category',
        'description',
        'budget',
        'preferred_duration',
        'preferred_facilities',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
