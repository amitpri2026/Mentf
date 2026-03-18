<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['mentor', 'mentee', 'latestMessage', 'package'])
            ->withCount('messages')
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return Inertia::render('Admin/Chat/Index', [
            'conversations' => $conversations,
        ]);
    }

    public function show(Conversation $conversation)
    {
        $conversation->load(['mentor', 'mentee', 'package']);
        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'sender_id'  => $m->sender_id,
                'sender'     => ['id' => $m->sender->id, 'name' => $m->sender->name, 'role' => $m->sender->role, 'profile_photo_url' => $m->sender->profile_photo_url],
                'created_at' => $m->created_at,
            ]);

        return Inertia::render('Admin/Chat/Show', [
            'conversation' => [
                'id'      => $conversation->id,
                'mentor'  => ['id' => $conversation->mentor->id, 'name' => $conversation->mentor->name, 'profile_photo_url' => $conversation->mentor->profile_photo_url],
                'mentee'  => ['id' => $conversation->mentee->id, 'name' => $conversation->mentee->name, 'profile_photo_url' => $conversation->mentee->profile_photo_url],
                'package' => $conversation->package ? ['id' => $conversation->package->id, 'title' => $conversation->package->title] : null,
            ],
            'messages' => $messages,
        ]);
    }
}
