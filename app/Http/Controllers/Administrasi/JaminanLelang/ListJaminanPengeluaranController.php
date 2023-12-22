<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Models\PengeluaranJaminan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListJaminanPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = PengeluaranJaminan::select('pengeluaran_jaminan.*')->addSelect('ktp.nama')->addSelect('pengeluaran_jaminan_verified_log.verified_log_id')->join('jaminan', 'jaminan.jaminan_id', 'pengeluaran_jaminan.jaminan_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'jaminan.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->join('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id', 'pengeluaran_jaminan.pengeluaran_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'pengeluaran_jaminan_verified_log.verified_log_id')->where('verified_log.is_agree', true)->get();
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
                    $actionBtn = $row->verified_log()->first()->is_agree ? '<div class="badge badge-success">Disetujui</div>' : (!is_null($row->verified_log()->first()) ? '<div class="badge badge-danger">Ditolak</div>' : '<div class="badge badge-primary">Belum Verifikasi</div>');
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.pengeluaran.list.show', $row->pengeluaran_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'jenis'])
                ->make(true);
        }
        return view('administrasi/jaminan/pengeluaran/list/index');
    }

    public function show(PengeluaranJaminan $pengeluaranJaminan)
    {
        $verified = !is_null($pengeluaranJaminan->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id', 'pengeluaran_jaminan.pengeluaran_jaminan_id')->first()->verified_log_id);

        return view('administrasi/jaminan/pengeluaran/list/show', compact('pengeluaranJaminan', 'verified'));
    }
}
