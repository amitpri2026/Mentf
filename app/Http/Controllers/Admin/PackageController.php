<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::with(['mentor', 'category', 'packageType']);

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $packages = $query->latest()->paginate(20);

        return Inertia::render('Admin/Packages/Index', [
            'packages' => $packages,
            'filters' => $request->only(['search']),
        ]);
    }

    public function update(Request $request, Package $package)
    {
        $package->update($request->only(['is_active', 'is_featured', 'price']));
        return back()->with('success', 'Package updated.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return back()->with('success', 'Package deleted.');
    }

    public function apiIndex(Request $request)
    {
        $query = Package::with(['mentor:id,name', 'category:id,name', 'packageType:id,name']);
        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        return $query->latest()->paginate(20);
    }

    public function apiUpdate(Request $request, Package $package)
    {
        $package->update($request->only(['is_active', 'is_featured']));
        return response()->json($package);
    }
}
