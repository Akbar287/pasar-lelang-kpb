<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanJaminanObligasiRequest;
use App\Models\DetailJaminan;
use App\Models\JenisSuratBerharga;
use App\Models\Obligasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanJaminanObligasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DetailJaminan $detailJaminan)
    {
        if ($request->ajax()) {
            $obligasi = JenisSuratBerharga::where('nama_jenis', 'Obligasi')->first();
            $data = $detailJaminan->surat_berharga()->select('obligasi.obligasi_id')->addSelect('obligasi.jenis')->addSelect('obligasi.tanggal_jatuh_tempo')->addSelect('obligasi.nilai_nominal')->addSelect('obligasi.haircut')->addSelect('obligasi.nilai_tersedia')->addSelect('detail_jaminan.detail_jaminan_id')->join('obligasi', 'obligasi.surat_berharga_id', 'surat_berharga.surat_berharga_id')->join('detail_jaminan', 'detail_jaminan.detail_jaminan_id', 'surat_berharga.detail_jaminan_id')->where('jenis_surat_berharga_id', $obligasi->jenis_surat_berharga_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nilai_nominal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_nominal, 0, ".", ",");
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
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.obligasi.show', [$row->detail_jaminan_id, $row->obligasi_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/surat_berharga/obligasi/index', compact('detailJaminan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DetailJaminan $detailJaminan)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/obligasi/create', compact('detailJaminan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenerimaanJaminanObligasiRequest $penerimaanJaminanObligasiRequest, DetailJaminan $detailJaminan)
    {
        $jenis = JenisSuratBerharga::where('nama_jenis', 'Obligasi')->first();
        $sb = $detailJaminan->surat_berharga()->create([
            'jenis_surat_berharga_id' => $jenis->jenis_surat_berharga_id
        ]);

        $obligasi = $sb->obligasi()->create($this->obligasiData());
        $detailJaminan->update([
            'nilai_jaminan' => $detailJaminan->nilai_jaminan + str_replace(',', '', $penerimaanJaminanObligasiRequest->nilai_nominal),
            'nilai_penyesuaian' => $detailJaminan->nilai_penyesuaian + str_replace(',', '', $penerimaanJaminanObligasiRequest->nilai_tersedia),
        ]);

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/obligasi/' . $obligasi->obligasi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Obligasi sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailJaminan $detailJaminan, Obligasi $obligasi)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/obligasi/show', compact('detailJaminan', 'obligasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailJaminan $detailJaminan, Obligasi $obligasi)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/obligasi/edit', compact('detailJaminan', 'obligasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaanJaminanObligasiRequest $penerimaanJaminanObligasiRequest, DetailJaminan $detailJaminan, Obligasi $obligasi)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $obligasi->nilai_nominal) + str_replace(',', '', $penerimaanJaminanObligasiRequest->nilai_nominal),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $obligasi->nilai_tersedia) + str_replace(',', '', $penerimaanJaminanObligasiRequest->nilai_tersedia),
        ]);

        $obligasi->update($this->obligasiData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/obligasi/' . $obligasi->obligasi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Obligasi sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailJaminan $detailJaminan, Obligasi $obligasi)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $obligasi->nilai_nominal),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $obligasi->nilai_tersedia)
        ]);

        $obligasi->delete();

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/obligasi')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Obligasi sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function obligasiData()
    {
        return [
            'jenis' => request('jenis'),
            'kupon' => request('kupon'),
            'lokasi' => request('lokasi'),
            'penerbit' => request('penerbit'),
            'tipe_kupon' => request('tipe_kupon'),
            'haircut' => str_replace(',', '', request('haircut')),
            'nilai_nominal' => str_replace(',', '', request('nilai_nominal')),
            'nilai_tersedia' => str_replace(',', '', request('nilai_tersedia')),
            'tanggal_penerbitan' => request('tanggal_penerbitan'),
            'tanggal_jatuh_tempo' => request('tanggal_jatuh_tempo'),
        ];
    }
}
