<?php

namespace App\Http\Controllers\Konfigurasi\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PerjanjianJualBeliPasal;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KonfigurasiLaporanPerjanjianJualBeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PerjanjianJualBeliPasal::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.laporan.perjanjian_jual_beli.show', $row->perjanjian_jual_beli_pasal_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/laporan/perjanjian_jual_beli/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/laporan/perjanjian_jual_beli/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['key' => ['required'], 'value' => ['required']]);

        $perjanjianJualBeliPasal = PerjanjianJualBeliPasal::create($this->perjanjianJualBeliPasalData());

        return redirect('/konfigurasi/laporan/perjanjian_jual_beli/' . $perjanjianJualBeliPasal->perjanjian_jual_beli_pasal_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Pasal Perjanjian jual Beli telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerjanjianJualBeliPasal $perjanjianJualBeliPasal)
    {
        return view('konfigurasi/laporan/perjanjian_jual_beli/show', compact('perjanjianJualBeliPasal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerjanjianJualBeliPasal $perjanjianJualBeliPasal)
    {
        return view('konfigurasi/laporan/perjanjian_jual_beli/edit', compact('perjanjianJualBeliPasal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerjanjianJualBeliPasal $perjanjianJualBeliPasal)
    {
        $request->validate(['key' => ['required'], 'value' => ['required']]);

        $perjanjianJualBeliPasal->update($this->perjanjianJualBeliPasalData());

        return redirect('/konfigurasi/laporan/perjanjian_jual_beli/' . $perjanjianJualBeliPasal->perjanjian_jual_beli_pasal_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Pasal Perjanjian jual Beli telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerjanjianJualBeliPasal $perjanjianJualBeliPasal)
    {
        $perjanjianJualBeliPasal->delete();

        return redirect('/konfigurasi/laporan/perjanjian_jual_beli')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Pasal Perjanjian jual Beli telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function perjanjianJualBeliPasalData()
    {
        return [
            'key' => request('key'),
            'value' => request('value'),
        ];
    }
}
