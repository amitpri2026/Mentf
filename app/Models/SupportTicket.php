<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['user_id', 'assigned_to', 'subject', 'message', 'status', 'priority', 'category'];

    public function user() { return $this->belongsTo(User::class); }
    public function assignedTo() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function replies() { return $this->hasMany(TicketReply::class, 'ticket_id'); }

    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'open' => 'blue',
            'in_progress' => 'yellow',
            'resolved' => 'green',
            'closed' => 'slate',
            default => 'slate',
        };
    }

    public function getPriorityColorAttribute(): string {
        return match($this->priority) {
            'low' => 'slate',
            'medium' => 'blue',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'slate',
        };
    }
}
