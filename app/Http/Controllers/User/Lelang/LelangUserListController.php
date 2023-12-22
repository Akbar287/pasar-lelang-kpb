<?php

namespace App\Http\Controllers\User\Lelang;

use App\Http\Controllers\Controller;
use App\Models\JenisHarga;
use App\Models\Lelang;
use App\Models\StatusLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class LelangUserListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = StatusLelang::select('status_lelang_id')->whereIn('nama_status', ['Verifikasi', 'Aktif', 'Tolak', 'Suspend', 'Selesai'])->get();

            $data = Auth::user()->informasi_akun()->first()->kontrak()->select('lelang.kuantitas')->addSelect('lelang.nomor_lelang')->addSelect('kontrak.kontrak_kode')->addSelect('lelang.judul')->addSelect('lelang.harga_awal')->addSelect('lelang.kelipatan_penawaran')->addSelect('lelang.created_at')->addSelect('lelang.lelang_id')->addSelect('status_lelang_pivot.status_lelang_id')->addSelect('status_lelang.nama_status')->join('lelang', 'lelang.kontrak_id', 'kontrak.kontrak_id')->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->leftJoin('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang_pivot.is_aktif', true)->whereNull('lelang.deleted_at')->whereIn('status_lelang_pivot.status_lelang_id', $status)->get();

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
                ->addColumn('kelipatan_penawaran', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->kelipatan_penawaran, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->nama_status;
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('lelang.list.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('user/lelang/list/index');
    }

    public function show(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        return view('user/lelang/list/show', compact('lelang', 'jenisHarga'));
    }
}
