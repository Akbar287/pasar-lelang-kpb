<?php

namespace App\Http\Controllers\Administrasi\KasBank;

use App\Http\Controllers\Controller;
use App\Models\FileKeuangan;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class FileKeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Keuangan $keuangan)
    {
        if ($request->ajax()) {
            $data = $keuangan->file_keuangan()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.kas_bank.penerimaan.file.show', [$row->keuangan()->first()->keuangan_id, $row->file_keuangan_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/file_keuangan/index', compact('keuangan'));
    }

    public function index_verifikasi(Request $request, Keuangan $keuangan)
    {
        if ($request->ajax()) {
            $data = $keuangan->file_keuangan()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.kas_bank.verifikasi.file.show', [$row->keuangan()->first()->keuangan_id, $row->file_keuangan_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/verifikasi_file_keuangan/index', compact('keuangan'));
    }

    public function index_list(Request $request, Keuangan $keuangan)
    {
        if ($request->ajax()) {
            $data = $keuangan->file_keuangan()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<img class="img img-thumbnail" style="width: 120px;height: 100px;" src="' . asset('storage/dokumen_keuangan/' . $row->nama_file) . '" alt="' . $row->nama_dokumen . '" />';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/list_file_keuangan/index', compact('keuangan'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Keuangan $keuangan)
    {
        return view('administrasi/kas_bank/file_keuangan/create', compact('keuangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Keuangan $keuangan)
    {
        if ($request->file()) {
            $foto = 'default.png';
            if ($request->hasFile('gambar')) {
                $filenameWithExt = $request->file('gambar')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('gambar')->getClientOriginalExtension();
                $foto = $filename . '_' . time() . '.' . $extension;
                $request->file('gambar')->storeAs('public/dokumen_keuangan', $foto);
            }

            $fileKeuangan = $keuangan->file_keuangan()->create($this->file_keuangan_data($foto, $filenameWithExt, $keuangan->keuangan_id));

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id . '/file/' . $fileKeuangan->file_keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> File Keuangan sudah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Keuangan $keuangan, FileKeuangan $fileKeuangan)
    {
        return view('administrasi/kas_bank/file_keuangan/show', compact('keuangan', 'fileKeuangan'));
    }

    public function show_verifikasi(Keuangan $keuangan, FileKeuangan $fileKeuangan)
    {
        return view('administrasi/kas_bank/verifikasi_file_keuangan/show', compact('keuangan', 'fileKeuangan'));
    }

    public function show_list(Keuangan $keuangan, FileKeuangan $fileKeuangan)
    {
        return view('administrasi/kas_bank/list_file_keuangan/show', compact('keuangan', 'fileKeuangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keuangan $keuangan, FileKeuangan $fileKeuangan)
    {
        return view('administrasi/kas_bank/file_keuangan/edit', compact('keuangan', 'fileKeuangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keuangan $keuangan, FileKeuangan $fileKeuangan)
    {
        if ($request->file()) {
            $foto = $fileKeuangan->nama_file;
            $filenameWithExt = $fileKeuangan->nama_dokumen;

            if ($request->hasFile('gambar')) {
                if ($fileKeuangan->nama_file != 'default.png') {
                    Storage::delete("public/dokumen_keuangan/" . $fileKeuangan->nama_file);
                }

                $filenameWithExt = $request->file('gambar')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('gambar')->getClientOriginalExtension();
                $foto = $filename . '_' . time() . '.' . $extension;
                $request->file('gambar')->storeAs('public/dokumen_keuangan', $foto);
            }
            $fileKeuangan->update($this->file_keuangan_data($foto, $filenameWithExt, $keuangan->keuangan_id));

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id . '/file/' . $fileKeuangan->file_keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> File Keuangan sudah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keuangan $keuangan, FileKeuangan $fileKeuangan)
    {
        if ($fileKeuangan->nama_file != 'default.png') {
            Storage::delete("public/dokumen_keuangan/" . $fileKeuangan->nama_file);
        }
        $fileKeuangan->delete();

        return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id . '/file')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> File Keuangan sudah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function file_keuangan_data($namaFile, $namaDokumen, $id)
    {
        return [
            'keuangan_id' => $id,
            'nama_dokumen' => $namaDokumen,
            'nama_file' => $namaFile,
            'tanggal_upload' => date('Y-m-d')
        ];
    }
}
