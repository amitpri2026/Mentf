<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $fillable = [
        'user_id', 'company', 'position', 'start_date', 'end_date',
        'is_current', 'description', 'location', 'sort_order',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
