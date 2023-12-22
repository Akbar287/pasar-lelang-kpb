<?php

namespace App\Http\Controllers\MasterData\Lainnya;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterSesiPerdaganganRequest;
use App\Models\MasterSesiLelang;
use App\Models\PenyelenggaraPasarLelang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterSesiPerdaganganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterSesiLelang::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_penyelenggara', function ($row) {
                    return $row->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                })
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = ($row->is_aktif == 'true') ? 'Aktif' : 'Tidak Aktif';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.lain.sesi.show', $row->master_sesi_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/master_lainnya/master_sesi_perdagangan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        return view('master_data/master_lainnya/master_sesi_perdagangan/create', compact('penyelenggaraPasarLelang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterSesiPerdaganganRequest $masterSesiPerdaganganRequest)
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::find($masterSesiPerdaganganRequest->penyelenggara_pasar_lelang_id);

        $sesi = $penyelenggaraPasarLelang->master_sesi_lelang()->create($this->masterSesiPerdaganganData());

        return redirect('/master/lain/sesi/' . $sesi->master_sesi_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Master Sesi Perdagangan telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterSesiLelang $sesi)
    {
        return view('master_data/master_lainnya/master_sesi_perdagangan/show', compact('sesi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSesiLelang $sesi)
    {
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        return view('master_data/master_lainnya/master_sesi_perdagangan/edit', compact('penyelenggaraPasarLelang', 'sesi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterSesiPerdaganganRequest $masterSesiPerdaganganRequest, MasterSesiLelang $sesi)
    {
        $sesi->update($this->masterSesiPerdaganganData());

        return redirect('/master/lain/sesi/' . $sesi->master_sesi_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Master Sesi Perdagangan telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterSesiLelang $sesi)
    {
        $sesi->delete();

        return redirect('/master/lain/sesi')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Master Sesi Perdagangan telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function masterSesiPerdaganganData()
    {
        return [
            'sesi' => request('sesi'),
            'jam_mulai' => request('jam_mulai'),
            'jam_berakhir' => request('jam_berakhir'),
            'is_aktif' => request('is_aktif') == 'false' ? false : true,
        ];
    }

    public function api_master_sesi_perdagangan(Request $request)
    {
        $sesi = MasterSesiLelang::select('ktp.nama')->addSelect('master_sesi_lelang.*')->addSelect('lelang_sesi_online.is_aktif')->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'master_sesi_lelang.penyelenggara_pasar_lelang_id')->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')->join('member', 'member.member_id', 'admin.member_id')->join('ktp', 'ktp.member_id', 'member.member_id')->join('lelang_sesi_online', 'lelang_sesi_online.master_sesi_lelang_id', 'master_sesi_lelang.master_sesi_lelang_id')->orderBy('tanggal', 'desc')->where('master_sesi_lelang.is_aktif', true)->paginate(request('page'));

        return response()->json([
            'data' => $sesi,
            'message' => 'Sesi Lelang Online has been catched',
            'status' => 'success'
        ], 200);
    }
}
