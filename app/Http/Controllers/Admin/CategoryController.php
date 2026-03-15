<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => Category::withCount('packages')->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Categories/Form', ['category' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Admin/Categories/Form', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $category->update($request->only(['name', 'description', 'icon', 'color', 'is_active', 'sort_order']));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function apiIndex()
    {
        return Category::withCount('packages')->orderBy('sort_order')->get();
    }

    public function apiUpdate(Request $request, Category $category)
    {
        $category->update($request->only(['name', 'is_active', 'sort_order', 'icon', 'color']));
        return response()->json($category);
    }
}
