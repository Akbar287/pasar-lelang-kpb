<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\DokumenProduk;
use App\Models\Lelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class DokumenProdukLelangListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Lelang $lelang)
    {
        if ($request->ajax()) {
            $data = $lelang->dokumen_produk()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gambar', function ($row) {
                    $actionBtn = '<img src="' . asset('storage/produk/' . $row->nama_file) . '" alt="' . $row->nama_dokumen . '" width="150" height="150" class="img img-thumbnail" />';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('transaksi.lelang_list.file.show', [$row->lelang()->first()->lelang_id, $row->dokumen_produk_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('transaksi_pasar_lelang/file_lelang_list/index', compact('lelang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Lelang $lelang)
    {
        return view('transaksi_pasar_lelang/file_lelang_list/create', compact('lelang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Lelang $lelang)
    {
        $foto = 'default.png';
        $filenameWithExt = '';

        if ($request->hasFile('gambar')) {
            $filenameWithExt = $request->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $request->file('gambar')->storeAs('public/produk', $foto);
        }

        if (request('is_gambar_utama') == 'true') {
            foreach ($lelang->dokumen_produk()->get() as $dp) {
                $dp->update([
                    'is_gambar_utama' => false
                ]);
            }
        }

        $file = $lelang->dokumen_produk()->create($this->dokumenProdukFile($foto, $filenameWithExt, request('is_gambar_utama')));
        return redirect('/transaksi/list_lelang/' . $lelang->lelang_id . '/file/' . $file->dokumen_produk_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data File Lelang sudah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lelang $lelang, DokumenProduk $file)
    {
        return view('transaksi_pasar_lelang/file_lelang_list/show', compact('lelang', 'file'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lelang $lelang, DokumenProduk $file)
    {
        return view('transaksi_pasar_lelang/file_lelang_list/edit', compact('lelang', 'file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lelang $lelang, DokumenProduk $file)
    {
        $foto = $file->nama_file;
        $filenameWithExt = $file->nama_dokumen;

        if ($request->hasFile('gambar')) {
            if ($file->nama_file != 'default.png') {
                Storage::delete("public/produk/" . $file->nama_file);
            }

            $filenameWithExt = $request->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $request->file('gambar')->storeAs('public/produk', $foto);
        }

        $file->update($this->dokumenProdukFile($foto, $filenameWithExt, request('is_gambar_utama')));

        return redirect('/transaksi/list_lelang/' . $lelang->lelang_id . '/file/' . $file->dokumen_produk_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data File Lelang sudah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lelang $lelang, DokumenProduk $file)
    {
        if ($file->nama_file != 'default.png') {
            Storage::delete("public/produk/" . $file->nama_file);
        }

        $file->delete();

        if ($lelang->dokumen_produk()->where('is_gambar_utama')->count() == 0 && $lelang->dokumen_produk()->count() > 0) {
            $lelang->dokumen_produk()->first()->update([
                'is_gambar_utama' => true
            ]);
        }

        return redirect('/transaksi/list_lelang/' . $lelang->lelang_id . '/file')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data File Lelang sudah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function download(Lelang $lelang, DokumenProduk $file)
    {
        return Storage::download('public/produk/' . $file->nama_file);
    }

    public function dokumenProdukFile($file, $dokumen, $isUtama = null)
    {
        return [
            'keterangan' => request('keterangan'),
            'nama_dokumen' => $dokumen,
            'nama_file' => $file,
            'is_gambar_utama' => $isUtama == 'true' ? true : false,
            'tanggal_upload' => date('Y-m-d')
        ];
    }
}
