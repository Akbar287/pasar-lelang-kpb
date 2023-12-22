<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Models\Admin;
use App\Models\BlogKategori;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BlogPostController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogPost::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    $actionBtn = $row->title;
                    return $actionBtn;
                })
                ->addColumn('published_at', function ($row) {
                    $actionBtn = is_null($row->published_at) ? '<div class="badge badge-danger">Belum Publish</div>' : $row->published_at;
                    return $actionBtn;
                })
                ->addColumn('kategori', function ($row) {
                    $temp = [];
                    foreach ($row->blog_kategori()->get() as $bk) {
                        $temp[] = $bk->title;
                    }
                    return join(', ', $temp);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('blog.post.show', $row->blog_post_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'published_at'])
                ->make(true);
        }
        return view('blog/post/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin = Admin::get();
        $kategori = BlogKategori::select('blog_kategori_id')->addSelect('title')->get();
        $tag = BlogTag::select('blog_tag_id')->addSelect('title')->get();
        return view('blog/post/create', compact('kategori', 'tag', 'admin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostRequest $blogPostRequest)
    {
        $blogPost = BlogPost::create($this->blogPostData());

        if (!is_null(request('tag'))) {
            foreach (request('tag') as $t) {
                DB::table('blog_post_tag')->insert([
                    'blog_tag_id' => $t,
                    'blog_post_id' => $blogPost->blog_post_id
                ]);
            }
        }

        DB::table('blog_post_kategori')->insert([
            'blog_kategori_id' => $blogPostRequest->kategori,
            'blog_post_id' => $blogPost->blog_post_id
        ]);

        return redirect('/blog/post/' . $blogPost->blog_post_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Post Blog telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        return view('blog/post/show', compact('blogPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        $admin = Admin::get();
        $kategori = BlogKategori::select('blog_kategori_id')->addSelect('title')->get();
        $tag = BlogTag::select('blog_tag_id')->addSelect('title')->get();
        $tagHelper = [];
        foreach (DB::table('blog_post_tag')->select('blog_tag_id')->where('blog_post_id', $blogPost->blog_post_id)->get() as $th) {
            $tagHelper[] = $th->blog_tag_id;
        }
        return view('blog/post/edit', compact('blogPost', 'admin', 'kategori', 'tag', 'tagHelper'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostRequest $blogPostRequest, BlogPost $blogPost)
    {
        $blogPost->update($this->blogPostData());

        if (!is_null(request('tag'))) {
            DB::table('blog_post_tag')->where('blog_post_id', $blogPost->blog_post_id)->delete();
            foreach (request('tag') as $t) {
                DB::table('blog_post_tag')->insert([
                    'blog_tag_id' => $t,
                    'blog_post_id' => $blogPost->blog_post_id
                ]);
            }
        }

        DB::table('blog_post_kategori')->where('blog_post_id', $blogPost->blog_post_id)->delete();
        DB::table('blog_post_kategori')->insert([
            'blog_kategori_id' => $blogPostRequest->kategori,
            'blog_post_id' => $blogPost->blog_post_id
        ]);

        return redirect('/blog/post/' . $blogPost->blog_post_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Post Blog telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect('/blog/post')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Post Blog telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function blogPostData()
    {
        return [
            'admin_id' => request('admin'),
            'title' => request('title'),
            'slug' => request('slug'),
            'summary' => request('summary'),
            'content' => request('content'),
            'published' => null,
            'published_at' => null,
        ];
    }

    public function publish(Request $request, BlogPost $blogPost)
    {
        $request->validate([
            'jenis' => ['required']
        ]);

        if ($request->jenis == 'publish') {
            $blogPost->update([
                'published' => true,
                'published_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $blogPost->update([
                'published' => false,
                'published_at' => null
            ]);
        }

        return redirect('/blog/post/' . $blogPost->blog_post_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Post Blog telah diubah status Publish.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
