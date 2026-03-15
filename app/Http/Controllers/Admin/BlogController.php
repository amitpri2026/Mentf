<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::orderByDesc('created_at')->get();

        return Inertia::render('Admin/Blog/Index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Blog/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required|string',
            'is_published' => 'boolean',
        ]);

        $data['slug']         = Str::slug($data['title']);
        $data['published_at'] = $data['is_published'] ? now() : null;

        // Ensure unique slug
        $base  = $data['slug'];
        $count = 1;
        while (BlogPost::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $base . '-' . $count++;
        }

        BlogPost::create($data);

        return redirect('/admin/blog')->with('success', 'Post created.');
    }

    public function edit(BlogPost $post)
    {
        return Inertia::render('Admin/Blog/Edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required|string',
            'is_published' => 'boolean',
        ]);

        if ($data['is_published'] && ! $post->is_published) {
            $data['published_at'] = now();
        } elseif (! $data['is_published']) {
            $data['published_at'] = null;
        }

        $post->update($data);

        return redirect('/admin/blog')->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();

        return back()->with('success', 'Post deleted.');
    }
}
