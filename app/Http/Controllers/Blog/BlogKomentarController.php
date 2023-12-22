<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogKomentarRequest;
use App\Models\BlogKomentar;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogKomentarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BlogPost $blogPost)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(BlogPost $blogPost)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogKomentarRequest $blogKomentarRequest, BlogPost $blogPost)
    {
        $blogKomentar = $blogPost->blog_komentar()->create($this->blogKomentarData());
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost, BlogKomentar $blogKomentar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost, BlogKomentar $blogKomentar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogKomentarRequest $blogKomentarRequest, BlogPost $blogPost, BlogKomentar $blogKomentar)
    {
        $blogKomentar->update($this->blogKomentarData());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost, BlogKomentar $blogKomentar)
    {
        $blogKomentar->delete();
    }

    public function blogKomentarData()
    {
        return [
            'blog_post_id' => request('blog_post_id'),
            'title' => request('title'),
            'content' => request('content')
        ];
    }
}
