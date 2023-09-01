<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\AreaMember;
use App\Models\Desa;
use App\Models\InformasiAkun;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AreaMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, InformasiAkun $anggota)
    {
        $data = $anggota->area_member()->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi', function ($row) {
                    return $row->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi;
                })
                ->addColumn('kabupaten', function ($row) {
                    return $row->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten;
                })
                ->addColumn('kecamatan', function ($row) {
                    return $row->desa()->first()->kecamatan()->first()->nama_kecamatan;
                })
                ->addColumn('desa', function ($row) {
                    return $row->desa()->first()->nama_desa;
                })
                ->addColumn('alamat', function ($row) {
                    return $row->alamat;
                })
                ->addColumn('kode_pos', function ($row) {
                    return $row->kode_pos;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.list.area.show', [$row->informasi_akun()->first()->informasi_akun_id, $row->area_member_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/area_member/index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(InformasiAkun $anggota)
    {
        $provinsi = Provinsi::get();
        return view('master_data/anggota_pasar_lelang/area_member/create', compact('anggota', 'provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InformasiAkun $anggota, Request $request)
    {
        $request->validate([
            'desa' => ['required'],
            'kode_pos' => ['required'],
            'alamat' => ['required']
        ]);

        $int = $anggota->area_member()->count();
        $area = $anggota->area_member()->create([
            'desa_id' => $request->desa,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
            'alamat_ke' => $int
        ]);


        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/area/' . $area->area_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Alamat telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiAkun $anggota, AreaMember $area)
    {
        return view('master_data/anggota_pasar_lelang/area_member/show', compact('anggota', 'area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiAkun $anggota, AreaMember $area)
    {
        $provinsi = Provinsi::get();
        $kabupaten = Kabupaten::where('provinsi_id', $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->provinsi_id)->get();
        $kecamatan = Kecamatan::where('kabupaten_id', $area->desa()->first()->kecamatan()->first()->kabupaten()->first()->kabupaten_id)->get();
        $desa = Desa::where('kecamatan_id', $area->desa()->first()->kecamatan()->first()->kecamatan_id)->get();
        return view('master_data/anggota_pasar_lelang/area_member/edit', compact('anggota', 'area', 'provinsi', 'kabupaten', 'kecamatan', 'desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InformasiAkun $anggota, Request $request, AreaMember $area)
    {
        $request->validate([
            'desa' => ['required'],
            'kode_pos' => ['required'],
            'alamat' => ['required']
        ]);

        $area->update([
            'desa_id' => $request->desa,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
        ]);

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/area/' . $area->area_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Alamat telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformasiAkun $anggota, AreaMember $area)
    {
        $area->delete();

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/area')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Alamat telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
