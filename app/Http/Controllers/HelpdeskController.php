<?php
namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketReply;
use App\Services\AdminNotificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HelpdeskController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->withCount('replies')
            ->latest()
            ->get();

        return Inertia::render('Helpdesk/Index', ['tickets' => $tickets]);
    }

    public function create()
    {
        return Inertia::render('Helpdesk/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'  => 'required|string|max:255',
            'message'  => 'required|string|max:5000',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'nullable|string|max:100',
        ]);

        $ticket = SupportTicket::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status'  => 'open',
        ]);

        AdminNotificationService::newTicket(auth()->user()->name, $ticket->subject);

        return redirect()->route('helpdesk.show', $ticket)
            ->with('success', 'Support ticket submitted. Our team will respond shortly.');
    }

    public function show(SupportTicket $ticket)
    {
        abort_if($ticket->user_id !== auth()->id(), 403);
        $ticket->load(['replies.user', 'assignedTo']);

        return Inertia::render('Helpdesk/Show', ['ticket' => $ticket]);
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        abort_if($ticket->user_id !== auth()->id(), 403);
        abort_if(in_array($ticket->status, ['resolved', 'closed']), 403, 'This ticket is closed.');

        $request->validate(['message' => 'required|string|max:5000']);

        TicketReply::create([
            'ticket_id'      => $ticket->id,
            'user_id'        => auth()->id(),
            'message'        => $request->message,
            'is_staff_reply' => false,
        ]);

        return back()->with('success', 'Reply sent.');
    }
}
