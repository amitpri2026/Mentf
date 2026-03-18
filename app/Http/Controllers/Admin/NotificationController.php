<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::latest()->paginate(30);
        AdminNotification::whereNull('read_at')->update(['read_at' => now()]);

        return Inertia::render('Admin/Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function markRead(AdminNotification $notification)
    {
        $notification->update(['read_at' => now()]);
        return back();
    }

    public function markAllRead()
    {
        AdminNotification::whereNull('read_at')->update(['read_at' => now()]);
        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(AdminNotification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted.');
    }

    public function unreadCount()
    {
        return response()->json(['count' => AdminNotification::unread()->count()]);
    }
}
