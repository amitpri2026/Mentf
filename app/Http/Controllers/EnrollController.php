<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageRegister;

class EnrollController extends Controller
{
    public function store(Package $package)
    {
        $user = auth()->user();

        // Prevent mentor enrolling in their own package
        if ($package->user_id === $user->id) {
            return back()->with('error', 'You cannot enroll in your own package.');
        }

        // Prevent duplicate enrollment
        $already = PackageRegister::where('package_id', $package->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->exists();

        if ($already) {
            return back()->with('error', 'You are already enrolled in this package.');
        }

        PackageRegister::create([
            'package_id'     => $package->id,
            'user_id'        => $user->id,
            'status'         => 'active',
            'amount_paid'    => $package->price,
            'currency'       => $package->currency,
            'payment_status' => 'pending',
            'payment_method' => 'direct',
            'enrolled_at'    => now(),
        ]);

        // Increment total_enrollments counter on package
        $package->increment('total_enrollments');

        return redirect()->route('dashboard')
            ->with('success', "You're enrolled in \"{$package->title}\"! Your mentor has been notified.");
    }
}
