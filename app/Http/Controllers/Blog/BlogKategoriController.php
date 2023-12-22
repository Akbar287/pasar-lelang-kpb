<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogKategoriRequest;
use App\Models\BlogKategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogKategori::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('blog.kategori.show', $row->blog_kategori_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('blog/kategori/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog/kategori/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogKategoriRequest $blogKategoriRequest)
    {
        $blogKategori = BlogKategori::create($this->blogKategoriData());

        return redirect('/blog/kategori/' . $blogKategori->blog_kategori_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Kategori Blog telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogKategori $blogKategori)
    {
        return view('blog/kategori/show', compact('blogKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogKategori $blogKategori)
    {
        return view('blog/kategori/edit', compact('blogKategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogKategoriRequest $blogKategoriRequest, BlogKategori $blogKategori)
    {
        $blogKategori->update($this->blogKategoriData());

        return redirect('/blog/kategori/' . $blogKategori->blog_kategori_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Kategori Blog telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogKategori $blogKategori)
    {
        $blogKategori->delete();

        return redirect('/blog/kategori')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Kategori Blog telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function blogKategoriData()
    {
        return [
            'title' => request('title'),
            'slug' => request('slug'),
            'content' => request('content'),
        ];
    }
}
