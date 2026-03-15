<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index()
    {
        $query = request('q', '');

        $mentors = [];
        $packages = [];

        if ($query) {
            $mentors = User::where('role', 'mentor')
                ->where('is_active', true)
                ->where(fn($q) => $q->where('name', 'like', "%{$query}%")
                    ->orWhere('title', 'like', "%{$query}%")
                    ->orWhere('bio', 'like', "%{$query}%"))
                ->with(['categories'])
                ->limit(10)
                ->get()
                ->map(fn ($m) => [
                    'id' => $m->id,
                    'name' => $m->name,
                    'slug' => $m->slug,
                    'title' => $m->title,
                    'profile_photo_url' => $m->profile_photo_url,
                    'avg_rating' => $m->avg_rating,
                    'categories' => $m->categories->pluck('name'),
                ]);

            $packages = Package::where('is_active', true)
                ->where(fn($q) => $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%"))
                ->with(['mentor', 'category'])
                ->limit(10)
                ->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'price' => $p->price,
                    'currency' => $p->currency,
                    'mentor' => ['name' => $p->mentor->name],
                    'category' => ['name' => $p->category->name],
                ]);
        }

        return Inertia::render('Search', [
            'query' => $query,
            'mentors' => $mentors,
            'packages' => $packages,
        ]);
    }
}
