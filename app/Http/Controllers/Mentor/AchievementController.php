<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'issuer'      => 'nullable|string|max:255',
            'date'        => 'nullable|date',
            'description' => 'nullable|string|max:1000',
            'url'         => 'nullable|string|max:255',
        ]);

        $validated['user_id']    = auth()->id();
        $validated['sort_order'] = auth()->user()->achievements()->max('sort_order') + 1;

        Achievement::create($validated);
        return back()->with('success', 'Achievement added.');
    }

    public function update(Request $request, Achievement $achievement)
    {
        abort_if($achievement->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'issuer'      => 'nullable|string|max:255',
            'date'        => 'nullable|date',
            'description' => 'nullable|string|max:1000',
            'url'         => 'nullable|string|max:255',
        ]);

        $achievement->update($validated);
        return back()->with('success', 'Achievement updated.');
    }

    public function destroy(Achievement $achievement)
    {
        abort_if($achievement->user_id !== auth()->id(), 403);
        $achievement->delete();
        return back()->with('success', 'Achievement removed.');
    }
}
