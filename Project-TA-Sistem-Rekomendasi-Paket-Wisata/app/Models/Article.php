<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    protected $fillable = [
        'title', 'title_en', 'slug', 'content', 'content_en', 'image', 'status', 'author_id'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the full URL for the article image from S3.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image || $this->image === '0') {
            return null;
        }

        $disk = config('filesystems.default', 'public');

        // Jika menggunakan S3 tapi credentials kosong, fallback ke public
        if ($disk === 's3' && !config('filesystems.disks.s3.key')) {
            $disk = 'public';
        }

        // Gunakan asset() agar URL selalu sesuai host & port yang aktif
        if ($disk === 'public') {
            return asset('storage/' . $this->image);
        }

        return Storage::disk($disk)->url($this->image);
    }

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

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
