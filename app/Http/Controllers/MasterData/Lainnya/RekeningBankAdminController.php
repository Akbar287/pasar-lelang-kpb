<?php

namespace App\Http\Controllers\MasterData\Lainnya;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningBankRequest;
use App\Models\Admin;
use App\Models\Bank;
use App\Models\PenyelenggaraPasarLelang;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RekeningBankAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::select('rekening_bank.*')->addSelect('bank.nama_bank')->join('member', 'member.member_id', 'admin.member_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->join('rekening_bank', 'rekening_bank.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('bank', 'bank.bank_id', 'rekening_bank.bank_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.lain.rekening.show', $row->rekening_bank_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/master_lainnya/rekening_bank_admin/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banks = Bank::get();
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        return view('master_data/master_lainnya/rekening_bank_admin/create', compact('banks', 'penyelenggaraPasarLelang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RekeningBankRequest $rekeningBankRequest)
    {
        $ppl = PenyelenggaraPasarLelang::find($rekeningBankRequest->penyelenggara_pasar_lelang_id);
        $rekening = $ppl->admin()->first()->member()->first()->informasi_akun()->first()->rekening_bank()->create($this->rekeningBankAdminData());

        return redirect('/master/lain/rekening/' . $rekening->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank Admin telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekeningBank $rekening)
    {
        return view('master_data/master_lainnya/rekening_bank_admin/show', compact('rekening'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekeningBank $rekening)
    {
        $banks = Bank::get();
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        return view('master_data/master_lainnya/rekening_bank_admin/edit', compact('banks', 'penyelenggaraPasarLelang', 'rekening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RekeningBankRequest $rekeningBankRequest, RekeningBank $rekening)
    {
        $nilai_awal = implode('.', str_replace(',', '', $rekeningBankRequest->nilai_awal));
        $saldo = implode('.', str_replace(',', '', $rekeningBankRequest->saldo));
        $informasi = $rekening->informasi_akun()->first()->informasi_akun_id;
        $rekening->update($this->rekeningBankAdminData($nilai_awal, $saldo, $informasi));

        return redirect('/master/lain/rekening/' . $rekening->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank Admin telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekeningBank $rekening)
    {
        $rekening->delete();

        return redirect('/master/lain/rekening')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Rekening Bank Admin telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function rekeningBankAdminData($nilai_awal = null, $saldo = null, $informasi = null)
    {
        return [
            'informasi_akun_id' => $informasi != null ? $informasi : null,
            'bank_id' => request('bank_id'),
            'nomor_rekening' => request('nomor_rekening'),
            'nama_pemilik' => request('nama_pemilik'),
            'cabang' => request('cabang'),
            'mata_uang' => request('mata_uang'),
            'nilai_awal' => $nilai_awal != null ? $nilai_awal : str_replace(',', '', request('nilai_awal')),
            'saldo' => $saldo != null ? $saldo : str_replace(',', '', request('saldo')),
        ];
    }
}
