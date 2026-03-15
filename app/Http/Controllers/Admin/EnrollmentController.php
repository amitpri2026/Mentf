<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageRegister;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $enrollments = PackageRegister::with(['user', 'package.mentor'])
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Enrollments/Index', [
            'enrollments' => $enrollments,
        ]);
    }

    public function apiIndex(Request $request)
    {
        return PackageRegister::with(['user:id,name,email', 'package:id,title,user_id', 'package.mentor:id,name'])
            ->latest()
            ->paginate(20);
    }

    public function apiUpdate(Request $request, PackageRegister $enrollment)
    {
        $enrollment->update($request->only(['status', 'payment_status']));
        return response()->json($enrollment);
    }
}
