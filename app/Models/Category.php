<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'color', 'image',
        'is_active', 'sort_order', 'mentors_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'category_user');
    }
}
