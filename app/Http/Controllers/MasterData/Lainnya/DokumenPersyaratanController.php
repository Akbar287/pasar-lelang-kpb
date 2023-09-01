<?php

namespace App\Http\Controllers\MasterData\Lainnya;

use App\Http\Controllers\Controller;
use App\Http\Requests\JenisDokumenRequest;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DokumenPersyaratanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JenisDokumen::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.lain.dokumen_persyaratan.show', $row->jenis_dokumen_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/master_lainnya/dokumen_persyaratan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master_data/master_lainnya/dokumen_persyaratan/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisDokumenRequest $jenisDokumenRequest)
    {
        $jenisDokumen = new JenisDokumen();
        $jenisDokumen->nama_jenis = $jenisDokumenRequest->nama_jenis;
        $jenisDokumen->keterangan = $jenisDokumenRequest->keterangan;
        $jenisDokumen->save();

        return redirect('/master/lain/dokumen_persyaratan/' . $jenisDokumen->jenis_dokumen_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Jenis Dokumen telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisDokumen $jenisDokumen)
    {
        return view('master_data/master_lainnya/dokumen_persyaratan/show', compact('jenisDokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisDokumen $jenisDokumen)
    {
        return view('master_data/master_lainnya/dokumen_persyaratan/edit', compact('jenisDokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisDokumenRequest $jenisDokumenRequest, JenisDokumen $jenisDokumen)
    {
        $jenisDokumen->update($this->dokumenPersyaratanData());

        return redirect('/master/lain/dokumen_persyaratan/' . $jenisDokumen->jenis_dokumen_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Jenis Dokumen telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisDokumen $jenisDokumen)
    {
        $jenisDokumen->delete();

        return redirect('/master/lain/dokumen_persyaratan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Jenis Dokumen telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function dokumenPersyaratanData()
    {
        return [
            'nama_jenis' => request('nama_jenis'),
            'keterangan' => request('keterangan')
        ];
    }
}
