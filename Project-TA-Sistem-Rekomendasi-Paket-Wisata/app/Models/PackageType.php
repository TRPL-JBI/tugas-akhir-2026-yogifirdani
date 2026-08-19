<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    protected $fillable = ['type_name', 'type_name_en', 'slug'];

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

    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class);
    }
}
