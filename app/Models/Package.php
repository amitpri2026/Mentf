<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'package_type_id', 'title', 'slug',
        'description', 'requirements', 'outcomes', 'price', 'currency',
        'duration', 'sessions', 'max_students', 'level', 'language',
        'thumbnail', 'banner', 'is_active', 'is_featured', 'avg_rating',
        'total_reviews', 'total_enrollments',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'float',
        'avg_rating' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($pkg) {
            if (empty($pkg->slug)) {
                $pkg->slug = Str::slug($pkg->title) . '-' . Str::random(5);
            }
        });
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function packageType()
    {
        return $this->belongsTo(PackageType::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class)->orderBy('sort_order');
    }

    public function enrollments()
    {
        return $this->hasMany(PackageRegister::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner ? asset('storage/' . $this->banner) : null;
    }
}
