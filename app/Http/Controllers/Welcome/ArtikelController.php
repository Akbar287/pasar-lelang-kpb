<?php

namespace App\Http\Controllers\Welcome;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = BlogPost::where('published', true)->latest()->paginate(6);
        return view('welcome.artikel.index', compact('blog'));
    }

    public function show(BlogPost $post)
    {
        $blog = BlogPost::where('published', true)->orderBy('created_at', 'desc')->whereNotIn('blog_post_id', [$post->blog_post_id])->limit(5)->get();
        return view('welcome.artikel.post', compact('post', 'blog'));
    }

    public function tag(BlogTag $blogTag)
    {
        $blog = $blogTag->blog_post()->where('published', true)->latest()->limit(5)->paginate(6);
        return view('welcome.artikel.tag', compact('blog', 'blogTag'));
    }

    public function user(Admin $admin)
    {
        $blog = $admin->blog_post()->where('published', true)->latest()->limit(5)->paginate(6);
        return view('welcome.artikel.user', compact('blog', 'admin'));
    }
}
