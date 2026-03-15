<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
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
            'email'   => SiteSetting::get('page_contact_email', ''),
            'phone'   => SiteSetting::get('page_contact_phone', ''),
            'address' => SiteSetting::get('page_contact_address', ''),
        ]);
    }
}
