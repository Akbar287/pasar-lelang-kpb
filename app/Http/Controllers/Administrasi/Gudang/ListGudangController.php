<?php

namespace App\Http\Controllers\Administrasi\Gudang;

use App\Http\Controllers\Controller;
use App\Models\RegistrasiKomoditas;
use App\Models\StatusRegistrasiKomoditas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusRegistrasiKomoditas::where('nama_status', 'Verifikasi')->orWhere('nama_status', 'Selesai')->first()->registrasi_komoditas()->get();
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
                    $actionBtn = '<a href="' . route('administrasi.gudang.list.show', $row->registrasi_komoditas_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/gudang/list/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RegistrasiKomoditas $registrasi)
    {
        return view('administrasi/gudang/list/show', compact('registrasi'));
    }
}
