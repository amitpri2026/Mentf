<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackageRegister;
use App\Models\Review;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_users' => User::count(),
                'total_mentors' => User::where('role', 'mentor')->count(),
                'total_mentees' => User::where('role', 'mentee')->count(),
                'total_packages' => Package::count(),
                'total_enrollments' => PackageRegister::count(),
                'total_categories' => Category::count(),
                'total_reviews' => Review::count(),
                'active_packages' => Package::where('is_active', true)->count(),
            ],
            'recentUsers' => User::latest()->limit(10)->get(['id', 'name', 'email', 'role', 'created_at']),
            'recentEnrollments' => PackageRegister::with(['user', 'package'])->latest()->limit(10)->get()->map(fn($e) => [
                'id' => $e->id,
                'status' => $e->status,
                'amount_paid' => $e->amount_paid,
                'created_at' => $e->created_at->format('M d, Y'),
                'user' => ['name' => $e->user->name],
                'package' => ['title' => $e->package->title],
            ]),
        ]);
    }

    public function spa()
    {
        return Inertia::render('Admin/Dashboard');
    }
}
