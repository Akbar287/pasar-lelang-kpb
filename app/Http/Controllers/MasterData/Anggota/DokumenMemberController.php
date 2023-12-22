<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\DokumenMember;
use App\Models\InformasiAkun;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Yajra\DataTables\DataTables;

class DokumenMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, InformasiAkun $anggota)
    {
        if ($request->ajax()) {
            $data = $anggota->dokumen_member()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_dokumen', function ($row) {
                    $actionBtn = $row->jenis_dokumen()->first()->nama_jenis;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.list.dokumen.show', [$row->informasi_akun()->first()->informasi_akun_id, $row->dokumen_member_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/dokumen_member/index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(InformasiAkun $anggota)
    {
        $dokumens = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/dokumen_member/create', compact('anggota', 'dokumens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, InformasiAkun $anggota)
    {
        $request->validate([
            'jenis_dokumen_id' => ['required'],
            'file_member' => ['required', File::image()]
        ]);

        $foto = '';
        if ($request->hasFile('file_member')) {
            $filenameWithExt = $request->file('file_member')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file_member')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $request->file('file_member')->storeAs('public/dokumen_member', $foto);
        }

        $versi = DokumenMember::where('jenis_dokumen_id', $request->jenis_dokumen_id)->where('informasi_akun_id', $anggota->informasi_akun_id)->count();

        $dokumen = $anggota->dokumen_member()->create([
            'jenis_dokumen_id' => $request->jenis_dokumen_id,
            'versi_unggah' => $versi + 1,
            'tanggal_unggah' => date('Y-m-d'),
            'nama_dokumen' => $foto,
            'nama_file' => $foto,
        ]);

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/dokumen/' . $dokumen->dokumen_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Dokumen Anggota telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiAkun $anggota, DokumenMember $dokumen)
    {
        return view('master_data/anggota_pasar_lelang/dokumen_member/show', compact('anggota', 'dokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiAkun $anggota, DokumenMember $dokumen)
    {
        $dokumens = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/dokumen_member/edit', compact('anggota', 'dokumen', 'dokumens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiAkun $anggota, DokumenMember $dokumen)
    {
        $request->validate([
            'jenis_dokumen_id' => ['required'],
            'file_member' => ['required', File::image()]
        ]);

        $foto = '';
        if ($request->hasFile('file_member')) {
            if ($dokumen->nama_file != 'default.png') {
                Storage::delete("public/dokumen_member/" . $dokumen->nama_file);
            }
            $filenameWithExt = $request->file('file_member')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file_member')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $request->file('file_member')->storeAs('public/dokumen_member', $foto);
        }

        $versi = DokumenMember::where('jenis_dokumen_id', $request->jenis_dokumen_id)->where('informasi_akun_id', $anggota->informasi_akun_id)->count();

        $dokumen->update([
            'jenis_dokumen_id' => $request->jenis_dokumen_id,
            'versi_unggah' => $versi + 1,
            'tanggal_unggah' => date('Y-m-d'),
            'nama_dokumen' => $foto,
            'nama_file' => $foto,
        ]);

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/dokumen/' . $dokumen->dokumen_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Dokumen Anggota telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function destroy(InformasiAkun $anggota, DokumenMember $dokumen)
    {
        if ($dokumen->nama_file != 'default.png') {
            Storage::delete("public/dokumen_member/" . $dokumen->nama_file);
        }
        $dokumen->delete();

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/dokumen')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Dokumen Anggota telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function api_dokumen()
    {
        $jenisDokumen = JenisDokumen::get();

        return response()->json([
            'data' => $jenisDokumen,
            'message' => 'jenis dokumen has been catched',
            'status' => 'success'
        ], 200);
    }
}
