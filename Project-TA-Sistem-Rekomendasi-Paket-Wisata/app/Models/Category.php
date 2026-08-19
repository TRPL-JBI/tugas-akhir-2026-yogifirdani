<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name', 'category_name_en', 'slug', 'description', 'description_en', 'icon', 'is_active'];

    /**
     * Helper to get translated content
     */
    public function getTranslation($field)
    {
        $locale = app()->getLocale();
        if ($locale == 'en') {
            $translatedField = $field . '_en';
            return $this->{$translatedField} ?: $this->{$field};
        }
        return $this->{$field};
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class);
    }
}
