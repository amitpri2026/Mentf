<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ChatMessage;
use App\Models\User;
use App\Services\UserNotificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $conversations = Conversation::with(['mentor', 'mentee', 'latestMessage', 'package'])
            ->where(fn($q) => $q->where('mentor_id', $user->id)->orWhere('mentee_id', $user->id))
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($conv) use ($user) {
                $other = $user->id === $conv->mentor_id ? $conv->mentee : $conv->mentor;
                return [
                    'id'           => $conv->id,
                    'other_user'   => ['id' => $other->id, 'name' => $other->name, 'role' => $other->role, 'profile_photo_url' => $other->profile_photo_url],
                    'package'      => $conv->package ? ['id' => $conv->package->id, 'title' => $conv->package->title] : null,
                    'last_message' => $conv->latestMessage ? ['message' => $conv->latestMessage->message, 'created_at' => $conv->latestMessage->created_at] : null,
                    'unread_count' => $conv->messages()->where('sender_id', '!=', $user->id)->whereNull('read_at')->count(),
                    'last_message_at' => $conv->last_message_at,
                ];
            });

        return Inertia::render('Chat/Index', ['conversations' => $conversations]);
    }

    public function show(Conversation $conversation)
    {
        $user = auth()->user();
        abort_if($conversation->mentor_id !== $user->id && $conversation->mentee_id !== $user->id, 403);

        // Mark messages as read
        $conversation->messages()->where('sender_id', '!=', $user->id)->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'sender_id'  => $m->sender_id,
                'sender'     => ['id' => $m->sender->id, 'name' => $m->sender->name, 'profile_photo_url' => $m->sender->profile_photo_url],
                'is_mine'    => $m->sender_id === $user->id,
                'created_at' => $m->created_at,
            ]);

        $other = $user->id === $conversation->mentor_id ? $conversation->mentee : $conversation->mentor;
        $conversation->load(['mentor', 'mentee', 'package']);

        return Inertia::render('Chat/Show', [
            'conversation' => [
                'id'       => $conversation->id,
                'other_user' => ['id' => $other->id, 'name' => $other->name, 'profile_photo_url' => $other->profile_photo_url],
                'package'  => $conversation->package ? ['id' => $conversation->package->id, 'title' => $conversation->package->title] : null,
            ],
            'messages'     => $messages,
        ]);
    }

    public function send(Request $request, Conversation $conversation)
    {
        $user = auth()->user();
        abort_if($conversation->mentor_id !== $user->id && $conversation->mentee_id !== $user->id, 403);

        $request->validate(['message' => 'required|string|max:5000']);

        $msg = $conversation->messages()->create([
            'sender_id' => $user->id,
            'message'   => $request->message,
        ]);
        $conversation->update(['last_message_at' => now()]);

        // Notify the other participant
        $recipientId = $user->id === $conversation->mentor_id
            ? $conversation->mentee_id
            : $conversation->mentor_id;

        $preview = strlen($request->message) > 80
            ? substr($request->message, 0, 80) . '…'
            : $request->message;

        UserNotificationService::newChatMessage($recipientId, $user->name, $preview, $conversation->id);

        return back();
    }

    public function poll(Conversation $conversation)
    {
        $user = auth()->user();
        abort_if($conversation->mentor_id !== $user->id && $conversation->mentee_id !== $user->id, 403);

        $since = request('since');
        $messages = $conversation->messages()->with('sender')
            ->when($since, fn($q) => $q->where('id', '>', $since))
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'sender_id'  => $m->sender_id,
                'sender'     => ['id' => $m->sender->id, 'name' => $m->sender->name, 'profile_photo_url' => $m->sender->profile_photo_url],
                'is_mine'    => $m->sender_id === $user->id,
                'created_at' => $m->created_at,
            ]);

        // Mark as read
        $conversation->messages()->where('sender_id', '!=', $user->id)->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    public function startOrFind(Request $request)
    {
        $user = auth()->user();
        $request->validate(['other_user_id' => 'required|exists:users,id']);

        $other = User::findOrFail($request->other_user_id);

        // Determine who is mentor/mentee
        if ($user->isMentor() && $other->isMentee()) {
            $mentorId = $user->id; $menteeId = $other->id;
        } elseif ($user->isMentee() && $other->isMentor()) {
            $mentorId = $other->id; $menteeId = $user->id;
        } else {
            return back()->withErrors(['error' => 'Chat is only between mentors and mentees.']);
        }

        $conversation = Conversation::firstOrCreate(
            ['mentor_id' => $mentorId, 'mentee_id' => $menteeId],
            ['package_id' => $request->package_id ?? null, 'last_message_at' => now()]
        );

        return redirect()->route('chat.show', $conversation);
    }
}
