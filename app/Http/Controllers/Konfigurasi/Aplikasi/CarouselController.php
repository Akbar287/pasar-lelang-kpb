<?php

namespace App\Http\Controllers\Konfigurasi\Aplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarouselRequest;
use App\Models\Aplikasi;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Carousel::orderBy('page', 'asc')->orderBy('urutan', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gambar', function ($row) {
                    $actionBtn = '<img src="' . asset('storage/carousel/' . $row->image_src) . '" alt="' . $row->title . '" width="150" height="150" />';
                    return $actionBtn;
                })
                ->addColumn('halaman', function ($row) {
                    $actionBtn = $row->page;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.aplikasi.carousel.show', $row->carousel_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('konfigurasi.aplikasi.carousel.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aplikasi = Aplikasi::get();
        return view('konfigurasi.aplikasi.carousel.create', compact('aplikasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarouselRequest $carouselRequest)
    {
        $aplikasi = Aplikasi::where('aplikasi_id', $carouselRequest->aplikasi_id);
        $foto = 'default.png';
        if ($carouselRequest->hasFile('gambar')) {
            $filenameWithExt = $carouselRequest->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $carouselRequest->file('gambar')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $carouselRequest->file('gambar')->storeAs('public/carousel', $foto);
        }
        $carousel = Carousel::create($this->carouselData($foto));

        return redirect('/konfigurasi/aplikasi/carousel/' . $carousel->carousel_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Carousel telah dibuat.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carousel $carousel)
    {
        return view('konfigurasi.aplikasi.carousel.show', compact('carousel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carousel $carousel)
    {
        $aplikasi = Aplikasi::get();
        return view('konfigurasi.aplikasi.carousel.edit', compact('carousel', 'aplikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarouselRequest $carouselRequest, Carousel $carousel)
    {
        $foto = $carousel->image_src;
        $filenameWithExt = $carousel->image_src;

        if ($carouselRequest->hasFile('gambar')) {
            if ($carousel->image_src != 'default.png') {
                Storage::delete("public/carousel/" . $carousel->image_src);
            }

            $filenameWithExt = $carouselRequest->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $carouselRequest->file('gambar')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $carouselRequest->file('gambar')->storeAs('public/carousel', $foto);
        }

        $carousel->update($this->carouselData($foto));

        return redirect('/konfigurasi/aplikasi/carousel/' . $carousel->carousel_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Carousel telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carousel $carousel)
    {
        if ($carousel->image_src != 'default.png') {
            Storage::delete("public/carousel/" . $carousel->image_src);
        }
        $carousel->delete();

        return redirect('/konfigurasi/aplikasi/carousel')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Carousel telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function carouselData($foto)
    {
        return [
            'aplikasi_id' => request('aplikasi_id'),
            'image_src' => $foto,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'urutan' => request('urutan'),
            'page' => request('page'),
        ];
    }
}
