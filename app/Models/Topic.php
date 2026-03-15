<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['package_id', 'title', 'description', 'session_number', 'duration', 'sort_order'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
