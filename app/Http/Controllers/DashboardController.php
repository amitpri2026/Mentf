<?php

namespace App\Http\Controllers;

use App\Models\PackageRegister;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function mentee()
    {
        $user = Auth::user();

        $enrollments = PackageRegister::where('user_id', $user->id)
            ->with(['package.mentor', 'package.category'])
            ->latest()
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'status' => $e->status,
                'amount_paid' => $e->amount_paid,
                'currency' => $e->currency,
                'enrolled_at' => $e->enrolled_at?->format('M d, Y'),
                'package' => [
                    'title' => $e->package->title,
                    'slug' => $e->package->slug,
                    'mentor' => [
                        'name' => $e->package->mentor->name,
                        'profile_photo_url' => $e->package->mentor->profile_photo_url,
                    ],
                    'category' => ['name' => $e->package->category->name],
                ],
            ]);

        return Inertia::render('Dashboard/MenteeDashboard', [
            'enrollments' => $enrollments,
            'stats' => [
                'total_enrollments' => $enrollments->count(),
                'active_enrollments' => $enrollments->where('status', 'active')->count(),
                'completed_enrollments' => $enrollments->where('status', 'completed')->count(),
            ],
        ]);
    }

    public function mentor()
    {
        $user = Auth::user();

        $packages = $user->packages()
            ->with('category')
            ->withCount('enrollments')
            ->latest()
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'price' => $p->price,
                'currency' => $p->currency,
                'is_active' => $p->is_active,
                'avg_rating' => $p->avg_rating,
                'total_enrollments' => $p->enrollments_count,
                'category' => ['name' => $p->category->name],
            ]);

        $recentEnrollments = PackageRegister::whereHas('package', fn($q) => $q->where('user_id', $user->id))
            ->with(['package', 'user'])
            ->latest()
            ->get()
            ->map(fn ($e) => [
                'id'          => $e->id,
                'status'      => $e->status,
                'amount_paid' => $e->amount_paid,
                'currency'    => $e->currency,
                'enrolled_at' => $e->enrolled_at?->format('M d, Y'),
                'user'        => [
                    'id'                => $e->user->id,
                    'name'              => $e->user->name,
                    'email'             => $e->user->email,
                    'slug'              => $e->user->slug,
                    'profile_photo_url' => $e->user->profile_photo_url,
                ],
                'package' => [
                    'id'    => $e->package->id,
                    'title' => $e->package->title,
                ],
            ]);

        return Inertia::render('Dashboard/MentorDashboard', [
            'packages' => $packages,
            'recentEnrollments' => $recentEnrollments,
            'stats' => [
                'total_packages' => $packages->count(),
                'total_students' => $user->total_students,
                'avg_rating' => $user->avg_rating,
                'total_reviews' => $user->total_reviews,
            ],
        ]);
    }
}
