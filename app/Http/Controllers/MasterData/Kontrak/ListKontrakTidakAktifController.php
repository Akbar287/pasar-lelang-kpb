<?php

namespace App\Http\Controllers\MasterData\Kontrak;

use App\Http\Controllers\Controller;
use App\Models\Kontrak;
use App\Models\StatusKontrak;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListKontrakTidakAktifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusKontrak::where('nama_status', 'Non-Aktif')->first()->kontrak()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (!is_null($row->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = $row->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('jenis_perdagangan', function ($row) {
                    $actionBtn = $row->jenis_perdagangan()->first()->nama_perdagangan;
                    return $actionBtn;
                })
                ->addColumn('username', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->userlogin()->first()->username;
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status_kontrak()->first()->nama_status;
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.kontrak.nonaktif.show', $row->kontrak_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/kontrak_pasar_lelang/kontrak_tidak_aktif/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $kontrak)
    {
        return view('master_data/kontrak_pasar_lelang/kontrak_tidak_aktif/show', compact('kontrak'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function aktif(Kontrak $kontrak)
    {
        $status = StatusKontrak::where('nama_status', 'Aktif')->first();
        $kontrak->update([
            'status_kontrak_id' => $status->status_kontrak_id,
            'is_aktif' => false
        ]);

        return redirect('/master/kontrak/non-aktif')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di Aktifkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
