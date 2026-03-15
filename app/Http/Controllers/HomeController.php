<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\User;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $featuredMentors = User::where('role', 'mentor')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with(['categories', 'skills'])
            ->withCount('packages')
            ->orderByDesc('avg_rating')
            ->limit(6)
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'slug' => $m->slug,
                'title' => $m->title,
                'location' => $m->location,
                'bio' => $m->bio,
                'profile_photo_url' => $m->profile_photo_url,
                'avg_rating' => $m->avg_rating,
                'total_reviews' => $m->total_reviews,
                'total_students' => $m->total_students,
                'hourly_rate' => $m->hourly_rate,
                'currency' => $m->currency,
                'years_experience' => $m->years_experience,
                'packages_count' => $m->packages_count,
                'categories' => $m->categories->map(fn ($c) => ['name' => $c->name, 'slug' => $c->slug]),
                'skills' => $m->skills->take(4)->pluck('name'),
            ]);

        $popularPackages = Package::where('is_active', true)
            ->with(['mentor', 'category', 'packageType'])
            ->orderByDesc('total_enrollments')
            ->limit(6)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'description' => $p->description,
                'price' => $p->price,
                'currency' => $p->currency,
                'duration' => $p->duration,
                'sessions' => $p->sessions,
                'level' => $p->level,
                'avg_rating' => $p->avg_rating,
                'total_reviews' => $p->total_reviews,
                'total_enrollments' => $p->total_enrollments,
                'thumbnail_url' => $p->thumbnail_url,
                'mentor' => [
                    'name' => $p->mentor->name,
                    'slug' => $p->mentor->slug,
                    'profile_photo_url' => $p->mentor->profile_photo_url,
                    'title' => $p->mentor->title,
                ],
                'category' => ['name' => $p->category->name, 'slug' => $p->category->slug],
                'package_type' => ['name' => $p->packageType->name],
            ]);

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->withCount(['packages' => fn($q) => $q->where('is_active', true)])
            ->get();

        $stats = [
            'mentors' => User::where('role', 'mentor')->where('is_active', true)->count(),
            'students' => User::where('role', 'mentee')->count(),
            'packages' => Package::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
        ];

        return Inertia::render('Home', [
            'featuredMentors' => $featuredMentors,
            'popularPackages' => $popularPackages,
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }
}
