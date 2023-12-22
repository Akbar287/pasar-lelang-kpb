<?php

namespace App\Http\Controllers\Administrasi\Gudang;

use App\Http\Controllers\Controller;
use App\Models\JenisVerifikasi;
use App\Models\RegistrasiKomoditas;
use App\Models\StatusRegistrasiKomoditas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class VerifikasiGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusRegistrasiKomoditas::where('nama_status', 'Baru')->first()->registrasi_komoditas()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_registrasi', function ($row) {
                    $actionBtn = $row->jenis_registrasi_komoditas()->first()->nama_jenis;
                    return $actionBtn;
                })
                ->addColumn('transaksi_id', function ($row) {
                    $actionBtn = $row->kode_transaksi;
                    return $actionBtn;
                })
                ->addColumn('komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('anggota', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('gudang', function ($row) {
                    $actionBtn = $row->gudang()->first()->nama_gudang;
                    return $actionBtn;
                })
                ->addColumn('nilai', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = $row->tanggal;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.gudang.verifikasi.show', $row->registrasi_komoditas_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/gudang/verifikasi/index');
    }

    public function show(RegistrasiKomoditas $registrasi)
    {
        return view('administrasi/gudang/verifikasi/show', compact('registrasi'));
    }
    public function index_ditolak(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusRegistrasiKomoditas::where('nama_status', 'Tolak')->first()->registrasi_komoditas()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_registrasi', function ($row) {
                    $actionBtn = $row->jenis_registrasi_komoditas()->first()->nama_jenis;
                    return $actionBtn;
                })
                ->addColumn('transaksi_id', function ($row) {
                    $actionBtn = $row->kode_transaksi;
                    return $actionBtn;
                })
                ->addColumn('komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('anggota', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('gudang', function ($row) {
                    $actionBtn = $row->gudang()->first()->nama_gudang;
                    return $actionBtn;
                })
                ->addColumn('nilai', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = $row->tanggal;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.gudang.verifikasi.show_ditolak', $row->registrasi_komoditas_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/gudang/verifikasi/index_ditolak');
    }

    /**
     * Display the specified resource.
     */
    public function show_ditolak(RegistrasiKomoditas $registrasi)
    {
        return view('administrasi/gudang/verifikasi/show_ditolak', compact('registrasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function confirmation(Request $request, RegistrasiKomoditas $registrasi)
    {
        $request->validate([
            'confirmation' => ['required']
        ]);

        if ($request->confirmation == 'false') {
            $statusRegistrasiKomoditas = StatusRegistrasiKomoditas::where('nama_status', 'Tolak')->first();
        } else {
            $statusRegistrasiKomoditas = StatusRegistrasiKomoditas::where('nama_status', 'Verifikasi')->first();
        }
        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Gudang')->first();

        $registrasi->verified_log()->create([
            'informasi_akun_id' => $registrasi->informasi_akun()->first()->informasi_akun_id,
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => $request->confirmation == 'false' ? false : true,
            'tanggal_verifikasi' => date('Y-m-d'),
            'keterangan' => $request->keterangan,
        ]);

        $registrasi->update([
            'status_registrasi_komoditas_id' => $statusRegistrasiKomoditas->status_registrasi_komoditas_id
        ]);

        return redirect('/administrasi/gudang/verifikasi/' . $registrasi->registrasi_komoditas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan sudah di konfirmasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function confirmation_ulang(Request $request, RegistrasiKomoditas $registrasi)
    {
        $statusRegistrasiKomoditas = StatusRegistrasiKomoditas::where('nama_status', 'Baru')->first();

        $registrasi->verified_log()->delete();

        $registrasi->update([
            'status_registrasi_komoditas_id' => $statusRegistrasiKomoditas->status_registrasi_komoditas_id
        ]);

        return redirect('/administrasi/gudang/verifikasi/' . $registrasi->registrasi_komoditas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan sudah di konfirmasi ulang.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
