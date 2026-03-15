<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageRegister extends Model
{
    protected $fillable = [
        'package_id', 'user_id', 'status', 'amount_paid', 'currency',
        'payment_status', 'payment_method', 'transaction_id',
        'enrolled_at', 'completed_at', 'notes',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'amount_paid' => 'float',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
