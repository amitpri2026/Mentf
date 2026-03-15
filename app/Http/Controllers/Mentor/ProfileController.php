<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user()->load([
            'categories', 'skills', 'education', 'professionals',
            'achievements', 'certificates',
        ]);

        return Inertia::render('Mentor/Profile/Edit', [
            'mentor'     => array_merge($user->toArray(), [
                'profile_photo_url' => $user->profile_photo_url,
            ]),
            'categories' => Category::orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'title'            => 'nullable|string|max:255',
            'bio'              => 'nullable|string|max:3000',
            'location'         => 'nullable|string|max:255',
            'country'          => 'nullable|string|max:100',
            'timezone'         => 'nullable|string|max:100',
            'linkedin'         => 'nullable|string|max:255',
            'twitter'          => 'nullable|string|max:255',
            'website'          => 'nullable|string|max:255',
            'hourly_rate'      => 'nullable|numeric|min:0',
            'currency'         => 'nullable|string|max:3',
            'years_experience' => 'nullable|integer|min:0|max:60',
            'category_ids'     => 'nullable|array',
            'category_ids.*'   => 'exists:categories,id',
            'skills'           => 'nullable|array',
            'skills.*'         => 'string|max:100',
        ]);

        $user->update([
            'title'            => $validated['title'] ?? null,
            'bio'              => $validated['bio'] ?? null,
            'location'         => $validated['location'] ?? null,
            'country'          => $validated['country'] ?? null,
            'timezone'         => $validated['timezone'] ?? null,
            'linkedin'         => $validated['linkedin'] ?? null,
            'twitter'          => $validated['twitter'] ?? null,
            'website'          => $validated['website'] ?? null,
            'hourly_rate'      => $validated['hourly_rate'] ?? null,
            'currency'         => $validated['currency'] ?? 'USD',
            'years_experience' => $validated['years_experience'] ?? null,
        ]);

        $user->categories()->sync($validated['category_ids'] ?? []);

        $skillIds = collect($validated['skills'] ?? [])->map(
            fn($name) => Skill::firstOrCreate(['name' => trim($name)])->id
        );
        $user->skills()->sync($skillIds);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:4096']);
        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('photo')->store("profiles/{$user->id}", 'public');
        $user->update(['profile_photo' => $path]);

        return back()->with('success', 'Profile photo updated.');
    }
}
