<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('key');

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'stat_mentors'    => 'nullable|string|max:20',
            'stat_students'   => 'nullable|string|max:20',
            'stat_packages'   => 'nullable|string|max:20',
            'stat_categories' => 'nullable|string|max:20',
            'hero_tagline'    => 'nullable|string|max:200',
        ]);

        $keys = ['stat_mentors', 'stat_students', 'stat_packages', 'stat_categories', 'hero_tagline'];

        foreach ($keys as $key) {
            SiteSetting::set($key, $request->input($key, ''));
        }

        return back()->with('success', 'Settings saved.');
    }
}
