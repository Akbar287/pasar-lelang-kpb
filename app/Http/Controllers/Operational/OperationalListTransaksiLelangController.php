<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\StatusLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OperationalListTransaksiLelangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $statusSelesai = StatusLelang::where('nama_status', 'Transaksi Selesai')->first();
            $data = Lelang::join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->where('status_lelang_pivot.status_lelang_id', $statusSelesai->status_lelang_id)->where('status_lelang_pivot.is_aktif', true)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jatuh_tempo', function ($row) {
                    $actionBtn = new Carbon($row->created_at);
                    $actionBtn->addDays($row->kontrak()->first()->jatuh_tempo_t_plus);
                    return $actionBtn->translatedFormat('d F Y');
                })
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = new Carbon($row->created_at);
                    return $actionBtn->translatedFormat('d F Y');
                })
                ->addColumn('penjual', function ($row) {
                    if (!is_null($row->kontrak()->first()->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('pembeli', function ($row) {
                    if (is_null($row->jenis_platform_lelang()->first())) {
                        // Tidak Ada
                        return 'Tidak Ada';
                    } else if ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline) {
                        //Online
                        if (!is_null($row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) {
                            $actionBtn = $row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                        } else {
                            $actionBtn = $row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                        }
                        return $actionBtn;
                    } else if ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline) {
                        // Hybrid
                        if (!is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) {
                            $actionBtn = $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                        } else {
                            $actionBtn = $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                        }
                        return $actionBtn;
                    } else {
                        // Offline
                        if (!is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) {
                            $actionBtn = $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                        } else {
                            $actionBtn = $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                        }
                        return $actionBtn;
                    }
                })
                ->addColumn('harga', function ($row) {
                    if (is_null($row->jenis_platform_lelang()->first())) {
                        // Tidak Ada
                        return 'Tidak Ada';
                    } else if ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline) {
                        //Online
                        return 'Rp. ' . number_format($row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan, 0, ".", ",");
                    } else if ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline) {
                        // Hybrid
                        return 'Rp. ' . number_format($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan, 0, ".", ",");
                    } else {
                        // Offline
                        return 'Rp. ' . number_format($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan, 0, ".", ",");
                    }
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-success">Online</div>' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>'));
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('operational.lelang.list.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'jenis'])
                ->make(true);
        }
        return view('operational/lelang/list/index');
    }

    public function show(Lelang $lelang)
    {
        $verified = !is_null($lelang->join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->join('pembayaran_lelang', 'pembayaran_lelang.approval_lelang_id', 'approval_lelang.approval_lelang_id')->leftJoin('pembayaran_lelang_verified_log', 'pembayaran_lelang_verified_log.pembayaran_lelang_id', 'pembayaran_lelang.pembayaran_lelang_id')->first()->verified_log_id);

        // Tanggal dan Jatuh Tempo
        $tanggal = new Carbon($lelang->created_at);
        $tanggal = $tanggal->translatedFormat('d F Y');
        $jatuhTempo = new Carbon($lelang->created_at);
        $jatuhTempo = $jatuhTempo->addDays($lelang->kontrak()->first()->jatuh_tempo_t_plus);

        // Waktu Sekarang dan Cek Jatuh Tempo
        $now = Carbon::now();
        $isJatuhTempo = $jatuhTempo->isBefore($now);
        $now = $now->translatedFormat('Y-m-d H:i:s');

        // Harga Deal
        $hargaDeal = $lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan;

        // Get Approval Lelang if exist
        if (is_null($lelang->jenis_platform_lelang()->first())) {
            $approvalLelang = null;
        } else if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            //Online
            $approval_lelang = $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            // Hybrid
            $approval_lelang = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        } else {
            // Offline
            $approval_lelang = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        }

        return view('operational/lelang/list/show', compact('lelang', 'verified', 'hargaDeal', 'approval_lelang', 'jatuhTempo', 'tanggal'));
    }
}
