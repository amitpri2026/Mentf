<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\User;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $mentors = User::where('role', 'mentor')
            ->where('is_active', true)
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->with(['skills'])
            ->orderByDesc('avg_rating')
            ->limit(8)
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'slug' => $m->slug,
                'title' => $m->title,
                'profile_photo_url' => $m->profile_photo_url,
                'avg_rating' => $m->avg_rating,
                'total_reviews' => $m->total_reviews,
                'hourly_rate' => $m->hourly_rate,
                'skills' => $m->skills->take(3)->pluck('name'),
            ]);

        $packages = Package::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['mentor', 'packageType'])
            ->orderByDesc('total_enrollments')
            ->limit(8)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'price' => $p->price,
                'currency' => $p->currency,
                'avg_rating' => $p->avg_rating,
                'total_reviews' => $p->total_reviews,
                'mentor' => ['name' => $p->mentor->name, 'slug' => $p->mentor->slug],
                'package_type' => ['name' => $p->packageType->name],
            ]);

        return Inertia::render('Categories/Show', [
            'category' => $category,
            'mentors' => $mentors,
            'packages' => $packages,
        ]);
    }
}
