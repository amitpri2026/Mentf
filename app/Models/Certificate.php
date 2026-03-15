<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id', 'name', 'issuing_org', 'issue_date', 'expiry_date',
        'no_expiry', 'credential_id', 'credential_url', 'image', 'sort_order',
    ];

    protected $casts = [
        'no_expiry' => 'boolean',
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
