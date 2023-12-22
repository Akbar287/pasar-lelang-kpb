<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanKomoditasJaminanRequest;
use App\Models\DetailJaminan;
use App\Models\RegistrasikomoditasJaminan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanKomoditasJaminanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DetailJaminan $detailJaminan)
    {
        if ($request->ajax()) {
            $data = $detailJaminan->registrasi_komoditas_jaminan()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('komoditi', function ($row) {
                    $actionBtn = $row->komoditi;
                    return $actionBtn;
                })
                ->addColumn('kuantitas', function ($row) {
                    $actionBtn = number_format($row->kuantitas, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('unit', function ($row) {
                    $actionBtn = $row->unit;
                    return $actionBtn;
                })
                ->addColumn('nilai_perkiraan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_perkiraan, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('nilai_penyesuaian', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_penyesuaian, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.komoditas.show', [$row->detail_jaminan()->first()->detail_jaminan_id, $row->registrasi_komoditas_jaminan_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/komoditas/index', compact('detailJaminan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DetailJaminan $detailJaminan)
    {
        return view('administrasi/jaminan/penerimaan/komoditas/create', compact('detailJaminan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenerimaanKomoditasJaminanRequest $penerimaanKomoditasJaminanRequest, DetailJaminan $detailJaminan)
    {
        $komoditas = $detailJaminan->registrasi_komoditas_jaminan()->create($this->komoditasData());

        $detailJaminan->update([
            'nilai_jaminan' => $detailJaminan->nilai_jaminan + str_replace(',', '', $penerimaanKomoditasJaminanRequest->nilai_perkiraan),
            'nilai_penyesuaian' => $detailJaminan->nilai_penyesuaian + str_replace(',', '', $penerimaanKomoditasJaminanRequest->nilai_penyesuaian),
        ]);

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/komoditas/' . $komoditas->registrasi_komoditas_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Komoditas sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailJaminan $detailJaminan, RegistrasikomoditasJaminan $komoditas)
    {
        return view('administrasi/jaminan/penerimaan/komoditas/show', compact('detailJaminan', 'komoditas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailJaminan $detailJaminan, RegistrasikomoditasJaminan $komoditas)
    {
        return view('administrasi/jaminan/penerimaan/komoditas/edit', compact('detailJaminan', 'komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaanKomoditasJaminanRequest $penerimaanKomoditasJaminanRequest, DetailJaminan $detailJaminan, RegistrasikomoditasJaminan $komoditas)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $komoditas->nilai_perkiraan) + str_replace(',', '', $penerimaanKomoditasJaminanRequest->nilai_perkiraan),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $komoditas->nilai_penyesuaian) + str_replace(',', '', $penerimaanKomoditasJaminanRequest->nilai_penyesuaian),
        ]);

        $komoditas->update($this->komoditasData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/komoditas/' . $komoditas->registrasi_komoditas_jaminan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Komoditas sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailJaminan $detailJaminan, RegistrasikomoditasJaminan $komoditas)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $komoditas->nilai_perkiraan),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $komoditas->nilai_penyesuaian)
        ]);

        $komoditas->delete();

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/komoditas')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Komoditas sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function komoditasData()
    {
        return [
            'komoditi' => request('komoditi'),
            'kadaluarsa' => request('kadaluarsa'),
            'unit' => request('unit'),
            'kuantitas' => str_replace(',', '', request('kuantitas')),
            'nilai_perkiraan' => str_replace(',', '', request('nilai_perkiraan')),
            'haircut' => str_replace(',', '', request('haircut')),
            'nilai_penyesuaian' => str_replace(',', '', request('nilai_penyesuaian')),
            'lokasi' => request('lokasi'),
        ];
    }
}
