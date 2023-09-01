<?php

namespace App\Http\Controllers\Administrasi\KasBank;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListKasBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Keuangan::select('keuangan.*')->addSelect('keuangan_verified_log.verified_log_id')->join('keuangan_verified_log', 'keuangan_verified_log.keuangan_id', 'keuangan.keuangan_id')->join('verified_log', 'verified_log.verified_log_id', 'keuangan_verified_log.verified_log_id')->where('verified_log.is_agree', true)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_transaksi', function ($row) {
                    $actionBtn = $row->jenis_transaksi()->first()->nama_jenis;
                    return $actionBtn;
                })
                ->addColumn('nomor_instruksi', function ($row) {
                    $actionBtn = $row->nomor_instruksi;
                    return $actionBtn;
                })
                ->addColumn('saldo', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->saldo_belum_teralokasi, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('jumlah', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->jumlah, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('kurs_mata_uang', function ($row) {
                    $actionBtn = $row->kurs_mata_uang()->first()->mata_uang_asal . ' - ' . $row->kurs_mata_uang()->first()->mata_uang_tujuan;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.kas_bank.list.show', $row->keuangan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/list/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keuangan $keuangan)
    {
        return view('administrasi/kas_bank/list/show', compact('keuangan'));
    }
}
