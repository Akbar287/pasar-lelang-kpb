<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\JenisTransaksi;
use App\Models\JenisVerifikasi;
use App\Models\KursMataUang;
use App\Models\Lelang;
use App\Models\RekeningBank;
use App\Models\RekeningPusat;
use App\Models\StatusLelang;
use App\Models\VerifiedLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OperationalVerifikasiTransaksiLelangController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $statusSelesai = StatusLelang::where('nama_status', 'Verifikasi Transaksi')->first();
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
                    return is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-success">Online</div>' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>'));
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('operational.lelang.verifikasi.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                })
                ->rawColumns(['action', 'jenis'])
                ->make(true);
        }
        return view('operational/lelang/verifikasi/index');
    }

    public function index_ditolak(Request $request)
    {
        if ($request->ajax()) {
            $statusSelesai = StatusLelang::where('nama_status', 'Verifikasi Transaksi Ditolak')->first();
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
                    return is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-success">Online</div>' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>'));
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('operational.lelang.verifikasi.show_ditolak', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                })
                ->rawColumns(['action', 'jenis'])
                ->make(true);
        }
        return view('operational/lelang/verifikasi/index_ditolak');
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
        // dd(is_null($approval_lelang->pembayaran_lelang()->first()->verified_log()->first()), is_null($lelang->approval_lelang()->first()->pembayaran_lelang()->first()->verified_log()->first()));
        return view('operational/lelang/verifikasi/show', compact('lelang', 'verified', 'hargaDeal', 'approval_lelang', 'jatuhTempo', 'tanggal'));
    }

    public function show_ditolak(Lelang $lelang)
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

        return view('operational/lelang/verifikasi/show_ditolak', compact('lelang', 'verified', 'hargaDeal', 'approval_lelang', 'jatuhTempo', 'tanggal'));
    }

    public function confirmation(Request $request, Lelang $lelang)
    {
        $request->validate([
            'confirmation' => ['required']
        ]);

        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Transaksi Lelang')->first();

        $verifiedLog = $lelang->approval_lelang()->first()->pembayaran_lelang()->first()->verified_log()->create([
            'informasi_akun_id' => $lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id,
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => $request->confirmation == 'false' ? false : true,
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'keterangan' => $request->keterangan,
        ]);

        // Status Lelang
        if ($request->confirmation == 'false') {
            $status = StatusLelang::where('nama_status', 'Verifikasi Transaksi Ditolak')->first();
        } else {
            $status = StatusLelang::where('nama_status', 'Transaksi Selesai')->first();
            $this->send_transaction_to_seller($lelang);
        }
        foreach ($lelang->status_lelang_pivot()->get() as $na) {
            $na->update(['is_aktif' => false]);
        }
        $lelang->status_lelang_pivot()->create([
            'status_lelang_id' => $status->status_lelang_id,
            'is_aktif' => true
        ]);

        return redirect('/operational/lelang/verifikasi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Verifikasi Transaksi Lelang sudah di konfirmasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function confirmation_ulang(Request $request, Lelang $lelang)
    {
        if (!is_null(DB::table('pembayaran_lelang_verified_log')->where('pembayaran_lelang_id', $lelang->approval_lelang()->first()->pembayaran_lelang()->first()->pembayaran_lelang_id)->where('verified_log_id', $lelang->approval_lelang()->first()->pembayaran_lelang()->first()->verified_log()->first()->verified_log_id)->first())) {
            $lelang->approval_lelang()->first()->pembayaran_lelang()->first()->verified_log()->first()->delete();
        }

        // Status Lelang
        $status = StatusLelang::where('nama_status', 'Verifikasi Transaksi')->first();
        foreach ($lelang->status_lelang_pivot()->get() as $na) {
            $na->update(['is_aktif' => false]);
        }
        $lelang->status_lelang_pivot()->create([
            'status_lelang_id' => $status->status_lelang_id,
            'is_aktif' => true
        ]);

        return redirect('/operational/lelang/verifikasi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Verifikasi Transaksi Lelang sudah di konfirmasi ulang.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function send_transaction_to_seller($lelang)
    {
        // Kamus
        $rekeningPusat = RekeningPusat::where('aktif', true)->where('status', true)->first();
        $rekeningBankPenjual = $lelang->kontrak()->first()->informasi_akun()->first()->rekening_bank()->first();
        $jenisTransaksi = JenisTransaksi::where('nama_jenis', 'Cash / Bank Out (Settlement)')->first();
        $kursMataUang = KursMataUang::where('kode_mata_uang_asal', 'IDR')->where('kode_mata_uang_tujuan', 'IDR')->first();
        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Transaksi Lelang')->first();

        $admin = ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->penyelenggara_pasar_lelang()->first()->admin()->first() : $lelang->event_lelang()->first()->offline_profile()->first()->penyelenggara_pasar_lelang()->first()->admin()->first();
        $hargaDeal = $lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan;


        // Kurangi Saldo Rekening Penampung
        $rekeningPusat->update([
            'saldo' => $rekeningPusat->saldo - $hargaDeal,
        ]);


        $verified_log = VerifiedLog::create([
            'informasi_akun_id' => Auth::user()->informasi_akun_id,
            'admin_id' => $admin->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => true,
            'tanggal_verifikasi' => Carbon::now()->format('Y-m-d H:i:s'),
            'keterangan' => 'PENYELESAIAN PENGIRIMAN TRANSAKSI LELANG UUID ' . $lelang->lelang_id
        ]);

        $rekeningPusat->dana_keuangan()->create([
            'verified_log_id' => $verified_log->verified_log_id,
            'jumlah_dana' => $hargaDeal,
            'jenis' => 'kredit',
            'keterangan' => 'PEMBAYARAN ID LELANG ' . $lelang->lelang_id
        ]);

        // Cari Approval lelang
        if (!is_null($lelang->approval_lelang()->first())) {
            $approval_lelang = $lelang->approval_lelang()->first();
        } else {
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
        }

        $rekeningBankPembeli = null;

        // Get Rekening Pembeli
        $rekeningBankPembeli = $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'tujuan')->first()->rekening_bank()->first();

        // Tambah Rekening Saldo Penjual
        $rekeningBankPenjual->update([
            'saldo' => $rekeningBankPenjual->saldo + $hargaDeal
        ]);

        $keuanganPenjual = $rekeningBankPenjual->keuangan()->create([
            'jenis_transaksi_id' => $jenisTransaksi->jenis_transaksi_id,
            'kurs_mata_uang_id' => $kursMataUang->kurs_mata_uang_id,
            'jumlah' => $hargaDeal,
            'keterangan' => 'PEMBAYARAN ID LELANG ' . $lelang->lelang_id
        ]);

        $keuanganPenjual->keuangan_cash_settlement()->create([
            'rekening_bank_id' => $rekeningBankPembeli->rekening_bank_id
        ]);

        // Ubah Keuangan keluar
        $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->update([
            'status' => 'Selesai'
        ]);

        $verified_log = VerifiedLog::create([
            'informasi_akun_id' => Auth::user()->informasi_akun_id,
            'admin_id' => $admin->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => true,
            'tanggal_verifikasi' => Carbon::now()->format('Y-m-d H:i:s'),
            'keterangan' => 'PENYELESAIAN PENGIRIMAN TRANSAKSI LELANG UUID ' . $lelang->lelang_id
        ]);

        DB::table('keuangan_verified_log')->insert([
            'keuangan_id' => $keuanganPenjual->keuangan_id,
            'verified_log_id' => $verified_log->verified_log_id
        ]);
    }
}
