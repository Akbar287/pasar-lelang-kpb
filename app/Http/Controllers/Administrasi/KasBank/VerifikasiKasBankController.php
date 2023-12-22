<?php

namespace App\Http\Controllers\Administrasi\KasBank;

use App\Http\Controllers\Controller;
use App\Models\JenisVerifikasi;
use App\Models\Keuangan;
use App\Models\RekeningPusat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VerifikasiKasBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Keuangan::select('keuangan.*')->addSelect('keuangan_verified_log.verified_log_id')->leftJoin('keuangan_verified_log', 'keuangan_verified_log.keuangan_id', 'keuangan.keuangan_id')->whereNull('keuangan_verified_log.verified_log_id')->get();
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
                    $actionBtn = '<a href="' . route('administrasi.kas_bank.verifikasi.show', $row->keuangan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/verifikasi/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keuangan $keuangan)
    {
        $verified = !is_null($keuangan->leftJoin('keuangan_verified_log', 'keuangan_verified_log.keuangan_id', 'keuangan.keuangan_id')->first()->verified_log_id);

        return view('administrasi/kas_bank/verifikasi/show', compact('keuangan', 'verified'));
    }

    public function index_ditolak(Request $request)
    {
        if ($request->ajax()) {
            $data = Keuangan::select('keuangan.*')->addSelect('keuangan_verified_log.verified_log_id')->join('keuangan_verified_log', 'keuangan_verified_log.keuangan_id', 'keuangan.keuangan_id')->join('verified_log', 'verified_log.verified_log_id', 'keuangan_verified_log.verified_log_id')->where('verified_log.is_agree', false)->get();
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
                    $actionBtn = '<a href="' . route('administrasi.kas_bank.verifikasi.show_ditolak', $row->keuangan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/verifikasi/index_ditolak');
    }

    /**
     * Display the specified resource.
     */
    public function show_ditolak(Keuangan $keuangan)
    {
        $verified = !is_null($keuangan->leftJoin('keuangan_verified_log', 'keuangan_verified_log.keuangan_id', 'keuangan.keuangan_id')->first()->verified_log_id);

        return view('administrasi/kas_bank/verifikasi/show_ditolak', compact('keuangan', 'verified'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function confirmation(Request $request, Keuangan $keuangan)
    {
        $request->validate([
            'confirmation' => ['required']
        ]);

        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Keuangan')->first();

        $verified_log = $keuangan->verified_log()->create([
            'informasi_akun_id' => $keuangan->rekening_bank()->first()->informasi_akun()->first()->informasi_akun_id,
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => $request->confirmation == 'false' ? false : true,
            'tanggal_verifikasi' => date('Y-m-d'),
            'keterangan' => $request->keterangan,
        ]);

        $rekeningPusat = RekeningPusat::where('aktif', true)->where('status', true)->first();

        // Cash Bank In
        if (!is_null($keuangan->keuangan_cash_in_trading()->first()) && $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank In (Trading)') {
            $verified_log->dana_keuangan()->create([
                'rekening_pusat_id' => $rekeningPusat->rekening_pusat_id,
                'jumlah_dana' => $keuangan->jumlah,
                'jenis' => 'debit',
                'keterangan' => 'Deposit Jaminan'
            ]);

            if ($request->confirmation == 'true') {
                $keuangan->rekening_bank()->first()->update([
                    'saldo' => $keuangan->rekening_bank()->first()->saldo + $keuangan->keuangan_cash_in_trading()->first()->saldo_belum_teralokasi
                ]);

                $rekeningPusat->update([
                    'saldo' => $rekeningPusat->saldo + $keuangan->jumlah
                ]);

                $keuangan->rekening_bank()->first()->informasi_akun()->first()->jaminan()->first()->update([
                    'total_saldo_jaminan' => $keuangan->rekening_bank()->first()->informasi_akun()->first()->jaminan()->first()->total_saldo_jaminan + $keuangan->keuangan_cash_in_trading()->first()->sisa_alokasi,
                    'saldo_tersedia' => $keuangan->rekening_bank()->first()->informasi_akun()->first()->jaminan()->first()->saldo_tersedia + $keuangan->keuangan_cash_in_trading()->first()->sisa_alokasi
                ]);
            }
        }

        if (!is_null($keuangan->keuangan_cash_non_trading()->first()) && $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank In (Non-Trading)') {

            $verified_log->dana_keuangan()->create([
                'rekening_pusat_id' => $rekeningPusat->rekening_pusat_id,
                'jumlah_dana' => $keuangan->jumlah,
                'jenis' => 'debit',
                'keterangan' => 'Deposit Saldo'
            ]);

            if ($request->confirmation == 'true') {
                $keuangan->rekening_bank()->first()->update([
                    'saldo' => $keuangan->rekening_bank()->first()->saldo + $keuangan->jumlah
                ]);
                $rekeningPusat->update([
                    'saldo' => $rekeningPusat->saldo + $keuangan->jumlah
                ]);
            }
        }

        // Cash Bank Out
        if ($keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Pembayaran Fee)') {

            $verified_log->dana_keuangan()->create([
                'rekening_pusat_id' => $rekeningPusat->rekening_pusat_id,
                'jumlah_dana' => $keuangan->jumlah,
                'jenis' => 'kredit',
                'keterangan' => 'Withdraw Saldo'
            ]);

            if ($request->confirmation == 'true') {
                $keuangan->rekening_bank()->first()->update([
                    'saldo' => $keuangan->rekening_bank()->first()->saldo - $keuangan->jumlah
                ]);
                $rekeningPusat->update([
                    'saldo' => $rekeningPusat->saldo - $keuangan->jumlah
                ]);
            }
        }
        if (!is_null($keuangan->keuangan_cash_settlement()->first()) && $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Settlement)') {


            $verified_log->dana_keuangan()->create([
                'rekening_pusat_id' => $rekeningPusat->rekening_pusat_id,
                'jumlah_dana' => $keuangan->jumlah,
                'jenis' => 'kredit',
                'keterangan' => 'Withdraw Jaminan After Lelang'
            ]);

            if ($request->confirmation == 'true') {
                $keuangan->rekening_bank()->first()->update([
                    'saldo' => $keuangan->rekening_bank()->first()->saldo + $keuangan->jumlah
                ]);
                $rekeningPusat->update([
                    'saldo' => $rekeningPusat->saldo - $keuangan->jumlah
                ]);
                $keuangan->keuangan_cash_settlement()->first()->rekening_bank()->first()->update([
                    'saldo' => $keuangan->keuangan_cash_settlement()->first()->rekening_bank()->first()->saldo - $keuangan->jumlah
                ]);
                // $keuangan->rekening_bank()->first()->update([
                //     'saldo' => $keuangan->rekening_bank()->first()->saldo - $keuangan->jumlah
                // ]);
            }
        }
        if (!is_null($keuangan->keuangan_cash_pengembalian_collateral()->first()) && $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Pengembalian Collateral)') {
            $verified_log->dana_keuangan()->create([
                'rekening_pusat_id' => $rekeningPusat->rekening_pusat_id,
                'jumlah_dana' => $keuangan->jumlah,
                'jenis' => 'kredit',
                'keterangan' => 'Withdraw Jaminan'
            ]);

            if ($request->confirmation == 'true') {
                $keuangan->rekening_bank()->first()->update([
                    'saldo' => $keuangan->rekening_bank()->first()->saldo + $keuangan->jumlah
                ]);

                $keuangan->keuangan_cash_pengembalian_collateral()->first()->rekening_bank()->first()->update([
                    'saldo' => $keuangan->keuangan_cash_pengembalian_collateral()->first()->rekening_bank()->first()->saldo - $keuangan->jumlah
                ]);

                $rekeningPusat->update([
                    'saldo' => $rekeningPusat->saldo - $keuangan->jumlah
                ]);
            }
        }

        return redirect('/administrasi/kas_bank/verifikasi/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan sudah di konfirmasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function confirmation_ulang(Request $request, Keuangan $keuangan)
    {
        if (!is_null(DB::table('keuangan_verified_log')->where('keuangan_id', $keuangan->keuangan_id)->where('verified_log_id', $keuangan->verified_log()->first()->verified_log_id)->first())) {

            // if (!is_null($keuangan->verified_log()->first()->dana_keuangan()->first())) {
            //     $dana = $keuangan->verified_log()->first()->dana_keuangan()->first();

            // if ($dana->jenis == 'debit') {
            //     $keuangan->verified_log()->first()->dana_keuangan()->first()->rekening_pusat()->first()->update([
            //         'saldo' => $keuangan->verified_log()->first()->dana_keuangan()->first()->rekening_pusat()->first()->saldo - $dana->jumlah_dana
            //     ]);
            // } else {
            //     $keuangan->verified_log()->first()->dana_keuangan()->first()->rekening_pusat()->first()->update([
            //         'saldo' => $keuangan->verified_log()->first()->dana_keuangan()->first()->rekening_pusat()->first()->saldo + $dana->jumlah_dana
            //     ]);
            // }
            // }

            $keuangan->verified_log()->first()->delete();
        }


        return redirect('/administrasi/kas_bank/verifikasi/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan sudah di konfirmasi ulang.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
