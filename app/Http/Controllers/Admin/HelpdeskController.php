<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HelpdeskController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with(['user', 'assignedTo'])->withCount('replies');

        if ($request->status) $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);
        if ($request->search) $query->where('subject', 'like', "%{$request->search}%");

        $tickets = $query->latest()->paginate(20)->withQueryString();
        $agents  = User::where('role', 'admin')->select('id', 'name')->get();

        return Inertia::render('Admin/Helpdesk/Index', [
            'tickets' => $tickets,
            'agents'  => $agents,
            'filters' => $request->only(['status', 'priority', 'search']),
            'stats'   => [
                'open'        => SupportTicket::where('status', 'open')->count(),
                'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
                'resolved'    => SupportTicket::where('status', 'resolved')->count(),
                'total'       => SupportTicket::count(),
            ],
        ]);
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['user', 'replies.user', 'assignedTo']);
        $agents = User::where('role', 'admin')->select('id', 'name')->get();

        return Inertia::render('Admin/Helpdesk/Show', [
            'ticket' => $ticket,
            'agents' => $agents,
        ]);
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate(['message' => 'required|string|max:5000']);

        TicketReply::create([
            'ticket_id'      => $ticket->id,
            'user_id'        => auth()->id(),
            'message'        => $request->message,
            'is_staff_reply' => true,
        ]);

        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Reply sent.');
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status'      => 'sometimes|in:open,in_progress,resolved,closed',
            'priority'    => 'sometimes|in:low,medium,high,urgent',
            'assigned_to' => 'sometimes|nullable|exists:users,id',
        ]);

        $ticket->update($request->only(['status', 'priority', 'assigned_to']));

        return back()->with('success', 'Ticket updated.');
    }
}
