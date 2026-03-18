<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = ['type', 'title', 'message', 'data', 'read_at'];
    protected $casts = ['data' => 'array', 'read_at' => 'datetime'];

    public function scopeUnread($query) {
        return $query->whereNull('read_at');
    }
}
