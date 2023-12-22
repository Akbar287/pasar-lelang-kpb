<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use App\Models\DokumenMember;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Yajra\DataTables\DataTables;

class DokumenProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Auth::user()->informasi_akun()->first()->dokumen_member()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_dokumen', function ($row) {
                    return $row->jenis_dokumen()->first()->nama_jenis;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('home.profil.dokumen.show', $row->dokumen_member_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('auth/dokumen/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisDokumen = JenisDokumen::select('jenis_dokumen_id')->addSelect('nama_jenis')->get();
        return view('auth/dokumen/create', compact('jenisDokumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_dokumen_id' => ['required'],
            'file_member' => ['required', File::image()]
        ]);

        if (is_null(Auth::user()->informasi_akun()->first()->dokumen_member()->where('jenis_dokumen_id', $request->jenis_dokumen_id)->first())) {
            $foto = '';
            if ($request->hasFile('file_member')) {
                $filenameWithExt = $request->file('file_member')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file_member')->getClientOriginalExtension();
                $foto = $filename . '_' . time() . '.' . $extension;
                $request->file('file_member')->storeAs('public/dokumen_member', $foto);
            }

            $versi = DokumenMember::where('jenis_dokumen_id', $request->jenis_dokumen_id)->where('informasi_akun_id', Auth::user()->informasi_akun_id)->count();

            $dokumenMember = Auth::user()->informasi_akun()->first()->dokumen_member()->create($this->dokumenMemberData($foto, $foto, $versi + 1));

            return redirect('/profil/dokumen/' . $dokumenMember->dokumen_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Dokumen Profil telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $dokumenMember = Auth::user()->informasi_akun()->first()->dokumen_member()->where('jenis_dokumen_id', $request->jenis_dokumen_id)->first();
            return $this->update($request, $dokumenMember);
            exit;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DokumenMember $dokumenMember)
    {
        return view('auth/dokumen/show', compact('dokumenMember'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumenMember $dokumenMember)
    {
        $jenisDokumen = JenisDokumen::select('jenis_dokumen_id')->addSelect('nama_jenis')->get();
        return view('auth/dokumen/edit', compact('dokumenMember', 'jenisDokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenMember $dokumenMember)
    {
        $request->validate([
            'jenis_dokumen_id' => ['required'],
            'file_member' => ['required', File::image()]
        ]);

        $foto = '';
        if ($request->hasFile('file_member')) {
            if ($dokumenMember->nama_file != 'default.png') {
                Storage::delete("public/dokumen_member/" . $dokumenMember->nama_file);
            }
            $filenameWithExt = $request->file('file_member')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file_member')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $request->file('file_member')->storeAs('public/dokumen_member', $foto);
        }

        $versi = DokumenMember::where('jenis_dokumen_id', $request->jenis_dokumen_id)->where('informasi_akun_id', Auth::user()->informasi_akun_id)->count();

        $dokumenMember->update($this->dokumenMemberData($foto, $foto, $versi + 1));

        return redirect('/profil/dokumen/' . $dokumenMember->dokumen_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Dokumen Profil telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenMember $dokumenMember)
    {
        if ($dokumenMember->nama_file != 'default.png') {
            Storage::delete("public/dokumen_member/" . $dokumenMember->nama_file);
        }
        $dokumenMember->delete();

        return redirect('/profil/dokumen')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Dokumen Profil telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function dokumenMemberData($namaFile, $namaDokumen, $versi)
    {
        return [
            'tanggal_unggah' => date('Y-m-d'),
            'jenis_dokumen_id' => request('jenis_dokumen_id'),
            'versi_unggah' => $versi,
            'nama_dokumen' => $namaDokumen,
            'nama_file' => $namaFile,
        ];
    }
}
