<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MentorPackageController extends Controller
{
    private function getMentor(int $userId): User
    {
        return User::where('id', $userId)->where('role', 'mentor')->firstOrFail();
    }

    public function index(int $userId)
    {
        $mentor = $this->getMentor($userId);

        $packages = $mentor->packages()
            ->with(['category', 'packageType'])
            ->withCount('enrollments')
            ->latest()
            ->get()
            ->map(fn ($p) => array_merge($p->toArray(), [
                'thumbnail_url' => $p->thumbnail_url,
                'banner_url'    => $p->banner_url,
            ]));

        return Inertia::render('Mentor/Packages/Index', [
            'packages'  => $packages,
            'adminUser' => $mentor->only('id', 'name', 'email'),
        ]);
    }

    public function create(int $userId)
    {
        $mentor = $this->getMentor($userId);

        return Inertia::render('Mentor/Packages/Create', [
            'categories'   => Category::orderBy('name')->get(),
            'packageTypes' => PackageType::where('is_active', true)->orderBy('sort_order')->get(),
            'adminUser'    => $mentor->only('id', 'name', 'email'),
        ]);
    }

    public function store(Request $request, int $userId)
    {
        $mentor = $this->getMentor($userId);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category_id'     => 'required|exists:categories,id',
            'package_type_id' => 'required|exists:package_types,id',
            'price'           => 'required|numeric|min:0',
            'currency'        => 'required|string|max:3',
            'duration'        => 'required|integer|min:15',
            'sessions'        => 'required|integer|min:1',
            'max_students'    => 'required|integer|min:1',
            'level'           => 'required|in:beginner,intermediate,advanced,all',
            'language'        => 'required|string|max:10',
            'requirements'    => 'nullable|string',
            'outcomes'        => 'nullable|string',
            'thumbnail'       => 'nullable|image|max:4096',
            'banner'          => 'nullable|image|max:8192',
        ]);

        $package = $mentor->packages()->create([
            ...$validated,
            'thumbnail' => null,
            'banner'    => null,
            'is_active' => true,
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store("packages/{$package->id}/thumbnail", 'public');
            $package->update(['thumbnail' => $path]);
        }
        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store("packages/{$package->id}/banner", 'public');
            $package->update(['banner' => $path]);
        }

        return redirect("/admin/mentors/{$userId}/packages/{$package->id}/edit")
            ->with('success', 'Package created! Add topics below.');
    }

    public function edit(int $userId, Package $package)
    {
        $mentor = $this->getMentor($userId);
        abort_if($package->user_id !== $mentor->id, 403);

        $package->load(['category', 'packageType', 'topics' => fn ($q) => $q->orderBy('sort_order')]);

        return Inertia::render('Mentor/Packages/Edit', [
            'package'      => array_merge($package->toArray(), [
                'thumbnail_url' => $package->thumbnail_url,
                'banner_url'    => $package->banner_url,
            ]),
            'categories'   => Category::orderBy('name')->get(),
            'packageTypes' => PackageType::where('is_active', true)->orderBy('sort_order')->get(),
            'adminUser'    => $mentor->only('id', 'name', 'email'),
        ]);
    }

    public function update(Request $request, int $userId, Package $package)
    {
        $mentor = $this->getMentor($userId);
        abort_if($package->user_id !== $mentor->id, 403);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category_id'     => 'required|exists:categories,id',
            'package_type_id' => 'required|exists:package_types,id',
            'price'           => 'required|numeric|min:0',
            'currency'        => 'required|string|max:3',
            'duration'        => 'required|integer|min:15',
            'sessions'        => 'required|integer|min:1',
            'max_students'    => 'required|integer|min:1',
            'level'           => 'required|in:beginner,intermediate,advanced,all',
            'language'        => 'required|string|max:10',
            'requirements'    => 'nullable|string',
            'outcomes'        => 'nullable|string',
            'thumbnail'       => 'nullable|image|max:4096',
            'banner'          => 'nullable|image|max:8192',
            'is_active'       => 'boolean',
        ]);

        $package->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($package->thumbnail) Storage::disk('public')->delete($package->thumbnail);
            $path = $request->file('thumbnail')->store("packages/{$package->id}/thumbnail", 'public');
            $package->update(['thumbnail' => $path]);
        }
        if ($request->hasFile('banner')) {
            if ($package->banner) Storage::disk('public')->delete($package->banner);
            $path = $request->file('banner')->store("packages/{$package->id}/banner", 'public');
            $package->update(['banner' => $path]);
        }

        return back()->with('success', 'Package updated successfully.');
    }

    public function destroy(int $userId, Package $package)
    {
        $mentor = $this->getMentor($userId);
        abort_if($package->user_id !== $mentor->id, 403);
        $package->delete();
        return redirect("/admin/mentors/{$userId}/packages")->with('success', 'Package deleted.');
    }
}
