<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanKasJaminanRequest;
use App\Models\DetailJaminan;
use App\Models\Kas;
use App\Models\KursMataUang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanKasJaminanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DetailJaminan $detailJaminan)
    {
        if ($request->ajax()) {
            $data = $detailJaminan->kas()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kurs', function ($row) {
                    $actionBtn = $row->kurs_mata_uang()->first()->kode_mata_uang_asal . ' - ' . $row->kurs_mata_uang()->first()->kode_mata_uang_tujuan;
                    return $actionBtn;
                })
                ->addColumn('nilai', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('nilai_penyesuaian', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.kas.show', [$row->detail_jaminan()->first()->detail_jaminan_id, $row->kas_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/kas/index', compact('detailJaminan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DetailJaminan $detailJaminan)
    {
        $kurs = KursMataUang::get();
        $saldo_available = 0;
        foreach ($detailJaminan->jaminan()->first()->informasi_akun()->first()->rekening_bank()->get() as $dj) {
            $saldo_available += $dj->saldo;
        }
        return view('administrasi/jaminan/penerimaan/kas/create', compact('detailJaminan', 'kurs', 'saldo_available'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenerimaanKasJaminanRequest $penerimaanKasJaminanRequest, DetailJaminan $detailJaminan)
    {
        $kas = $detailJaminan->kas()->create($this->kasData());

        $detailJaminan->update([
            'nilai_jaminan' => $detailJaminan->nilai_jaminan + str_replace(',', '', $penerimaanKasJaminanRequest->nilai),
            'nilai_penyesuaian' => $detailJaminan->nilai_penyesuaian + str_replace(',', '', $penerimaanKasJaminanRequest->nilai_penyesuaian),
        ]);

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/kas/' . $kas->kas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kas sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailJaminan $detailJaminan, Kas $kas)
    {
        return view('administrasi/jaminan/penerimaan/kas/show', compact('detailJaminan', 'kas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailJaminan $detailJaminan, Kas $kas)
    {
        $kurs = KursMataUang::get();
        return view('administrasi/jaminan/penerimaan/kas/edit', compact('detailJaminan', 'kas', 'kurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaanKasJaminanRequest $penerimaanKasJaminanRequest, DetailJaminan $detailJaminan, Kas $kas)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $kas->nilai) + str_replace(',', '', $penerimaanKasJaminanRequest->nilai),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $kas->nilai_penyesuaian) + str_replace(',', '', $penerimaanKasJaminanRequest->nilai_penyesuaian),
        ]);

        $kas->update($this->kasData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/kas/' . $kas->kas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kas sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailJaminan $detailJaminan, Kas $kas)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $kas->nilai),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $kas->nilai_penyesuaian)
        ]);

        $kas->delete();

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/kas')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kas sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function kasData()
    {
        return [
            'kurs_mata_uang_id' => request('kurs_mata_uang_id'),
            'kode_mata_uang' => request('kode_mata_uang'),
            'nilai' => str_replace(',', '', request('nilai')),
            'nilai_penyesuaian' => str_replace(',', '', request('nilai_penyesuaian')),
            'keterangan' => request('keterangan'),
        ];
    }
}
