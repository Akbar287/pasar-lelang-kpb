<?php

namespace App\Http\Controllers\MasterData\Lembaga;

use App\Http\Controllers\Controller;
use App\Http\Requests\GudangRequest;
use App\Http\Requests\GudangRequestUpdate;
use App\Models\Gudang;
use App\Models\PenyelenggaraPasarLelang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterDataGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gudang::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penyelenggara_pasar_lelang', function ($row) {
                    $actionBtn = $row->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.lembaga.gudang.show', $row->gudang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/lembaga_pendukung/gudang/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        return view('master_data/lembaga_pendukung/gudang/create', compact('penyelenggaraPasarLelang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GudangRequest $gudangRequest)
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::where('penyelenggara_pasar_lelang_id', $gudangRequest->penyelenggara_pasar_lelang_id)->first();

        $gudang = $penyelenggaraPasarLelang->gudang()->create($this->master_data_gudang(request('gudang_kode')));

        return redirect('/master/lembaga/gudang/' . $gudang->gudang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Gudang telah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gudang $gudang)
    {
        return view('master_data/lembaga_pendukung/gudang/show', compact('gudang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gudang $gudang)
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        return view('master_data/lembaga_pendukung/gudang/edit', compact('gudang', 'penyelenggaraPasarLelang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GudangRequestUpdate $gudangRequest, Gudang $gudang)
    {
        $gudang->update($this->master_data_gudang($gudang->gudang_kode));

        return redirect('/master/lembaga/gudang/' . $gudang->gudang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Gudang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gudang $gudang)
    {
        $gudang->delete();

        return redirect('/master/lembaga/gudang')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Gudang telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function master_data_gudang($gudang)
    {
        return [
            'gudang_kode' => $gudang,
            'nama_gudang' => request('nama_gudang'),
            'contact_person' => request('contact_person'),
            'contact_number' => request('contact_number'),
            'nama_pengelola' => request('nama_pengelola'),
            'alamat' => request('alamat'),
            'keterangan' => request('keterangan'),
        ];
    }
}
