<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'user_id', 'institution', 'degree', 'field_of_study',
        'start_year', 'end_year', 'is_current', 'description', 'sort_order',
    ];

    protected $casts = ['is_current' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
