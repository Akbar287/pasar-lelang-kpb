<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Models\DetailJaminan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListJaminanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DetailJaminan::select('detail_jaminan.*')->addSelect('detail_jaminan_verified_log.verified_log_id')->join('detail_jaminan_verified_log', 'detail_jaminan_verified_log.detail_jaminan_id', 'detail_jaminan.detail_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'detail_jaminan_verified_log.verified_log_id')->where('verified_log.is_agree', true)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('nilai_jaminan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_jaminan, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('nilai_penyesuaian', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.list.show', $row->detail_jaminan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/list/index');
    }

    public function show(DetailJaminan $detailJaminan)
    {
        return view('administrasi/jaminan/penerimaan/list/show', compact('detailJaminan'));
    }
}
