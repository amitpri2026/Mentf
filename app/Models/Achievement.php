<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['user_id', 'title', 'issuer', 'date', 'description', 'url', 'sort_order'];

    protected $casts = ['date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
