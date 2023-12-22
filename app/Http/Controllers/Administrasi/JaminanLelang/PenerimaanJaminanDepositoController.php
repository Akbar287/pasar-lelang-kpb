<?php

namespace App\Http\Controllers\Administrasi\JaminanLelang;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanJaminanDepositoRequest;
use App\Models\Deposito;
use App\Models\DetailJaminan;
use App\Models\JenisSuratBerharga;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenerimaanJaminanDepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DetailJaminan $detailJaminan)
    {
        if ($request->ajax()) {
            $deposito = JenisSuratBerharga::where('nama_jenis', 'Deposito')->first();
            $data = $detailJaminan->surat_berharga()->select('deposito.deposito_id')->addSelect('deposito.tanggal_terima')->addSelect('deposito.tanggal_jatuh_tempo')->addSelect('deposito.nilai_nominal')->addSelect('deposito.haircut')->addSelect('deposito.nilai_tersedia')->addSelect('detail_jaminan.detail_jaminan_id')->join('deposito', 'deposito.surat_berharga_id', 'surat_berharga.surat_berharga_id')->join('detail_jaminan', 'detail_jaminan.detail_jaminan_id', 'surat_berharga.detail_jaminan_id')->where('jenis_surat_berharga_id', $deposito->jenis_surat_berharga_id)->get();
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
                    $actionBtn = '<a href="' . route('administrasi.jaminan.penerimaan.deposito.show', [$row->detail_jaminan_id, $row->deposito_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('administrasi/jaminan/penerimaan/surat_berharga/deposito/index', compact('detailJaminan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DetailJaminan $detailJaminan)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/deposito/create', compact('detailJaminan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenerimaanJaminanDepositoRequest $penerimaanJaminanDepositoRequest, DetailJaminan $detailJaminan)
    {
        $jenis = JenisSuratBerharga::where('nama_jenis', 'Deposito')->first();
        $sb = $detailJaminan->surat_berharga()->create([
            'jenis_surat_berharga_id' => $jenis->jenis_surat_berharga_id
        ]);

        $deposito = $sb->deposito()->create($this->depositoData());
        $detailJaminan->update([
            'nilai_jaminan' => $detailJaminan->nilai_jaminan + str_replace(',', '', $penerimaanJaminanDepositoRequest->nilai_nominal),
            'nilai_penyesuaian' => $detailJaminan->nilai_penyesuaian + str_replace(',', '', $penerimaanJaminanDepositoRequest->nilai_tersedia),
        ]);

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/deposito/' . $deposito->deposito_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Deposito sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailJaminan $detailJaminan, Deposito $deposito)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/deposito/show', compact('detailJaminan', 'deposito'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailJaminan $detailJaminan, Deposito $deposito)
    {
        return view('administrasi/jaminan/penerimaan/surat_berharga/deposito/edit', compact('detailJaminan', 'deposito'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaanJaminanDepositoRequest $penerimaanJaminanDepositoRequest, DetailJaminan $detailJaminan, Deposito $deposito)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $deposito->nilai_nominal) + str_replace(',', '', $penerimaanJaminanDepositoRequest->nilai_nominal),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $deposito->nilai_tersedia) + str_replace(',', '', $penerimaanJaminanDepositoRequest->nilai_tersedia),
        ]);

        $deposito->update($this->depositoData());

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/deposito/' . $deposito->deposito_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Deposito sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailJaminan $detailJaminan, Deposito $deposito)
    {
        $detailJaminan->update([
            'nilai_jaminan' => ($detailJaminan->nilai_jaminan - $deposito->nilai_nominal),
            'nilai_penyesuaian' => ($detailJaminan->nilai_penyesuaian - $deposito->nilai_tersedia)
        ]);

        $deposito->delete();

        return redirect('/administrasi/jaminan/penerimaan/' . $detailJaminan->detail_jaminan_id . '/deposito')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Deposito sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function depositoData()
    {
        return [
            'tanggal_terima' => date('Y-m-d'),
            'no_sertifikat' => request('no_sertifikat'),
            'no_rekening' => request('no_rekening'),
            'tanggal_terbit' => request('tanggal_terbit'),
            'tanggal_jatuh_tempo' => request('tanggal_jatuh_tempo'),
            'tanggal_valuta' => request('tanggal_valuta'),
            'bank_penerbit' => request('bank_penerbit'),
            'nilai_nominal' => str_replace(',', '', request('nilai_nominal')),
            'haircut' => str_replace(',', '', request('haircut')),
            'nilai_tersedia' => str_replace(',', '', request('nilai_tersedia')),
        ];
    }
}
