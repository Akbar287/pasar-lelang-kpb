<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogPostMeta;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogPostMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BlogPost $blogPost)
    {
        if ($request->ajax()) {
            $data = $blogPost->blog_post_meta()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('blog.post.meta.show', [$row->blog_post()->first()->blog_post_id, $row->blog_post_meta_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('blog/post_meta/index', compact('blogPost'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(BlogPost $blogPost)
    {
        return view('blog/post_meta/create', compact('blogPost'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, BlogPost $blogPost)
    {
        $request->validate([
            'key' => ['required'],
            'content' => ['required'],
        ]);

        $blogPostMeta = $blogPost->blog_post_meta()->create($this->blogPostMetaData());

        return redirect('/blog/post/' . $blogPost->blog_post_id . '/meta/' . $blogPostMeta->blog_post_meta_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Meta Post Blog telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost, BlogPostMeta $blogPostMeta)
    {
        return view('blog/post_meta/show', compact('blogPost', 'blogPostMeta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost, BlogPostMeta $blogPostMeta)
    {
        return view('blog/post_meta/edit', compact('blogPost', 'blogPostMeta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blogPost, BlogPostMeta $blogPostMeta)
    {
        $request->validate([
            'key' => ['required'],
            'content' => ['required'],
        ]);

        $blogPostMeta->update($this->blogPostMetaData());

        return redirect('/blog/post/' . $blogPost->blog_post_id . '/meta/' . $blogPostMeta->blog_post_meta_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Meta Post Blog telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost, BlogPostMeta $blogPostMeta)
    {
        $blogPostMeta->delete();

        return redirect('/blog/post/' . $blogPost->blog_post_id . '/meta')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Meta Post Blog telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function blogPostMetaData()
    {
        return [
            'key' => request('key'),
            'content' => request('content'),
        ];
    }
}
