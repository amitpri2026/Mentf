<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->withCount(['comments'])
            ->orderByDesc('published_at')
            ->get(['id', 'title', 'slug', 'excerpt', 'published_at']);

        return Inertia::render('Blog/Index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();

        $comments = $post->comments()
            ->select('id', 'author_name', 'content', 'created_at', 'user_id')
            ->get();

        return Inertia::render('Blog/Show', [
            'post'            => $post,
            'comments'        => $comments,
            'comment_success' => session('comment_success'),
        ]);
    }
}
