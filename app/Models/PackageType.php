<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
