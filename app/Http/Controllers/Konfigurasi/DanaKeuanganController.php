<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\DanaKeuangan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DanaKeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DanaKeuangan::select('dana_keuangan.dana_keuangan_id')->addSelect('dana_keuangan.jumlah_dana')->addSelect('dana_keuangan.jenis')->addSelect('dana_keuangan.created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jumlah_dana', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->jumlah_dana, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = $row->jenis;
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = $row->created_at->format('d F Y');
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.dana_keuangan.show', $row->dana_keuangan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('konfigurasi/dana_keuangan/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DanaKeuangan $danaKeuangan)
    {
        return view('konfigurasi/dana_keuangan/show', compact('danaKeuangan'));
    }
}
