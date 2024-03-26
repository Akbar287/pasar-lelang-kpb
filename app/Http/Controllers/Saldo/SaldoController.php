<?php

namespace App\Http\Controllers\Saldo;

use App\Http\Controllers\Controller;
use App\Models\Jaminan;
use App\Models\JenisPengeluaranJaminan;
use App\Models\JenisTransaksi;
use App\Models\Keuangan;
use App\Models\KursMataUang;
use App\Models\PengeluaranJaminan;
use App\Models\RekeningBank;
use App\Models\RekeningPusat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SaldoController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function saldo(Request $request)
    {
        $saldo = 0;
        foreach (Auth::user()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
            $saldo += $rb->saldo;
        }
        return view('saldo/saldo', compact('saldo'));
    }
    public function rincian(Request $request)
    {
        return view('saldo/rincian/rincian');
    }
    public function keuangan_detail(Request $request, Keuangan $keuangan)
    {
        $saldo = 0;
        foreach (Auth::user()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
            $saldo += $rb->saldo;
        }
        return view('saldo/rincian/keuangan_detail', compact('keuangan', 'saldo'));
    }
    public function deposit(Request $request)
    {
        $saldo = 0;
        foreach (Auth::user()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
            $saldo += $rb->saldo;
        }
        $rekeningPusat = RekeningPusat::where('status', true)->where('aktif', true)->get();
        return view('saldo/rincian/deposit', compact('saldo', 'rekeningPusat'));
    }
    public function deposit_store(Request $request)
    {
        $request->validate([
            'nomor_rekening' => ['required'],
            'jumlah' => ['required']
        ]);

        $jenisTransaksi = JenisTransaksi::where('nama_jenis', 'Cash / Bank In (Non-Trading)')->first();
        $kursMataUang = KursMataUang::where('kode_mata_uang_asal', 'IDR')->where('kode_mata_uang_tujuan', 'IDR')->first();

        $rekeningBank = RekeningBank::where('rekening_bank_id', $request->nomor_rekening)->first();
        $keuangan = Keuangan::create([
            'rekening_bank_id' => $rekeningBank->rekening_bank_id,
            'jenis_transaksi_id' => $jenisTransaksi->jenis_transaksi_id,
            'kurs_mata_uang_id' => $kursMataUang->kurs_mata_uang_id,
            'jumlah' => str_replace(',', '', $request->jumlah),
            'keterangan' => $request->keterangan
        ]);

        $keuangan->keuangan_cash_non_trading()->create([
            'saldo_belum_teralokasi' => 0
        ]);

        $foto = 'default.png';
        $filenameWithExt = '';

        if ($request->hasFile('gambar')) {
            $filenameWithExt = $request->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $foto = $filename . '_' . time() . '.' . $extension;
            $request->file('gambar')->storeAs('public/dokumen_keuangan', $foto);
        }

        $keuangan->file_keuangan()->create([
            'nama_file' => $foto,
            'nama_dokumen' => $filenameWithExt,
            'tanggal_upload' => date('Y-m-d')
        ]);

        return redirect('/home/saldo/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Deposit anda sedang diproses.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
    public function withdraw(Request $request)
    {
        $saldo = 0;
        foreach (Auth::user()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
            $saldo += $rb->saldo;
        }
        return view('saldo/rincian/withdraw', compact('saldo'));
    }
    public function withdraw_store(Request $request)
    {
        $request->validate([
            'nomor_rekening' => ['required'],
            'jumlah' => ['required']
        ]);


        $jenisTransaksi = JenisTransaksi::where('nama_jenis', 'Cash / Bank Out (Pembayaran Fee)')->first();
        $kursMataUang = KursMataUang::where('kode_mata_uang_asal', 'IDR')->where('kode_mata_uang_tujuan', 'IDR')->first();

        $rekeningBank = RekeningBank::where('rekening_bank_id', $request->nomor_rekening)->first();

        if (intval(explode('.', $rekeningBank->saldo)[0]) > 0 && intval(str_replace(',', '.', $request->jumlah)) <= intval(explode('.', $rekeningBank->saldo)[0])) {
            $keuangan = Keuangan::create([
                'rekening_bank_id' => $rekeningBank->rekening_bank_id,
                'jenis_transaksi_id' => $jenisTransaksi->jenis_transaksi_id,
                'kurs_mata_uang_id' => $kursMataUang->kurs_mata_uang_id,
                'jumlah' => str_replace(',', '', $request->jumlah),
                'keterangan' => $request->keterangan
            ]);
        } else {
            return redirect('/home/saldo/withdraw')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Dana yang dimasukan melebihi saldo yang anda miliki.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }

        return redirect('/home/saldo/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Withdraw anda sedang diproses.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
    public function jaminan(Request $request)
    {
        return view('saldo/jaminan/jaminan');
    }
    public function jaminan_deposit(Request $request)
    {
        $saldo = 0;
        foreach (Auth::user()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
            $saldo += $rb->saldo;
        }
        return view('saldo/jaminan/deposit', compact('saldo'));
    }
    public function jaminan_withdraw(Request $request)
    {
        $saldo = 0;
        foreach (Auth::user()->informasi_akun()->first()->rekening_bank()->get() as $rb) {
            $saldo += $rb->saldo;
        }
        return view('saldo/jaminan/withdraw', compact('saldo'));
    }
    public function riwayat(Request $request)
    {
        if ($request->ajax()) {
            $data = Auth::user()->informasi_akun()->first()->rekening_bank()->join('keuangan', 'keuangan.rekening_bank_id', 'rekening_bank.rekening_bank_id')->join('jenis_transaksi', 'jenis_transaksi.jenis_transaksi_id', 'keuangan.jenis_transaksi_id')->join('bank', 'bank.bank_id', 'rekening_bank.bank_id')->orderBy('rekening_bank.created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = $row->created_at->format('d F Y');
                    return $actionBtn;
                })
                ->addColumn('rekening_bank', function ($row) {
                    $actionBtn = $row->nama_bank . ' (' . $row->nomor_rekening . ')';
                    return $actionBtn;
                })
                ->addColumn('jenis_transaksi', function ($row) {
                    $actionBtn = $row->nama_jenis;
                    return $actionBtn;
                })
                ->addColumn('jumlah', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->jumlah, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = ($row->keuangan()->where('keuangan_id', $row->keuangan_id)->first()->verified_log()->count() == 0) ? '<div class="badge badge-info">Belum</div>' : ($row->keuangan()->where('keuangan_id', $row->keuangan_id)->first()->verified_log()->first()->is_agree ? '<div class="badge badge-success">Disetujui</div>' : '<div class="badge badge-danger">Tidak Disetujui</div>');
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('home.saldo.keuangan_detail', [$row->keuangan_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('saldo/rincian/rincian');
    }
    public function jaminan_riwayat(Request $request)
    {
        if ($request->ajax()) {
            $data = Auth::user()->informasi_akun()->first()->jaminan()->leftJoin('detail_jaminan', 'detail_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('pengeluaran_jaminan', 'pengeluaran_jaminan.jaminan_id', 'jaminan.jaminan_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = is_null($row->detail_jaminan_id) ? $row->tanggal : $row->tanggal_transaksi;
                    return $actionBtn;
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = is_null($row->detail_jaminan_id) ? 'Deposit' : 'Withdraw';
                    return $actionBtn;
                })
                ->addColumn('jumlah', function ($row) {
                    $actionBtn = 'Rp. ' . number_format(is_null($row->nilai_jaminan) ? $row->jumlah : $row->nilai_jaminan, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    if (is_null($row->detail_jaminan_id)) {
                        if (is_null($row->join('pengeluaran_jaminan', 'pengeluaran_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan.pengeluaran_jaminan_id', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'pengeluaran_jaminan_verified_log.verified_log_id')->first())) {
                            return 'Belum';
                        } else {
                            return $row->join('pengeluaran_jaminan', 'pengeluaran_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan.pengeluaran_jaminan_id', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'pengeluaran_jaminan_verified_log.verified_log_id')->first()->is_agree ? 'Disetujui' : 'Tidak Disetujui';
                        }
                    } else if (!is_null($row->detail_jaminan_id)) {
                        if (is_null($row->join('detail_jaminan', 'detail_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('detail_jaminan_verified_log', 'detail_jaminan.detail_jaminan_id', 'detail_jaminan_verified_log.detail_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'detail_jaminan_verified_log.verified_log_id')->first())) {
                            return 'Belum';
                        } else {
                            return $row->join('detail_jaminan', 'detail_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('detail_jaminan_verified_log', 'detail_jaminan.detail_jaminan_id', 'detail_jaminan_verified_log.detail_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'detail_jaminan_verified_log.verified_log_id')->first()->is_agree ? 'Disetujui' : 'Tidak Disetujui';
                        }
                    } else {
                        return '<div class="badge badge-info">Belum</div>';
                    }
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('saldo/jaminan/rincian');
    }
    public function jaminan_deposit_store(Request $request)
    {
        $request->validate([
            'jumlah' => ['required']
        ]);

        if (Auth::user()->informasi_akun()->first()->jaminan()->count() == 0) {
            $jaminan = Jaminan::create([
                'informasi_akun_id' => Auth::user()->informasi_akun_id,
                'total_saldo_jaminan' => 0,
                'saldo_teralokasi' => 0,
                'saldo_tersedia' => 0,
            ]);
        } else {
            $jaminan = Jaminan::where('informasi_akun_id', Auth::user()->informasi_akun_id)->first();
        }
        // Penerimaan Kas Jaminan
        $detailJaminan = $jaminan->detail_jaminan()->create([
            'tanggal_transaksi' => date('Y-m-d'),
            'nilai_jaminan' => str_replace(',', '', request('jumlah')),
            'nilai_penyesuaian' => str_replace(',', '', request('jumlah')),
            'is_aktif' => false,
        ]);

        $kursMataUang = KursMataUang::where('kode_mata_uang_asal', 'IDR')->where('kode_mata_uang_tujuan', 'IDR')->first();
        $detailJaminan->kas()->create([
            'kurs_mata_uang_id' => $kursMataUang->kurs_mata_uang_id,
            'kode_mata_uang' => 'IDR',
            'nilai' => str_replace(',', '', request('jumlah')),
            'nilai_penyesuaian' => str_replace(',', '', request('jumlah')),
            'keterangan' => request('keterangan'),
        ]);
        // End Kas Jaminan


        return redirect('/home/saldo/jaminan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Deposit Jaminan anda menunggu diproses.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
    public function jaminan_withdraw_store(Request $request)
    {
        $request->validate([
            'nomor_rekening' => ['required'],
            'jumlah' => ['required']
        ]);

        $jenis = JenisPengeluaranJaminan::where('nama_jenis', 'Release Cash Collateral')->first();
        $pengeluaranJaminan = Auth::user()->informasi_akun()->first()->jaminan()->first()->pengeluaran_jaminan()->create([
            'jenis_pengeluaran_jaminan_id' => $jenis->jenis_pengeluaran_jaminan_id,
            'kode_transaksi' => $this->transaksiGenerate(),
            'tanggal' => date('Y-m-d'),
            'is_aktif' => true,
            'jumlah' => str_replace(',', '', request('jumlah')),
            'keterangan' => request('keterangan')
        ]);

        $pengeluaranJaminan->release_cash()->create([
            'pengeluaran_jaminan_id' => $pengeluaranJaminan->pengeluaran_jaminan_id,
            'jumlah' => str_replace(',', '', request('jumlah'))
        ]);

        return redirect('/home/saldo/jaminan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Withdraw anda menunggu diproses.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function transaksiGenerate()
    {
        $loop = true;
        $i = 1;
        do {
            $temp = 'TRANS-OUT/' . date('d/m/Y') . '/' . $i;
            $re = PengeluaranJaminan::where('kode_transaksi', $temp)->count();

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
    }
}
