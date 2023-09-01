<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\InformasiAkun;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RekeningBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, InformasiAkun $anggota)
    {
        if ($request->ajax()) {
            $data = $anggota->rekening_bank()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_bank', function ($row) {
                    return $row->bank()->first()->nama_bank;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.list.rekening.show', [$row->informasi_akun()->first()->informasi_akun_id, $row->rekening_bank_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/rekening_bank/index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(InformasiAkun $anggota)
    {
        $bank = Bank::get();
        return view('master_data/anggota_pasar_lelang/rekening_bank/create', compact('anggota', 'bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, InformasiAkun $anggota)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required']
        ]);

        $bank = Bank::where('bank_id', $request->bank_id)->first();

        $rekening = $anggota->rekening_bank()->create([
            'bank_id' => $bank->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
            'cabang' => $request->cabang,
            'mata_uang' => $request->mata_uang,
            'nilai_awal' => 0,
            'saldo' => 0
        ]);

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/rekening/' . $rekening->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiAkun $anggota, RekeningBank $rekening)
    {
        return view('master_data/anggota_pasar_lelang/rekening_bank/show', compact('rekening', 'anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiAkun $anggota, RekeningBank $rekening)
    {
        $bank = Bank::get();
        return view('master_data/anggota_pasar_lelang/rekening_bank/edit', compact('rekening', 'anggota', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiAkun $anggota, RekeningBank $rekening)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required']
        ]);

        $bank = Bank::where('bank_id', $request->bank_id)->first();

        $rekening->update([
            'bank_id' => $bank->bank_id,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
            'cabang' => $request->cabang,
            'mata_uang' => $request->mata_uang,
            'nilai_awal' => 0,
            'saldo' => 0
        ]);

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/rekening/' . $rekening->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformasiAkun $anggota, RekeningBank $rekening)
    {
        $rekening->delete();

        return redirect('/master/anggota/list/' . $anggota->informasi_akun_id . '/rekening')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
