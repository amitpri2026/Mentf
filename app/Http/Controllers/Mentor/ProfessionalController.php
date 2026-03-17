<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company'     => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after:start_date',
            'is_current'  => 'boolean',
            'description' => 'nullable|string|max:1000',
            'location'    => 'nullable|string|max:255',
        ]);

        $validated['user_id']    = auth()->id();
        $validated['sort_order'] = auth()->user()->professionals()->max('sort_order') + 1;

        Professional::create($validated);
        return back()->with('success', 'Experience added.');
    }

    public function update(Request $request, Professional $professional)
    {
        abort_if($professional->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'company'     => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date',
            'is_current'  => 'boolean',
            'description' => 'nullable|string|max:1000',
            'location'    => 'nullable|string|max:255',
        ]);

        $professional->update($validated);
        return back()->with('success', 'Experience updated.');
    }

    public function destroy(Professional $professional)
    {
        abort_if($professional->user_id !== auth()->id(), 403);
        $professional->delete();
        return back()->with('success', 'Experience removed.');
    }
}
