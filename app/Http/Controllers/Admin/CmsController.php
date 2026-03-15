<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CmsController extends Controller
{
    private array $cmsKeys = [
        'page_about',
        'page_privacy',
        'page_contact_email',
        'page_contact_phone',
        'page_contact_address',
    ];

    public function index()
    {
        $settings = SiteSetting::whereIn('key', $this->cmsKeys)
            ->get()->keyBy('key');

        return Inertia::render('Admin/Cms/Index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'page_about'           => 'nullable|string',
            'page_privacy'         => 'nullable|string',
            'page_contact_email'   => 'nullable|email|max:200',
            'page_contact_phone'   => 'nullable|string|max:50',
            'page_contact_address' => 'nullable|string|max:500',
        ]);

        foreach ($this->cmsKeys as $key) {
            SiteSetting::set($key, $request->input($key, ''));
        }

        return back()->with('success', 'Pages updated.');
    }
}
