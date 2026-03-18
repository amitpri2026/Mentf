<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['mentor_id', 'mentee_id', 'package_id', 'last_message_at'];
    protected $casts = ['last_message_at' => 'datetime'];

    public function mentor() { return $this->belongsTo(User::class, 'mentor_id'); }
    public function mentee() { return $this->belongsTo(User::class, 'mentee_id'); }
    public function package() { return $this->belongsTo(Package::class); }
    public function messages() { return $this->hasMany(ChatMessage::class); }
    public function latestMessage() { return $this->hasOne(ChatMessage::class)->latestOfMany(); }
}
