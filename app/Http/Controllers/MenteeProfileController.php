<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\PackageRegister;
use App\Models\User;
use Inertia\Inertia;

class MenteeProfileController extends Controller
{
    public function show(User $mentee)
    {
        abort_if(!$mentee->isMentee(), 404);

        $viewer = auth()->user();

        // Only the mentor whose mentee this is (enrolled) or admin can view
        $isEnrolled = false;
        if ($viewer->isMentor()) {
            $isEnrolled = PackageRegister::whereHas('package', fn($q) => $q->where('user_id', $viewer->id))
                ->where('user_id', $mentee->id)
                ->exists();
            abort_if(!$isEnrolled, 403, 'You can only view profiles of your enrolled students.');
        }

        $mentee->load(['skills', 'education', 'achievements', 'certificates']);

        // Find or check existing conversation
        $conversation = null;
        if ($viewer->isMentor()) {
            $conversation = Conversation::where('mentor_id', $viewer->id)
                ->where('mentee_id', $mentee->id)
                ->first();
        }

        // Enrollments with this mentor
        $enrollments = PackageRegister::where('user_id', $mentee->id)
            ->when($viewer->isMentor(), fn($q) => $q->whereHas('package', fn($p) => $p->where('user_id', $viewer->id)))
            ->with('package:id,title,slug')
            ->get()
            ->map(fn($e) => [
                'id'          => $e->id,
                'status'      => $e->status,
                'enrolled_at' => $e->enrolled_at?->format('M d, Y'),
                'package'     => ['title' => $e->package->title, 'slug' => $e->package->slug],
            ]);

        return Inertia::render('Mentee/Profile', [
            'mentee'          => array_merge($mentee->toArray(), [
                'profile_photo_url' => $mentee->profile_photo_url,
                'cover_photo_url'   => $mentee->cover_photo_url,
            ]),
            'enrollments'     => $enrollments,
            'conversation_id' => $conversation?->id,
        ]);
    }
}
