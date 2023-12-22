<?php

namespace App\Http\Controllers\User\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ApprovalLelang;
use App\Models\InformasiAkun;
use App\Models\JenisTransaksi;
use App\Models\JenisVerifikasi;
use App\Models\KeuanganMasuk;
use App\Models\KomoditasMasuk;
use App\Models\KomoditasKeluar;
use App\Models\KursMataUang;
use App\Models\Lelang;
use App\Models\Rating;
use App\Models\RekeningBank;
use App\Models\RekeningPusat;
use App\Models\StatusLelang;
use App\Models\VerifiedLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LelangUserTransaksiController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    // public function index_now(Request $request)
    // {
    //     $status = StatusLelang::whereIn('nama_status', ['Transaksi Lelang', 'Verifikasi Transaksi'])->get()->toArray();

    //     $penjual = ApprovalLelang::select()
    //         ->join('lelang', 'lelang.lelang_id', 'approval_lelang.lelang_id')
    //         ->join('status_lelang_pivot', 'lelang.lelang_id', 'status_lelang_pivot.lelang_id')
    //         ->where('approval_lelang.informasi_akun_id', Auth::user()->informasi_akun_id)
    //         ->where('status_lelang_pivot.is_aktif', true)
    //         ->whereIn('status_lelang_pivot.status_lelang_id', $status)
    //         ->get();

    //     $pembeli = ApprovalLelang::select()
    //         ->join('lelang', 'lelang.lelang_id', 'approval_lelang.lelang_id')
    //         ->join('status_lelang_pivot', 'lelang.lelang_id', 'status_lelang_pivot.lelang_id')
    //         ->leftJoin('daftar_peserta_lelang_berlangsung_approval', 'daftar_peserta_lelang_berlangsung_approval.approval_lelang_id', 'approval_lelang.approval_lelang_id')
    //         ->join('daftar_peserta_lelang_berlangsung', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_berlangsung_id', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_berlangsung_id')
    //         ->where('status_lelang_pivot.is_aktif', true)
    //         ->whereIn('status_lelang_pivot.status_lelang_id', $status)
    //         ->get();

    //     return view('user/lelang/transaksi/index_now', compact('status'));
    // }
    public function index(Request $request)
    {
        $statusAll = StatusLelang::select('nama_status')->get();
        $waktuMulai = $request->has('waktu_mulai') ? Carbon::createFromFormat('Y-m-d', $request->waktu_mulai) : Carbon::now()->subDays(7);
        $waktuSelesai = $request->has('waktu_selesai') ? Carbon::createFromFormat('Y-m-d', $request->waktu_selesai) : Carbon::now();
        $platform = $request->has('platform') ? $request->platform : 'online';

        if ($waktuMulai->gt($waktuSelesai)) {
            $temp = $waktuMulai;
            $waktuMulai = $waktuSelesai;
            $waktuSelesai = $temp;
        }
        $waktuMulai = $waktuMulai->format('Y-m-d');
        $waktuSelesai = $waktuSelesai->format('Y-m-d');

        if ($request->has('status')) {
            if ($request->status == 'all') {
                $status = StatusLelang::select('status_lelang_id')->whereIn('nama_status', ['Selesai', 'Transaksi Lelang', 'Verifikasi Transaksi', 'Transaksi Selesai', 'Verifikasi Transaksi Ditolak'])->get();
            } else {
                $status = StatusLelang::select('status_lelang_id')->where('nama_status', $request->status)->get();
            }
        } else {
            $status = StatusLelang::select('status_lelang_id')->whereIn('nama_status', ['Selesai', 'Transaksi Lelang', 'Verifikasi Transaksi', 'Transaksi Selesai', 'Verifikasi Transaksi Ditolak'])->get();
        }

        if ($request->ajax()) {
            $jenis = $request->has('jenis') ? $request->jenis : 'penjual';

            if ($jenis == 'penjual') {
                if ($platform == 'online') {
                    $data = Lelang::select('lelang.kuantitas')
                        ->addSelect('lelang.lelang_id')
                        ->addSelect('lelang.nomor_lelang')
                        ->addSelect('lelang.judul')
                        ->addSelect('status_lelang.nama_status')
                        ->addSelect('lelang.harga_awal')
                        ->addSelect('lelang.kelipatan_penawaran')
                        ->addSelect('lelang.created_at')
                        ->addSelect('kontrak.kontrak_kode')
                        ->addSelect('status_lelang_pivot.status_lelang_id')
                        ->join('kontrak', 'lelang.kontrak_id', 'kontrak.kontrak_id')
                        ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                        ->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')
                        ->leftJoin('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')
                        ->where('kontrak.informasi_akun_id', Auth::user()->informasi_akun_id)
                        ->where('status_lelang_pivot.is_aktif', true)
                        ->whereNull('lelang.deleted_at')
                        ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                        ->whereBetween('lelang_sesi_online.tanggal', [$waktuMulai, $waktuSelesai])
                        ->get();
                } else {
                    $data = Lelang::select('lelang.kuantitas')
                        ->addSelect('lelang.lelang_id')
                        ->addSelect('lelang.nomor_lelang')
                        ->addSelect('lelang.judul')
                        ->addSelect('status_lelang.nama_status')
                        ->addSelect('lelang.harga_awal')
                        ->addSelect('lelang.kelipatan_penawaran')
                        ->addSelect('lelang.created_at')
                        ->addSelect('kontrak.kontrak_kode')
                        ->addSelect('status_lelang_pivot.status_lelang_id')
                        ->join('kontrak', 'lelang.kontrak_id', 'kontrak.kontrak_id')
                        ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                        ->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')
                        ->join('event_lelang_relation', 'event_lelang_relation.lelang_id', 'lelang.lelang_id')
                        ->join('event_lelang', 'event_lelang.event_lelang_id', 'event_lelang_relation.event_lelang_id')
                        ->where('kontrak.informasi_akun_id', Auth::user()->informasi_akun_id)
                        ->where('status_lelang_pivot.is_aktif', true)
                        ->whereNull('lelang.deleted_at')
                        ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                        ->whereBetween('event_lelang.tanggal_lelang', [$waktuMulai, $waktuSelesai])
                        ->get();
                }
            } else {
                if ($platform == 'online') {
                    $data = Lelang::select('lelang.kuantitas')
                        ->addSelect('lelang.lelang_id')
                        ->addSelect('lelang.nomor_lelang')
                        ->addSelect('lelang.judul')
                        ->addSelect('status_lelang.nama_status')
                        ->addSelect('lelang.harga_awal')
                        ->addSelect('lelang.kelipatan_penawaran')
                        ->addSelect('lelang.created_at')
                        ->addSelect('kontrak.kontrak_kode')
                        ->addSelect('status_lelang_pivot.status_lelang_id')
                        ->join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')
                        ->join('peserta_lelang_berlangsung_approval', 'peserta_lelang_berlangsung_approval.approval_lelang_id', 'approval_lelang.approval_lelang_id')
                        ->join('peserta_lelang_berlangsung', 'peserta_lelang_berlangsung.peserta_lelang_berlangsung_id', 'peserta_lelang_berlangsung_approval.peserta_lelang_berlangsung_id')
                        ->join('peserta_lelang', 'peserta_lelang.peserta_lelang_id', 'peserta_lelang_berlangsung.peserta_lelang_id')
                        ->join('kontrak', 'lelang.kontrak_id', 'kontrak.kontrak_id')
                        ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                        ->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')
                        ->leftJoin('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')
                        ->where('peserta_lelang.informasi_akun_id', Auth::user()->informasi_akun_id)
                        ->where('status_lelang_pivot.is_aktif', true)
                        ->whereNull('lelang.deleted_at')
                        ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                        ->whereBetween('lelang_sesi_online.tanggal', [$waktuMulai, $waktuSelesai])
                        ->get();
                } else {
                    $data = Lelang::select('lelang.kuantitas')
                        ->addSelect('lelang.lelang_id')
                        ->addSelect('lelang.nomor_lelang')
                        ->addSelect('lelang.judul')
                        ->addSelect('status_lelang.nama_status')
                        ->addSelect('lelang.harga_awal')
                        ->addSelect('lelang.kelipatan_penawaran')
                        ->addSelect('lelang.created_at')
                        ->addSelect('kontrak.kontrak_kode')
                        ->addSelect('status_lelang_pivot.status_lelang_id')
                        ->join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')
                        ->join('daftar_peserta_lelang_berlangsung_approval', 'daftar_peserta_lelang_berlangsung_approval.approval_lelang_id', 'approval_lelang.approval_lelang_id')
                        ->join('daftar_peserta_lelang_berlangsung', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_berlangsung_id', 'daftar_peserta_lelang_berlangsung_approval.daftar_peserta_lelang_berlangsung_id')
                        ->join('daftar_peserta_lelang', 'daftar_peserta_lelang.daftar_peserta_lelang_id', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id')
                        ->join('kontrak', 'lelang.kontrak_id', 'kontrak.kontrak_id')
                        ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                        ->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')
                        ->join('event_lelang_relation', 'event_lelang_relation.lelang_id', 'lelang.lelang_id')
                        ->join('event_lelang', 'event_lelang.event_lelang_id', 'event_lelang_relation.event_lelang_id')
                        ->where('daftar_peserta_lelang.informasi_akun_id', Auth::user()->informasi_akun_id)
                        ->where('status_lelang_pivot.is_aktif', true)
                        ->whereNull('lelang.deleted_at')
                        ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                        ->whereBetween('event_lelang.tanggal_lelang', [$waktuMulai, $waktuSelesai])
                        ->get();
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kuantitas', function ($row) {
                    $actionBtn = number_format($row->kuantitas, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->harga_awal, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('harga_pemenang', function ($row) {
                    return 'Rp. ' . number_format(is_null($row->approval_lelang()->first()) ? 0 : $row->approval_lelang()->first()->harga_pemenang, 0, ".", ",");
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->nama_status;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('lelang.transaksi.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('user/lelang/transaksi/index', compact('waktuMulai', 'waktuSelesai', 'status', 'statusAll'));
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
        $hargaDeal = $lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? (is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan) : (is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan);

        // Get Approval Lelang if exist
        if (is_null($lelang->jenis_platform_lelang()->first())) {
            $approvalLelang = null;
        } else if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            //Online
            $approval_lelang = is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? null : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            // Hybrid
            $approval_lelang = is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? null : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        } else {
            // Offline
            $approval_lelang = is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? null : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        }

        $rekeningBank = RekeningBank::where('informasi_akun_id', Auth::user()->informasi_akun_id)->get();

        return view('user/lelang/transaksi/show', compact('lelang', 'verified', 'hargaDeal', 'approval_lelang', 'jatuhTempo', 'tanggal', 'rekeningBank'));
    }

    public function update_komoditas_masuk(Request $request, Lelang $lelang, KomoditasMasuk $komoditasMasuk)
    {
        if (is_null(InformasiAkun::where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->member()->first()->admin()->first())) {
            // User
            if ($komoditasMasuk->status == 'Belum Selesai') {
                $komoditasMasuk->update([
                    'status' => 'Selesai'
                ]);
            }

            return redirect('/lelang/transaksi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Komoditas telah dipastikan diterima pembeli.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $request->validate([
                'status_komoditas_diterima' => ['required']
            ]);

            if ($komoditasMasuk->status != $request->status_komoditas_diterima) {
                $komoditasMasuk->update([
                    'status' => $request->status_komoditas_diterima
                ]);
            }

            return redirect('/operational/lelang/verifikasi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Status Komoditas Diterima sudah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function update_komoditas_keluar(Request $request, Lelang $lelang, KomoditasKeluar $komoditasKeluar)
    {
        if (is_null(InformasiAkun::where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->member()->first()->admin()->first())) {
            // User
            if ($komoditasKeluar->status == 'Belum Selesai') {
                $komoditasKeluar->update([
                    'status' => 'Selesai'
                ]);
            }

            return redirect('/lelang/transaksi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Komoditas telah dipastikan dikirim penjual.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $request->validate([
                'status_komoditas_dikirim' => ['required']
            ]);

            if ($komoditasKeluar->status != $request->status_komoditas_dikirim) {
                $komoditasKeluar->update([
                    'status' => $request->status_komoditas_dikirim
                ]);
            }

            return redirect('/operational/lelang/verifikasi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Status Komoditas Dikirim sudah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    public function update_keuangan_masuk(Request $request, Lelang $lelang, KeuanganMasuk $keuanganMasuk)
    {
        $request->validate([
            'rekening_bank_pembeli' => ['required']
        ]);

        $rekeningPusat = RekeningPusat::where('aktif', true)->where('status', true)->first();
        $rekeningBankPembeli = RekeningBank::where('rekening_bank_id', $request->rekening_bank_pembeli)->first();
        $rekeningBankPenjual = $lelang->kontrak()->first()->informasi_akun()->first()->rekening_bank()->first();

        if ($keuanganMasuk->status == 'Belum Selesai') {
            // Kamus
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
            $jenisTransaksi = JenisTransaksi::where('nama_jenis', 'Cash / Bank Out (Settlement)')->first();
            $kursMataUang = KursMataUang::where('kode_mata_uang_asal', 'IDR')->where('kode_mata_uang_tujuan', 'IDR')->first();
            $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Transaksi Lelang')->first();

            $admin = ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->penyelenggara_pasar_lelang()->first()->admin()->first() : $lelang->event_lelang()->first()->offline_profile()->first()->penyelenggara_pasar_lelang()->first()->admin()->first();
            // End Kamus

            if ($rekeningBankPembeli->saldo - ($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain) >= 0) {
                // Saldo Cukup

                // Kurangi Saldo Rekening Pembeli
                $rekeningBankPembeli->update([
                    'saldo' => $rekeningBankPembeli->saldo - ($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain)
                ]);

                $keuanganPembeli = $rekeningBankPembeli->keuangan()->create([
                    'jenis_transaksi_id' => $jenisTransaksi->jenis_transaksi_id,
                    'kurs_mata_uang_id' => $kursMataUang->kurs_mata_uang_id,
                    'jumlah' => ($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain),
                    'keterangan' => 'PEMBAYARAN ID LELANG ' . $lelang->lelang_id
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
                    'keuangan_id' => $keuanganPembeli->keuangan_id,
                    'verified_log_id' => $verified_log->verified_log_id
                ]);

                $keuanganPembeli->keuangan_cash_settlement()->create([
                    'rekening_bank_id' => $rekeningBankPenjual->rekening_bank_id
                ]);

                // Ubah Nomor Rekening di Rekening Keuangan Asal
                $keuanganAsal = $keuanganMasuk->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first();
                if (is_null($keuanganAsal)) {
                    $keuanganMasuk->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->create([
                        'rekening_bank_id' => $rekeningBankPembeli->rekening_bank_id,
                        'jenis_rekening' => 'asal'
                    ]);
                } else {
                    $keuanganAsal->update([
                        'rekening_bank_id' => $rekeningBankPembeli->rekening_bank_id,
                    ]);
                }

                // Ubah Status Keuangan Masuk
                $keuanganMasuk->update([
                    'status' => 'Selesai'
                ]);

                // Tambah Saldo Rekening Penampung
                $rekeningPusat->update([
                    'saldo' => $rekeningPusat->saldo + ($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain),
                ]);

                $verified_log = VerifiedLog::create([
                    'informasi_akun_id' => Auth::user()->informasi_akun_id,
                    'admin_id' => $admin->admin_id,
                    'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
                    'is_agree' => true,
                    'tanggal_verifikasi' => Carbon::now()->format('Y-m-d H:i:s'),
                    'keterangan' => 'PENYELESAIAN PEMBAYARAN TRANSAKSI LELANG UUID ' . $lelang->lelang_id
                ]);

                $rekeningPusat->dana_keuangan()->create([
                    'verified_log_id' => $verified_log->verified_log_id,
                    'jumlah_dana' => ($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain),
                    'jenis' => 'debit',
                    'keterangan' => 'PEMBAYARAN ID LELANG ' . $lelang->lelang_id
                ]);

                return redirect('/lelang/transaksi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Anda Sudah Melakukan Pembayaran.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                // Saldo Kurang
                return redirect('/lelang/transaksi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Saldo Di Rekening Bank Tidak Cukup untuk melakukan Pembayaran.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {

            return redirect('/lelang/transaksi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-primary alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Status sudah Selesai.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    public function update_rating(Request $request, Lelang $lelang)
    {
        $request->validate([
            'rating' => ['required'],
        ]);

        $rating = null;
        if (is_null($lelang->kontrak()->first()->informasi_akun()->first()->rating()->first())) {
            $rating = Rating::create([
                'informasi_akun_id' => $lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id,
                'avg_stars' => 0
            ]);
        } else {
            $rating = $lelang->kontrak()->first()->informasi_akun()->first()->rating()->first();
        }

        $ratingDetail = $rating->rating_detail()->create([
            'informasi_akun_id' => Auth::user()->informasi_akun_id,
            'lelang_id' => $lelang->lelang_id,
            'star' => $request->rating,
            'secret' => $request->has('secret')
        ]);

        $ratings = (($rating->avg_stars + $request->rating) / $rating->rating_detail()->count());
        $rating->update([
            'avg_stars' => $ratings
        ]);

        if ($request->has('rating_ulasan')) {
            $ratingDetail->rating_ulasan()->create([
                'keterangan' => $request->rating_ulasan
            ]);
        }

        return redirect('/lelang/transaksi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-primary alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Rating dan Ulasan yang kamu kirim sudah disimpan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
