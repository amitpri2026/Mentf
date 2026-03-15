<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function store(Request $request, Package $package)
    {
        abort_if($package->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'session_number' => 'nullable|integer|min:1',
            'duration'       => 'nullable|integer|min:1',
        ]);

        $validated['sort_order'] = $package->topics()->max('sort_order') + 1;

        $package->topics()->create($validated);

        return back()->with('success', 'Topic added.');
    }

    public function update(Request $request, Package $package, Topic $topic)
    {
        abort_if($package->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'session_number' => 'nullable|integer|min:1',
            'duration'       => 'nullable|integer|min:1',
        ]);

        $topic->update($validated);

        return back()->with('success', 'Topic updated.');
    }

    public function destroy(Package $package, Topic $topic)
    {
        abort_if($package->user_id !== auth()->id(), 403);
        $topic->delete();
        return back()->with('success', 'Topic deleted.');
    }

    public function reorder(Request $request, Package $package)
    {
        abort_if($package->user_id !== auth()->id(), 403);
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $i => $id) {
            $package->topics()->where('id', $id)->update(['sort_order' => $i]);
        }

        return back();
    }
}
