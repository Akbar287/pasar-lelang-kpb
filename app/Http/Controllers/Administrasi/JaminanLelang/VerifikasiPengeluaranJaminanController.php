<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Models\JenisVerifikasi;
use App\Models\PengeluaranJaminan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VerifikasiPengeluaranJaminanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = PengeluaranJaminan::select('pengeluaran_jaminan.*')->addSelect('ktp.nama')->addSelect('pengeluaran_jaminan_verified_log.verified_log_id')->join('jaminan', 'jaminan.jaminan_id', 'pengeluaran_jaminan.jaminan_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'jaminan.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id', 'pengeluaran_jaminan.pengeluaran_jaminan_id')->whereNull('pengeluaran_jaminan_verified_log.verified_log_id')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('jumlah', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->jumlah, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = '<div class="badge badge-primary">' . $row->jenis_pengeluaran_jaminan()->first()->nama_jenis . '</div>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Disetujui</div>' : (!is_null($row->verified_log()->first()) ? '<div class="badge badge-danger">Ditolak</div>' : '<div class="badge badge-primary">Belum Verifikasi</div>');
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.pengeluaran.verifikasi.show', $row->pengeluaran_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'jenis'])
                ->make(true);
        }
        return view('administrasi/jaminan/pengeluaran/verifikasi/index');
    }
    public function index_ditolak(Request $request)
    {
        $data = PengeluaranJaminan::select('pengeluaran_jaminan.*')->addSelect('ktp.nama')->addSelect('pengeluaran_jaminan_verified_log.verified_log_id')->join('jaminan', 'jaminan.jaminan_id', 'pengeluaran_jaminan.jaminan_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'jaminan.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->join('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id', 'pengeluaran_jaminan.pengeluaran_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'pengeluaran_jaminan_verified_log.verified_log_id')->where('verified_log.is_agree', false)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('jumlah', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->jumlah, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = '<div class="badge badge-primary">' . $row->jenis_pengeluaran_jaminan()->first()->nama_jenis . '</div>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Disetujui</div>' : (!is_null($row->verified_log()->first()) ? '<div class="badge badge-danger">Ditolak</div>' : '<div class="badge badge-primary">Belum Verifikasi</div>');
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.pengeluaran.verifikasi.show_ditolak', $row->pengeluaran_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'jenis', 'status'])
                ->make(true);
        }
        return view('administrasi/jaminan/pengeluaran/verifikasi/index_ditolak');
    }

    public function show(PengeluaranJaminan $pengeluaranJaminan)
    {
        $verified = !is_null($pengeluaranJaminan->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id', 'pengeluaran_jaminan.pengeluaran_jaminan_id')->first()->verified_log_id);

        return view('administrasi/jaminan/pengeluaran/verifikasi/show', compact('pengeluaranJaminan', 'verified'));
    }

    public function show_ditolak(PengeluaranJaminan $pengeluaranJaminan)
    {
        $verified = !is_null($pengeluaranJaminan->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id', 'pengeluaran_jaminan.pengeluaran_jaminan_id')->first()->verified_log_id);

        return view('administrasi/jaminan/pengeluaran/verifikasi/show_ditolak', compact('pengeluaranJaminan', 'verified'));
    }

    public function confirmation(Request $request, PengeluaranJaminan $pengeluaranJaminan)
    {
        $request->validate([
            'confirmation' => ['required']
        ]);

        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Jaminan Pengeluaran')->first();

        $pengeluaranJaminan->verified_log()->create([
            'informasi_akun_id' => $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->informasi_akun_id,
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisVerifikasi->jenis_verifikasi_id,
            'is_agree' => $request->confirmation == 'false' ? false : true,
            'tanggal_verifikasi' => date('Y-m-d'),
            'keterangan' => $request->keterangan,
        ]);


        if ($request->confirmation == 'true') {
            if (!is_null($pengeluaranJaminan->release_cash()->first())) {
                $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->update([
                    'saldo' => $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->saldo + $pengeluaranJaminan->release_cash()->first()->jumlah
                ]);
            }
            if (!is_null($pengeluaranJaminan->return_cash()->first())) {
                $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->update([
                    'saldo' => $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->saldo + $pengeluaranJaminan->return_cash()->first()->jumlah_pengembalian
                ]);
            }
            $pengeluaranJaminan->jaminan()->first()->update([
                'total_saldo_jaminan' => $pengeluaranJaminan->jaminan()->first()->total_saldo_jaminan - $pengeluaranJaminan->jumlah,
                'saldo_tersedia' => $pengeluaranJaminan->jaminan()->first()->saldo_tersedia - $pengeluaranJaminan->jumlah,
            ]);

            $pengeluaranJaminan->update([
                'is_aktif' => true
            ]);
        }

        return redirect('/administrasi/jaminan/pengeluaran/verifikasi/' . $pengeluaranJaminan->pengeluaran_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Verifikasi Pengeluaran Jaminan sudah di konfirmasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function confirmation_ulang(Request $request, PengeluaranJaminan $pengeluaranJaminan)
    {
        if (!is_null(DB::table('pengeluaran_jaminan_verified_log')->where('pengeluaran_jaminan_id', $pengeluaranJaminan->pengeluaran_jaminan_id)->where('verified_log_id', $pengeluaranJaminan->verified_log()->first()->verified_log_id)->first())) {
            $pengeluaranJaminan->verified_log()->first()->delete();
        }

        if (!is_null($pengeluaranJaminan->release_cash()->first())) {
            if ($pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->saldo - $pengeluaranJaminan->release_cash()->first()->jumlah > 0) {
                $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->update([
                    'saldo' => $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->saldo - $pengeluaranJaminan->release_cash()->first()->jumlah
                ]);

                $pengeluaranJaminan->jaminan()->first()->update([
                    'total_saldo_jaminan' => $pengeluaranJaminan->jaminan()->first()->total_saldo_jaminan + $pengeluaranJaminan->jumlah,
                    'saldo_tersedia' => $pengeluaranJaminan->jaminan()->first()->saldo_tersedia + $pengeluaranJaminan->jumlah,
                ]);

                $pengeluaranJaminan->update([
                    'is_aktif' => false
                ]);
            }
        }

        if (!is_null($pengeluaranJaminan->return_cash()->first())) {
            if ($pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->saldo - $pengeluaranJaminan->return_cash()->first()->jumlah_pengembalian > 0) {
                $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->update([
                    'saldo' => $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->first()->saldo - $pengeluaranJaminan->return_cash()->first()->jumlah_pengembalian
                ]);

                $pengeluaranJaminan->jaminan()->first()->update([
                    'total_saldo_jaminan' => $pengeluaranJaminan->jaminan()->first()->total_saldo_jaminan + $pengeluaranJaminan->jumlah,
                    'saldo_tersedia' => $pengeluaranJaminan->jaminan()->first()->saldo_tersedia + $pengeluaranJaminan->jumlah,
                ]);

                $pengeluaranJaminan->update([
                    'is_aktif' => false
                ]);
            }
        }

        return redirect('/administrasi/jaminan/pengeluaran/verifikasi/' . $pengeluaranJaminan->pengeluaran_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Verifikasi Pengeluaran Jaminan sudah di konfirmasi ulang.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
