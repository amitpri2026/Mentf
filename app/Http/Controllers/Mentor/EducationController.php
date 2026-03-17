<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution'    => 'required|string|max:255',
            'degree'         => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year'     => 'nullable|integer|min:1950|max:2030',
            'end_year'       => 'required|integer|min:1950|max:2030',
            'is_current'     => 'boolean',
            'description'    => 'nullable|string|max:1000',
        ]);

        $validated['user_id']    = auth()->id();
        $validated['sort_order'] = auth()->user()->education()->max('sort_order') + 1;

        Education::create($validated);
        return back()->with('success', 'Education added.');
    }

    public function update(Request $request, Education $education)
    {
        abort_if($education->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'institution'    => 'required|string|max:255',
            'degree'         => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year'     => 'nullable|integer|min:1950|max:2030',
            'end_year'       => 'required|integer|min:1950|max:2030',
            'is_current'     => 'boolean',
            'description'    => 'nullable|string|max:1000',
        ]);

        $education->update($validated);
        return back()->with('success', 'Education updated.');
    }

    public function destroy(Education $education)
    {
        abort_if($education->user_id !== auth()->id(), 403);
        $education->delete();
        return back()->with('success', 'Education removed.');
    }
}
