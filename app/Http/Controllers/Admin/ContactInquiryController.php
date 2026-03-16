<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Inertia\Inertia;

class ContactInquiryController extends Controller
{
    public function index()
    {
        $inquiries = ContactInquiry::orderByRaw('is_read ASC, created_at DESC')
            ->paginate(30);

        return Inertia::render('Admin/ContactInquiries/Index', [
            'inquiries'    => $inquiries,
            'unread_count' => ContactInquiry::where('is_read', false)->count(),
        ]);
    }

    public function markRead(ContactInquiry $inquiry)
    {
        $inquiry->update(['is_read' => true]);
        return back();
    }

    public function destroy(ContactInquiry $inquiry)
    {
        $inquiry->delete();
        return back();
    }
}
