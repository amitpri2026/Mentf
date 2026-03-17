<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Professional;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    public function edit(User $user)
    {
        $user->load(['categories', 'skills', 'education', 'professionals', 'achievements', 'certificates']);

        return Inertia::render('Admin/Users/EditProfile', [
            'profileUser' => array_merge($user->toArray(), [
                'profile_photo_url' => $user->profile_photo_url,
            ]),
            'categories' => Category::orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'title'            => 'nullable|string|max:255',
            'bio'              => 'nullable|string|max:5000',
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
            'name'             => $validated['name'],
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

    public function updatePhoto(Request $request, User $user)
    {
        $request->validate(['photo' => 'required|image|max:4096']);

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('photo')->store("profiles/{$user->id}", 'public');
        $user->update(['profile_photo' => $path]);

        return back()->with('success', 'Profile photo updated.');
    }

    // Education
    public function storeEducation(Request $request, User $user)
    {
        $validated = $request->validate([
            'institution'    => 'required|string|max:255',
            'degree'         => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year'     => 'required|integer|min:1950|max:2030',
            'end_year'       => 'nullable|integer|min:1950|max:2030',
            'is_current'     => 'boolean',
            'description'    => 'nullable|string|max:1000',
        ]);

        $validated['user_id']    = $user->id;
        $validated['sort_order'] = $user->education()->max('sort_order') + 1;

        Education::create($validated);
        return back()->with('success', 'Education added.');
    }

    public function updateEducation(Request $request, User $user, Education $education)
    {
        abort_if($education->user_id !== $user->id, 403);

        $validated = $request->validate([
            'institution'    => 'required|string|max:255',
            'degree'         => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year'     => 'required|integer|min:1950|max:2030',
            'end_year'       => 'nullable|integer|min:1950|max:2030',
            'is_current'     => 'boolean',
            'description'    => 'nullable|string|max:1000',
        ]);

        $education->update($validated);
        return back()->with('success', 'Education updated.');
    }

    public function destroyEducation(User $user, Education $education)
    {
        abort_if($education->user_id !== $user->id, 403);
        $education->delete();
        return back()->with('success', 'Education removed.');
    }

    // Professional
    public function storeProfessional(Request $request, User $user)
    {
        $validated = $request->validate([
            'company'     => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date',
            'is_current'  => 'boolean',
            'description' => 'nullable|string|max:1000',
            'location'    => 'nullable|string|max:255',
        ]);

        $validated['user_id']    = $user->id;
        $validated['sort_order'] = $user->professionals()->max('sort_order') + 1;

        Professional::create($validated);
        return back()->with('success', 'Experience added.');
    }

    public function updateProfessional(Request $request, User $user, Professional $professional)
    {
        abort_if($professional->user_id !== $user->id, 403);

        $validated = $request->validate([
            'company'     => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date',
            'is_current'  => 'boolean',
            'description' => 'nullable|string|max:1000',
            'location'    => 'nullable|string|max:255',
        ]);

        $professional->update($validated);
        return back()->with('success', 'Experience updated.');
    }

    public function destroyProfessional(User $user, Professional $professional)
    {
        abort_if($professional->user_id !== $user->id, 403);
        $professional->delete();
        return back()->with('success', 'Experience removed.');
    }

    // Achievement
    public function storeAchievement(Request $request, User $user)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'issuer'      => 'nullable|string|max:255',
            'date'        => 'nullable|date',
            'description' => 'nullable|string|max:1000',
            'url'         => 'nullable|string|max:255',
        ]);

        $validated['user_id']    = $user->id;
        $validated['sort_order'] = $user->achievements()->max('sort_order') + 1;

        Achievement::create($validated);
        return back()->with('success', 'Achievement added.');
    }

    public function updateAchievement(Request $request, User $user, Achievement $achievement)
    {
        abort_if($achievement->user_id !== $user->id, 403);

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

    public function destroyAchievement(User $user, Achievement $achievement)
    {
        abort_if($achievement->user_id !== $user->id, 403);
        $achievement->delete();
        return back()->with('success', 'Achievement removed.');
    }

    // Certificate
    public function storeCertificate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'issuing_org'    => 'required|string|max:255',
            'issue_date'     => 'nullable|date',
            'expiry_date'    => 'nullable|date',
            'no_expiry'      => 'boolean',
            'credential_id'  => 'nullable|string|max:255',
            'credential_url' => 'nullable|string|max:255',
        ]);

        $validated['user_id']    = $user->id;
        $validated['sort_order'] = $user->certificates()->max('sort_order') + 1;

        Certificate::create($validated);
        return back()->with('success', 'Certificate added.');
    }

    public function updateCertificate(Request $request, User $user, Certificate $certificate)
    {
        abort_if($certificate->user_id !== $user->id, 403);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'issuing_org'    => 'required|string|max:255',
            'issue_date'     => 'nullable|date',
            'expiry_date'    => 'nullable|date',
            'no_expiry'      => 'boolean',
            'credential_id'  => 'nullable|string|max:255',
            'credential_url' => 'nullable|string|max:255',
        ]);

        $certificate->update($validated);
        return back()->with('success', 'Certificate updated.');
    }

    public function destroyCertificate(User $user, Certificate $certificate)
    {
        abort_if($certificate->user_id !== $user->id, 403);
        $certificate->delete();
        return back()->with('success', 'Certificate removed.');
    }
}
