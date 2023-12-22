<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanJaminanResiGudangRequest;
use App\Models\DetailJaminan;
use App\Models\JenisSuratBerharga;
use App\Models\ResiGudang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanJaminanResiGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DetailJaminan $detailJaminan)
    {
        if ($request->ajax()) {
            $resi = JenisSuratBerharga::where('nama_jenis', 'Resi Gudang')->first();
            $data = $detailJaminan->surat_berharga()->select('resi_gudang.resi_gudang_id')->addSelect('resi_gudang.nama_resi_gudang')->addSelect('resi_gudang.tanggal_jatuh_tempo')->addSelect('resi_gudang.nilai_resi_gudang')->addSelect('resi_gudang.haircut')->addSelect('resi_gudang.nilai_tersedia')->addSelect('detail_jaminan.detail_jaminan_id')->join('resi_gudang', 'resi_gudang.surat_berharga_id', 'surat_berharga.surat_berharga_id')->join('detail_jaminan', 'detail_jaminan.detail_jaminan_id', 'surat_berharga.detail_jaminan_id')->where('jenis_surat_berharga_id', $resi->jenis_surat_berharga_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nilai_resi_gudang', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->nilai_resi_gudang, 0, ".", ",");
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
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.resi_gudang.show', [$row->detail_jaminan_id, $row->resi_gudang_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/surat_berharga/resi_gudang/index', compact('detailJaminan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DetailJaminan $detailJaminan)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/resi_gudang/create', compact('detailJaminan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenerimaanJaminanResiGudangRequest $penerimaanJaminanResiGudangRequest, DetailJaminan $detailJaminan)
    {
        $jenis = JenisSuratBerharga::where('nama_jenis', 'Resi Gudang')->first();
        $sb = $detailJaminan->surat_berharga()->create([
            'jenis_surat_berharga_id' => $jenis->jenis_surat_berharga_id
        ]);

        $resiGudang = $sb->resi_gudang()->create($this->resiGudangData());
        $detailJaminan->update([
            'nilai_jaminan' => $detailJaminan->nilai_jaminan + str_replace(',', '', $penerimaanJaminanResiGudangRequest->nilai_resi_gudang),
            'nilai_penyesuaian' => $detailJaminan->nilai_penyesuaian + str_replace(',', '', $penerimaanJaminanResiGudangRequest->nilai_tersedia),
        ]);

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/resi_gudang/' . $resiGudang->resi_gudang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jaminan Resi Gudang sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailJaminan $detailJaminan, ResiGudang $resiGudang)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/resi_gudang/show', compact('detailJaminan', 'resiGudang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailJaminan $detailJaminan, ResiGudang $resiGudang)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/resi_gudang/edit', compact('detailJaminan', 'resiGudang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaanJaminanResiGudangRequest $penerimaanJaminanResiGudangRequest, DetailJaminan $detailJaminan, ResiGudang $resiGudang)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $resiGudang->nilai_resi_gudang) + str_replace(',', '', $penerimaanJaminanResiGudangRequest->nilai_resi_gudang),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $resiGudang->nilai_tersedia) + str_replace(',', '', $penerimaanJaminanResiGudangRequest->nilai_tersedia),
        ]);

        $resiGudang->update($this->resiGudangData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/resi_gudang/' . $resiGudang->resi_gudang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jaminan Resi Gudang sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailJaminan $detailJaminan, ResiGudang $resiGudang)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $resiGudang->nilai_resi_gudang),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $resiGudang->nilai_tersedia)
        ]);

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/resi_gudang')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jaminan Resi Gudang sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function resiGudangData()
    {
        return [
            'jenis' => request('jenis'),
            'pemilik_barang' => request('pemilik_barang'),
            'pemegang_resi_gudang' => request('pemegang_resi_gudang'),
            'no_penerbitan' => request('no_penerbitan'),
            'nama_resi_gudang' => request('nama_resi_gudang'),
            'nilai_resi_gudang' => str_replace(',', '', request('nilai_resi_gudang')),
            'haircut' => str_replace(',', '', request('haircut')),
            'nilai_tersedia' => str_replace(',', '', request('nilai_tersedia')),
            'tanggal_penerbitan' => request('tanggal_penerbitan'),
            'tanggal_jatuh_tempo' => request('tanggal_jatuh_tempo'),
        ];
    }
}
