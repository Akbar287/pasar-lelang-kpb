<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Models\DetailJaminan;
use App\Models\JenisTransaksi;
use App\Models\JenisVerifikasi;
use App\Models\KeuanganCashInTrading;
use App\Models\KursMataUang;
use App\Models\RekeningPusat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VerifikasiJaminanController extends Controller
{
    public function index(Request $request)
    {
        $data = DetailJaminan::select('detail_jaminan.*')->addSelect('ktp.nama')->addSelect('detail_jaminan_verified_log.verified_log_id')->join('jaminan', 'jaminan.jaminan_id', 'detail_jaminan.jaminan_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'jaminan.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->leftJoin('detail_jaminan_verified_log', 'detail_jaminan_verified_log.detail_jaminan_id', 'detail_jaminan.detail_jaminan_id')->whereNull('detail_jaminan_verified_log.verified_log_id')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->nama;
                    return $actionBtn;
                })
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = $row->tanggal_transaksi;
                    return $actionBtn;
                })
                ->addColumn('nilai_jaminan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_jaminan, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('haircut', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_jaminan - $row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('nilai_penyesuaian', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.verifikasi.show', $row->detail_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/verifikasi/index');
    }

    public function index_ditolak(Request $request)
    {
        $data = DetailJaminan::select('detail_jaminan.*')->addSelect('ktp.nama')->addSelect('detail_jaminan_verified_log.verified_log_id')->join('jaminan', 'jaminan.jaminan_id', 'detail_jaminan.jaminan_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'jaminan.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->join('detail_jaminan_verified_log', 'detail_jaminan_verified_log.detail_jaminan_id', 'detail_jaminan.detail_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'detail_jaminan_verified_log.verified_log_id')->where('verified_log.is_agree', false)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->nama;
                    return $actionBtn;
                })
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = $row->tanggal_transaksi;
                    return $actionBtn;
                })
                ->addColumn('nilai_jaminan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_jaminan, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('haircut', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_jaminan - $row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('nilai_penyesuaian', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.verifikasi.show_ditolak', $row->detail_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/verifikasi/index_ditolak');
    }

    public function show(DetailJaminan $detailJaminan)
    {
        $verified = !is_null($detailJaminan->leftJoin('detail_jaminan_verified_log', 'detail_jaminan_verified_log.detail_jaminan_id', 'detail_jaminan.detail_jaminan_id')->first()->verified_log_id);

        return view('administrasi/jaminan/penerimaan/verifikasi/show', compact('detailJaminan', 'verified'));
    }

    public function show_ditolak(DetailJaminan $detailJaminan)
    {
        $verified = !is_null($detailJaminan->leftJoin('detail_jaminan_verified_log', 'detail_jaminan_verified_log.detail_jaminan_id', 'detail_jaminan.detail_jaminan_id')->first()->verified_log_id);

        return view('administrasi/jaminan/penerimaan/verifikasi/show_ditolak', compact('detailJaminan', 'verified'));
    }

    public function confirmation(Request $request, DetailJaminan $detailJaminan)
    {
        $request->validate([
            'confirmation' => ['required']
        ]);

        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Jaminan Penerimaan')->first();

        $detailJaminan->verified_log()->create([
            'informasi_akun_id' => $detailJaminan->jaminan()->first()->informasi_akun()->first()->informasi_akun_id,
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => $request->confirmation == 'false' ? false : true,
            'tanggal_verifikasi' => date('Y-m-d'),
            'keterangan' => $request->keterangan,
        ]);

        $total_kas = 0;
        foreach ($detailJaminan->kas()->get() as $dj) {
            $total_kas += $dj->nilai_penyesuaian;
        }

        if ($total_kas > 0) {
            $jenisTransaksi = JenisTransaksi::where('nama_jenis', 'Cash / Bank In (Trading)')->first();
            $kursMataUang = KursMataUang::where('kode_mata_uang_asal', 'IDR')->where('kode_mata_uang_tujuan', 'IDR')->first();
            $total_available = 0;
            foreach ($detailJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
                $total_available += $rb->saldo;
            }

            if ($total_available >= $total_kas) {
                $temp = $total_kas;
                foreach ($detailJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
                    if ($temp > 0) {
                        if ($rb->saldo >= $total_kas) {
                            $rb->update([
                                'saldo' => $rb->saldo - $total_kas
                            ]);

                            $temp = 0;
                        }
                        if ($rb->saldo < $total_kas) {
                            if ($temp - $rb->saldo < 0) {
                                $rb->update([
                                    'saldo' => $rb->saldo - $temp
                                ]);
                                $temp = 0;
                            } else {
                                $rb->update([
                                    'saldo' => 0
                                ]);
                                $temp = $temp - $rb->saldo;
                            }
                        }

                        // Catat di Riwayat Keuangan
                        $keuangan = $rb->keuangan()->create([
                            'rekening_bank_id' => $rb->rekening_bank_id,
                            'jenis_transaksi_id' => $jenisTransaksi->jenis_transaksi_id,
                            'kurs_mata_uang_id' => $kursMataUang->kurs_mata_uang_id,
                            'jumlah' => $total_kas,
                            'keterangan' => 'DEPOSIT JAMINAN SALDO'
                        ]);

                        $keuangan->keuangan_cash_in_trading()->create([
                            'saldo_belum_teralokasi' => 0,
                            'nomor_instruksi' => $this->generate_nomor_instruksi(),
                            'jenis_alokasi' => 'DEPOSIT JAMINAN',
                            'sisa_alokasi' => $total_kas,
                            'alokasi_collateral' => 0,
                            'alokasi_penyelesaian' => 0,
                            'alokasi_lain' => 0,
                        ]);

                        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Keuangan')->first();

                        $keuangan->verified_log()->create([
                            'informasi_akun_id' => $keuangan->rekening_bank()->first()->informasi_akun()->first()->informasi_akun_id,
                            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
                            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
                            'is_agree' => true,
                            'tanggal_verifikasi' => date('Y-m-d'),
                            'keterangan' => $request->keterangan,
                        ]);

                        // $rekeningPusat = RekeningPusat::where('aktif', true)->where('status', true)->first();
                        // $verified_log->dana_keuangan()->create([
                        //     'rekening_pusat_id' => $rekeningPusat->rekening_pusat_id,
                        //     'jumlah_dana' => $keuangan->jumlah,
                        //     'jenis' => 'debit',
                        //     'keterangan' => 'Deposit Saldo'
                        // ]);

                        // End Catat
                    }
                }
            }
        }

        if ($request->confirmation == 'true') {
            $detailJaminan->jaminan()->first()->update([
                'total_saldo_jaminan' => $detailJaminan->jaminan()->first()->total_saldo_jaminan + $detailJaminan->nilai_penyesuaian,
                'saldo_tersedia' => $detailJaminan->jaminan()->first()->saldo_tersedia + $detailJaminan->nilai_penyesuaian,
            ]);
        }

        return redirect('/administrasi/jaminan/penerimaan/verifikasi/' . $detailJaminan->detail_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Verifikasi Penerimaan Jaminan sudah di konfirmasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function confirmation_ulang(Request $request, DetailJaminan $detailJaminan)
    {
        if (!is_null(DB::table('detail_jaminan_verified_log')->where('detail_jaminan_id', $detailJaminan->detail_jaminan_id)->where('verified_log_id', $detailJaminan->verified_log()->first()->verified_log_id)->first())) {
            if ($detailJaminan->kas()->count() > 0) {
                $total_kas = 0;
                foreach ($detailJaminan->kas()->get() as $dj) {
                    $total_kas += $dj->nilai_penyesuaian;
                }

                if ($total_kas > 0) {
                    $detailJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->update([
                        'saldo' => $detailJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->saldo + $total_kas
                    ]);
                }
            }

            $detailJaminan->verified_log()->first()->delete();
        }


        return redirect('/administrasi/jaminan/penerimaan/verifikasi/' . $detailJaminan->detail_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Verifikasi Penerimaan Jaminan sudah di konfirmasi ulang.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function generate_nomor_instruksi()
    {
        $i = 1;
        $temp = 'KPB/CASH/IN/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $i;

        $cek = true;
        do {
            if (KeuanganCashInTrading::where('nomor_instruksi', $temp)->count() == 0) {
                $cek = false;
            }
            $i++;
        } while ($cek);
        return $temp;
    }
}
