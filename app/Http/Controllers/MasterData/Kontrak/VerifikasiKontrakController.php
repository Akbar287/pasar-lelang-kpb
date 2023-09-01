<?php

namespace App\Http\Controllers\MasterData\Kontrak;

use App\Http\Controllers\Controller;
use App\Models\Kontrak;
use App\Models\StatusKontrak;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VerifikasiKontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kontrak::select('kontrak.*')->join('status_kontrak', 'kontrak.status_kontrak_id', 'status_kontrak.status_kontrak_id')->where('is_status_verified', false)->where('nama_status', 'Pendaftar Baru')->get();
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
                    $actionBtn = '<a href="' . route('master.kontrak.verifikasi.show', $row->kontrak_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/kontrak_pasar_lelang/verifikasi_kontrak/index');
    }

    public function store(Request $request, Kontrak $kontrak)
    {
        $request->validate([
            'tanggal_verifikasi' => ['required'],
            'is_verified' => ['required']
        ]);

        $status = StatusKontrak::where('nama_status', 'Aktif')->first();

        $kontrak->update([
            'status_kontrak_id' => $status->status_kontrak_id,
            'tanggal_verifikasi' => $request->tanggal_verifikasi,
            'keterangan' => $request->keterangan,
            'tanggal_aktif' => $request->tanggal_aktif,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'keterangan' => $request->keterangan,
            'is_verified' => $request->is_verified,
            'is_aktif' => $request->is_aktif,
            'is_status_verified' => true,
        ]);

        return redirect('/master/kontrak/verifikasi/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di verifikasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function show(Kontrak $kontrak)
    {
        return view('master_data/kontrak_pasar_lelang/verifikasi_kontrak/show', compact('kontrak'));
    }

    public function index_riwayat(Request $request)
    {
        if ($request->ajax()) {
            $data = Kontrak::select('kontrak.*')->join('status_kontrak', 'kontrak.status_kontrak_id', 'status_kontrak.status_kontrak_id')->where('is_status_verified', false)->where('nama_status', 'Pendaftar Baru')->orWhere('nama_status', 'Aktif')->orWhere('nama_status', 'Tidak Aktif')->get();
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
                    $actionBtn = $row->is_verified ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak Lulus</div>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->tanggal_verifikasi) ? "Tidak ada Data" : $row->tanggal_verifikasi;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button href="#" disabled class="edit btn btn-success btn-sm">Detail</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('master_data/kontrak_pasar_lelang/verifikasi_kontrak/index_ditolak');
    }
}
