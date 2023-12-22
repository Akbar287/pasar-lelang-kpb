<?php

namespace App\Http\Controllers\Konfigurasi\Aplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\AplikasiRequest;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AplikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Aplikasi::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.aplikasi.aplikasi.show', $row->aplikasi_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi.aplikasi.aplikasi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi.aplikasi.aplikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AplikasiRequest $aplikasiRequest)
    {
        $foto = 'default.png';
        if ($aplikasiRequest->hasFile('gambar')) {
            $filenameWithExt = $aplikasiRequest->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $aplikasiRequest->file('gambar')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $aplikasiRequest->file('gambar')->storeAs('public/header', $foto);
        }

        $aplikasi = Aplikasi::create($this->aplikasiData($foto));

        return redirect('/konfigurasi/aplikasi/aplikasi/' . $aplikasi->aplikasi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Aplikasi telah dibuat.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aplikasi $aplikasi)
    {
        return view('konfigurasi.aplikasi.aplikasi.show', compact('aplikasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aplikasi $aplikasi)
    {
        return view('konfigurasi.aplikasi.aplikasi.edit', compact('aplikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AplikasiRequest $aplikasiRequest, Aplikasi $aplikasi)
    {
        $foto = $aplikasi->img_welcome;
        $filenameWithExt = $aplikasi->img_welcome;

        if ($aplikasiRequest->hasFile('gambar')) {
            if ($aplikasi->img_welcome != 'default.png') {
                Storage::delete("public/header/" . $aplikasi->img_welcome);
            }

            $filenameWithExt = $aplikasiRequest->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $aplikasiRequest->file('gambar')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $aplikasiRequest->file('gambar')->storeAs('public/header', $foto);
        }
        $aplikasi->update($this->aplikasiData($foto));

        return redirect('/konfigurasi/aplikasi/aplikasi/' . $aplikasi->aplikasi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Aplikasi telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aplikasi $aplikasi)
    {
        if ($aplikasi->img_welcome != 'default.png') {
            Storage::delete("public/header/" . $aplikasi->img_welcome);
        }
        $aplikasi->delete();

        return redirect('/konfigurasi/aplikasi/aplikasi')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Aplikasi telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function aplikasiData($foto)
    {
        return [
            'nama_aplikasi' => request('nama_aplikasi'),
            'header_description' => request('header_description'),
            'footer_description' => request('footer_description'),
            'img_welcome' => $foto,
        ];
    }
}
