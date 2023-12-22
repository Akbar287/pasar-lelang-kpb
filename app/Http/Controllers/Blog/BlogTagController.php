<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogTagRequest;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogTag::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('blog.tag.show', $row->blog_tag_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('blog/tag/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog/tag/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogTagRequest $blogTagRequest)
    {
        $blogTag = BlogTag::create($this->blogTagData());

        return redirect('/blog/tag/' . $blogTag->blog_tag_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Tag Blog telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogTag $blogTag)
    {
        return view('blog/tag/show', compact('blogTag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogTag $blogTag)
    {
        return view('blog/tag/edit', compact('blogTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogTagRequest $blogTagRequest, BlogTag $blogTag)
    {
        $blogTag->update($this->blogTagData());

        return redirect('/blog/tag/' . $blogTag->blog_tag_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Tag Blog telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogTag $blogTag)
    {
        $blogTag->delete();

        return redirect('/blog/tag')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Tag Blog telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function blogTagData()
    {
        return [
            'title' => request('title'),
            'slug' => request('slug'),
            'content' => request('content'),
        ];
    }
}
