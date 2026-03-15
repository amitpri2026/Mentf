<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'author_name'  => 'required|string|max:100',
            'author_email' => 'nullable|email|max:200',
            'content'      => 'required|string|max:2000',
        ]);

        $data['blog_post_id'] = $post->id;
        $data['user_id']      = auth()->id();
        $data['is_approved']  = true;

        // If logged in, use their real name and email
        if (auth()->check()) {
            $data['author_name']  = auth()->user()->name;
            $data['author_email'] = auth()->user()->email;
        }

        BlogComment::create($data);

        return back()->with('comment_success', 'Your comment has been posted!');
    }
}
