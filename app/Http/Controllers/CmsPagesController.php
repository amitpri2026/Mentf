<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CmsPagesController extends Controller
{
    public function about()
    {
        return Inertia::render('About', [
            'content' => SiteSetting::get('page_about', ''),
        ]);
    }

    public function privacy()
    {
        return Inertia::render('Privacy', [
            'content' => SiteSetting::get('page_privacy', ''),
        ]);
    }

    public function contact()
    {
        return Inertia::render('Contact', [
            'email' => SiteSetting::get('page_contact_email', ''),
            'phone' => SiteSetting::get('page_contact_phone', ''),
        ]);
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:200',
            'phone'   => 'required|string|max:30',
            'message' => 'nullable|string|max:2000',
        ]);

        ContactInquiry::create($request->only('name', 'email', 'phone', 'message'));

        return back()->with('success', 'Thank you! We will get back to you shortly.');
    }
}
