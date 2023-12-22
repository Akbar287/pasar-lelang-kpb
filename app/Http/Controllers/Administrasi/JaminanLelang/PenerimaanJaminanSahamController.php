<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanJaminanSahamRequest;
use App\Models\DetailJaminan;
use App\Models\JenisSuratBerharga;
use App\Models\Saham;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanJaminanSahamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DetailJaminan $detailJaminan)
    {
        if ($request->ajax()) {
            $saham = JenisSuratBerharga::where('nama_jenis', 'Saham')->first();
            $data = $detailJaminan->surat_berharga()->select('saham.saham_id')->addSelect('saham.kode_saham')->addSelect('saham.lot')->addSelect('saham.nilai_saham')->addSelect('saham.haircut')->addSelect('saham.nilai_tersedia')->addSelect('detail_jaminan.detail_jaminan_id')->join('saham', 'saham.surat_berharga_id', 'surat_berharga.surat_berharga_id')->join('detail_jaminan', 'detail_jaminan.detail_jaminan_id', 'surat_berharga.detail_jaminan_id')->where('jenis_surat_berharga_id', $saham->jenis_surat_berharga_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nilai_saham', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_saham, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('haircut', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->haircut, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('nilai_tersedia', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_tersedia, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.saham.show', [$row->detail_jaminan_id, $row->saham_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/surat_berharga/saham/index', compact('detailJaminan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DetailJaminan $detailJaminan)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/saham/create', compact('detailJaminan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenerimaanJaminanSahamRequest $penerimaanJaminanSahamRequest, DetailJaminan $detailJaminan)
    {
        $jenis = JenisSuratBerharga::where('nama_jenis', 'Saham')->first();
        $sb = $detailJaminan->surat_berharga()->create([
            'jenis_surat_berharga_id' => $jenis->jenis_surat_berharga_id
        ]);

        $saham = $sb->saham()->create($this->sahamData());
        $detailJaminan->update([
            'nilai_jaminan' => $detailJaminan->nilai_jaminan + str_replace(',', '', $penerimaanJaminanSahamRequest->nilai_saham),
            'nilai_penyesuaian' => $detailJaminan->nilai_penyesuaian + str_replace(',', '', $penerimaanJaminanSahamRequest->nilai_tersedia),
        ]);

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/saham/' . $saham->saham_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Saham sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailJaminan $detailJaminan, Saham $saham)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/saham/show', compact('detailJaminan', 'saham'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailJaminan $detailJaminan, Saham $saham)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/saham/edit', compact('detailJaminan', 'saham'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaanJaminanSahamRequest $penerimaanJaminanSahamRequest, DetailJaminan $detailJaminan, Saham $saham)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $saham->nilai_saham) + str_replace(',', '', $penerimaanJaminanSahamRequest->nilai_saham),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $saham->nilai_tersedia) + str_replace(',', '', $penerimaanJaminanSahamRequest->nilai_tersedia),
        ]);

        $saham->update($this->sahamData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/saham/' . $saham->saham_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Saham sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailJaminan $detailJaminan, Saham $saham)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $saham->nilai_saham),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $saham->nilai_tersedia)
        ]);

        $saham->delete();

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/saham')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Saham sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function sahamData()
    {
        return [
            'kode_saham' => request('kode_saham'),
            'penerbit' => request('penerbit'),
            'harga_saham' => str_replace(',', '', request('harga_saham')),
            'lot' => str_replace(',', '', request('lot')),
            'nilai_saham' => str_replace(',', '', request('nilai_saham')),
            'haircut' => str_replace(',', '', request('haircut')),
            'nilai_tersedia' => str_replace(',', '', request('nilai_tersedia')),
            'lokasi' => request('lokasi'),
        ];
    }
}
