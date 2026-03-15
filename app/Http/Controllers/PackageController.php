<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\PackageType;
use Inertia\Inertia;

class PackageController extends Controller
{
    public function index()
    {
        $query = Package::where('is_active', true)
            ->with(['mentor', 'category', 'packageType']);

        if (request('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', request('category')));
        }

        if (request('type')) {
            $query->whereHas('packageType', fn($q) => $q->where('slug', request('type')));
        }

        if (request('level')) {
            $query->where('level', request('level'));
        }

        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        if (request('search')) {
            $search = request('search');
            $query->where(fn($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        $sortBy = request('sort', 'popular');
        match($sortBy) {
            'rating' => $query->orderByDesc('avg_rating'),
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'newest' => $query->latest(),
            default => $query->orderByDesc('total_enrollments'),
        };

        $packages = $query->paginate(12)->through(fn ($p) => [
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
            'is_featured' => $p->is_featured,
            'mentor' => [
                'name' => $p->mentor->name,
                'slug' => $p->mentor->slug,
                'profile_photo_url' => $p->mentor->profile_photo_url,
            ],
            'category' => ['name' => $p->category->name, 'slug' => $p->category->slug],
            'package_type' => ['name' => $p->packageType->name],
        ]);

        $categories = Category::where('is_active', true)->orderBy('sort_order')->get(['id', 'name', 'slug']);
        $packageTypes = PackageType::where('is_active', true)->orderBy('sort_order')->get(['id', 'name', 'slug']);

        return Inertia::render('Packages/Index', [
            'packages' => $packages,
            'categories' => $categories,
            'packageTypes' => $packageTypes,
            'filters' => request()->only(['category', 'type', 'level', 'min_price', 'max_price', 'search', 'sort']),
        ]);
    }

    public function show($slug)
    {
        $package = Package::where('slug', $slug)
            ->where('is_active', true)
            ->with(['mentor', 'category', 'packageType', 'topics', 'reviews' => fn($q) => $q->where('is_approved', true)->with('user')->latest()->limit(10)])
            ->firstOrFail();

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = $package->enrollments()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['active', 'completed'])
                ->exists();
        }

        return Inertia::render('Packages/Show', [
            'package' => [
                'id' => $package->id,
                'title' => $package->title,
                'slug' => $package->slug,
                'description' => $package->description,
                'requirements' => $package->requirements,
                'outcomes' => $package->outcomes,
                'price' => $package->price,
                'currency' => $package->currency,
                'duration' => $package->duration,
                'sessions' => $package->sessions,
                'max_students' => $package->max_students,
                'level' => $package->level,
                'language' => $package->language,
                'thumbnail_url' => $package->thumbnail_url,
                'banner_url'    => $package->banner_url,
                'avg_rating' => $package->avg_rating,
                'total_reviews' => $package->total_reviews,
                'total_enrollments' => $package->total_enrollments,
                'is_featured' => $package->is_featured,
                'mentor' => [
                    'id' => $package->mentor->id,
                    'name' => $package->mentor->name,
                    'slug' => $package->mentor->slug,
                    'title' => $package->mentor->title,
                    'bio' => $package->mentor->bio,
                    'profile_photo_url' => $package->mentor->profile_photo_url,
                    'avg_rating' => $package->mentor->avg_rating,
                    'total_reviews' => $package->mentor->total_reviews,
                    'total_students' => $package->mentor->total_students,
                ],
                'category' => $package->category,
                'package_type' => $package->packageType,
                'topics' => $package->topics,
                'reviews' => $package->reviews->map(fn ($r) => [
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
            'isEnrolled' => $isEnrolled,
        ]);
    }
}
