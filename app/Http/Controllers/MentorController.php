<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Inertia\Inertia;

class MentorController extends Controller
{
    public function index()
    {
        $query = User::where('role', 'mentor')
            ->where('is_active', true)
            ->with(['categories', 'skills'])
            ->withCount('packages');

        // Filters
        if (request('category')) {
            $query->whereHas('categories', fn($q) => $q->where('slug', request('category')));
        }

        if (request('min_rate')) {
            $query->where('hourly_rate', '>=', request('min_rate'));
        }

        if (request('max_rate')) {
            $query->where('hourly_rate', '<=', request('max_rate'));
        }

        if (request('min_rating')) {
            $query->where('avg_rating', '>=', request('min_rating'));
        }

        if (request('search')) {
            $search = request('search');
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('bio', 'like', "%{$search}%"));
        }

        $sortBy = request('sort', 'featured');
        match($sortBy) {
            'rating' => $query->orderByDesc('avg_rating'),
            'reviews' => $query->orderByDesc('total_reviews'),
            'students' => $query->orderByDesc('total_students'),
            'price_low' => $query->orderBy('hourly_rate'),
            'price_high' => $query->orderByDesc('hourly_rate'),
            default => $query->orderByDesc('is_featured')->orderByDesc('avg_rating'),
        };

        $mentors = $query->paginate(12)->through(fn ($m) => [
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
            'is_featured' => $m->is_featured,
            'categories' => $m->categories->map(fn ($c) => ['name' => $c->name, 'slug' => $c->slug]),
            'skills' => $m->skills->take(5)->pluck('name'),
        ]);

        $categories = Category::where('is_active', true)->orderBy('sort_order')->get(['id', 'name', 'slug']);

        return Inertia::render('Mentors/Index', [
            'mentors' => $mentors,
            'categories' => $categories,
            'filters' => request()->only(['category', 'min_rate', 'max_rate', 'min_rating', 'search', 'sort']),
        ]);
    }

    public function show($slug)
    {
        $mentor = User::where('slug', $slug)
            ->where('role', 'mentor')
            ->where('is_active', true)
            ->with([
                'categories',
                'skills',
                'education',
                'certificates',
                'achievements',
                'professionals',
                'packages' => fn($q) => $q->where('is_active', true)->with(['category', 'packageType']),
                'reviews' => fn($q) => $q->where('is_approved', true)->with('user')->latest()->limit(10),
            ])
            ->firstOrFail();

        return Inertia::render('Mentors/Show', [
            'mentor' => [
                'id' => $mentor->id,
                'name' => $mentor->name,
                'slug' => $mentor->slug,
                'title' => $mentor->title,
                'location' => $mentor->location,
                'country' => $mentor->country,
                'bio' => $mentor->bio,
                'linkedin' => $mentor->linkedin,
                'twitter' => $mentor->twitter,
                'website' => $mentor->website,
                'profile_photo_url' => $mentor->profile_photo_url,
                'cover_photo_url' => $mentor->cover_photo_url,
                'avg_rating' => $mentor->avg_rating,
                'total_reviews' => $mentor->total_reviews,
                'total_students' => $mentor->total_students,
                'hourly_rate' => $mentor->hourly_rate,
                'currency' => $mentor->currency,
                'years_experience' => $mentor->years_experience,
                'is_featured' => $mentor->is_featured,
                'categories' => $mentor->categories,
                'skills' => $mentor->skills->pluck('name'),
                'education' => $mentor->education,
                'certificates' => $mentor->certificates,
                'achievements' => $mentor->achievements,
                'professionals' => $mentor->professionals,
                'packages' => $mentor->packages->map(fn ($p) => [
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
                    'thumbnail_url' => $p->thumbnail_url,
                    'category' => ['name' => $p->category->name],
                    'package_type' => ['name' => $p->packageType->name],
                ]),
                'reviews' => $mentor->reviews->map(fn ($r) => [
                    'id' => $r->id,
                    'rating' => $r->rating,
                    'title' => $r->title,
                    'body' => $r->body,
                    'created_at' => $r->created_at->diffForHumans(),
                    'user' => [
                        'name' => $r->user->name,
                        'profile_photo_url' => $r->user->profile_photo_url,
                    ],
                ]),
            ],
        ]);
    }
}
