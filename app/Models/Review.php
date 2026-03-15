<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'package_id', 'user_id', 'mentor_id', 'rating', 'title', 'body',
        'is_approved', 'approved_at',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
