<?php

namespace App\Http\Controllers\Administrasi\KasBank;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\JenisTransaksi;
use App\Models\Keuangan;
use App\Models\KursMataUang;
use App\Models\Member;
use App\Models\RekeningBank;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanKasBankController extends Controller
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
                    $actionBtn = '<a href="' . route('administrasi.kas_bank.penerimaan.show', $row->keuangan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/kas_bank/penerimaan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisTransaksi = JenisTransaksi::get();
        $member = StatusMember::where('nama_status', 'Aktif')->first()->member()->get();
        $noRekAdmin = Admin::where('is_aktif', true)->get();
        $kurs = KursMataUang::select('kurs_mata_uang_id')->addSelect('mata_uang_asal')->addSelect('mata_uang_tujuan')->orderBy('tanggal_update', 'desc')->get();
        return view('administrasi/kas_bank/penerimaan/create', compact('jenisTransaksi', 'kurs', 'member', 'noRekAdmin'));
    }

    public function create_api(Request $request)
    {
        $request->validate([
            'member' => ['required']
        ]);

        $rekening = Member::where('member_id', $request->member)->first()->informasi_akun()->first()->rekening_bank()->select('rekening_bank.rekening_bank_id')->addSelect('rekening_bank.nomor_rekening')->addSelect('bank.nama_bank')->join('bank', 'bank.bank_id', 'rekening_bank.bank_id')->get();

        return response()->json([
            'data' => $rekening,
            'message' => 'Rekening Bank has been catched from member Id',
            'status' => 'success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_transaksi_id' => ['required'],
            'rekening_bank_id' => ['required'],
            'kurs_mata_uang_id' => ['required'],
            'jumlah' => ['required']
        ]);

        if ($request->jenis_transaksi_id == 'Cash / Bank In (Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required'],
                'nomor_instruksi' => ['required'],
                'jenis_alokasi' => ['required'],
                'sisa_alokasi' => ['required'],
                'alokasi_collateral' => ['required'],
                'alokasi_penyelesaian' => ['required'],
                'alokasi_lain' => ['required'],
            ]);
        }
        if ($request->jenis_transaksi_id == 'Cash / Bank In (Non-Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required']
            ]);
        }
        if ($request->jenis_transaksi_id == 'Cash / Bank Out (Settlement)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);
        }
        if ($request->jenis_transaksi_id == 'Cash / Bank Out (Pengembalian Collateral)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);
        }

        $rekeningBank = RekeningBank::where('rekening_bank_id', $request->rekening_bank_id)->first();
        $jenisTransaksi = JenisTransaksi::where('nama_jenis', $request->jenis_transaksi_id)->first();

        $keuangan = $rekeningBank->keuangan()->create([
            'jenis_transaksi_id' => $jenisTransaksi->jenis_transaksi_id,
            'kurs_mata_uang_id' => $request->kurs_mata_uang_id,
            'jumlah' => str_replace(',', '', $request->jumlah),
            'keterangan' => $request->keterangan,
        ]);

        if ($request->jenis_transaksi_id == 'Cash / Bank In (Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required'],
                'nomor_instruksi' => ['required'],
                'jenis_alokasi' => ['required'],
                'sisa_alokasi' => ['required'],
                'alokasi_collateral' => ['required'],
                'alokasi_penyelesaian' => ['required'],
                'alokasi_lain' => ['required'],
            ]);

            $keuangan->keuangan_cash_in_trading()->create([
                'saldo_belum_teralokasi' => str_replace(',', '', $request->saldo_belum_teralokasi),
                'nomor_instruksi' => $request->nomor_instruksi,
                'jenis_alokasi' => $request->jenis_alokasi,
                'sisa_alokasi' => str_replace(',', '', $request->sisa_alokasi),
                'alokasi_collateral' => $request->alokasi_collateral,
                'alokasi_penyelesaian' => $request->alokasi_penyelesaian,
                'alokasi_lain' => $request->alokasi_lain,
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank In (Trading) sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else if ($request->jenis_transaksi_id == 'Cash / Bank In (Non-Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required']
            ]);

            $keuangan->keuangan_cash_non_trading()->create([
                'saldo_belum_teralokasi' => str_replace(',', '', $request->saldo_belum_teralokasi)
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank In (Non-Trading) sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else if ($request->jenis_transaksi_id == 'Cash / Bank Out (Settlement)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);

            $keuangan->keuangan_cash_settlement()->create([
                'rekening_bank_id' => $request->no_rekening_tujuan_id
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank Out (Settlement) sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else if ($request->jenis_transaksi_id == 'Cash / Bank Out (Pengembalian Collateral)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);

            $keuangan->keuangan_cash_pengembalian_collateral()->create([
                'rekening_bank_id' => $request->no_rekening_tujuan_id
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank Out (Pengembalian Collateral) sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else if ($request->jenis_transaksi_id == 'Cash / Bank Out (Pembayaran Fee)') {
            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank Out (Pembayaran Fee) sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/administrasi/kas_bank/penerimaan/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan gagal ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Keuangan $keuangan)
    {
        return view('administrasi/kas_bank/penerimaan/show', compact('keuangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keuangan $keuangan)
    {
        $noRek = $keuangan->rekening_bank()->first()->informasi_akun()->first()->rekening_bank()->get();
        $noRekAdmin = [];
        if ($keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Settlement)') {
            $noRekAdmin = $keuangan->keuangan_cash_settlement()->first()->rekening_bank()->first()->informasi_akun()->first()->rekening_bank()->get();
        }
        if ($keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Pengembalian Collateral)') {
            $noRekAdmin = $keuangan->keuangan_cash_pengembalian_collateral()->first()->rekening_bank()->first()->informasi_akun()->first()->rekening_bank()->get();
        }
        return view('administrasi/kas_bank/penerimaan/edit', compact('keuangan', 'noRek', 'noRekAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keuangan $keuangan)
    {
        $request->validate([
            'jenis_transaksi_id' => ['required'],
            'rekening_bank_id' => ['required'],
            'kurs_mata_uang_id' => ['required'],
            'jumlah' => ['required']
        ]);

        if ($request->jenis_transaksi_id == 'Cash / Bank In (Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required'],
                'nomor_instruksi' => ['required'],
                'jenis_alokasi' => ['required'],
                'sisa_alokasi' => ['required'],
                'alokasi_collateral' => ['required'],
                'alokasi_penyelesaian' => ['required'],
                'alokasi_lain' => ['required'],
            ]);
        }
        if ($request->jenis_transaksi_id == 'Cash / Bank In (Non-Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required']
            ]);
        }
        if ($request->jenis_transaksi_id == 'Cash / Bank Out (Settlement)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);
        }
        if ($request->jenis_transaksi_id == 'Cash / Bank Out (Pengembalian Collateral)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);
        }

        $rekeningBank = RekeningBank::where('rekening_bank_id', $request->rekening_bank_id)->first();
        $jenisTransaksi = $keuangan->jenis_transaksi()->first();

        $keuangan->update([
            'rekening_bank_id' => $rekeningBank->rekening_bank_id,
            'jumlah' => str_replace(',', '', $request->jumlah),
            'keterangan' => $request->keterangan,
        ]);

        if ($jenisTransaksi->nama_jenis == 'Cash / Bank In (Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required'],
                'nomor_instruksi' => ['required'],
                'jenis_alokasi' => ['required'],
                'sisa_alokasi' => ['required'],
                'alokasi_collateral' => ['required'],
                'alokasi_penyelesaian' => ['required'],
                'alokasi_lain' => ['required'],
            ]);

            $keuangan->keuangan_cash_in_trading()->first()->update([
                'saldo_belum_teralokasi' => str_replace(',', '', $request->saldo_belum_teralokasi),
                'nomor_instruksi' => $request->nomor_instruksi,
                'jenis_alokasi' => $request->jenis_alokasi,
                'sisa_alokasi' => str_replace(',', '', $request->sisa_alokasi),
                'alokasi_collateral' => $request->alokasi_collateral,
                'alokasi_penyelesaian' => $request->alokasi_penyelesaian,
                'alokasi_lain' => $request->alokasi_lain,
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank In (Trading) sudah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else if ($jenisTransaksi->nama_jenis == 'Cash / Bank In (Non-Trading)') {
            $request->validate([
                'saldo_belum_teralokasi' => ['required']
            ]);

            $keuangan->keuangan_cash_non_trading()->first()->update([
                'saldo_belum_teralokasi' => str_replace(',', '', $request->saldo_belum_teralokasi)
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank In (Non-Trading) sudah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else if ($jenisTransaksi->nama_jenis == 'Cash / Bank Out (Settlement)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);

            $keuangan->keuangan_cash_settlement()->first()->update([
                'rekening_bank_id' => $request->no_rekening_tujuan_id
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank Out (Settlement) sudah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else if ($jenisTransaksi->nama_jenis == 'Cash / Bank Out (Pengembalian Collateral)') {
            $request->validate([
                'no_rekening_tujuan_id' => ['required']
            ]);

            $keuangan->keuangan_cash_pengembalian_collateral()->first()->update([
                'rekening_bank_id' => $request->no_rekening_tujuan_id
            ]);

            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan Cash / Bank Out (Pengembalian Collateral) sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/administrasi/kas_bank/penerimaan/' . $keuangan->keuangan_id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Keuangan gagal ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();

        return redirect('/administrasi/kas_bank/penerimaan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Keuangan sudah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
