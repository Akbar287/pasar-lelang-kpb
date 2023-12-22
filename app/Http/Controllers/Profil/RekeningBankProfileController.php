<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RekeningBankProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Auth::user()->informasi_akun()->first()->rekening_bank()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('bank', function ($row) {
                    return $row->bank()->first()->nama_bank;
                })
                ->addColumn('saldo', function ($row) {
                    return 'Rp. ' . number_format($row->saldo, 0, ".", ",");
                })
                ->addColumn('nilai_awal', function ($row) {
                    return 'Rp. ' . number_format($row->nilai_awal, 0, ".", ",");
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('home.profil.rekening_bank.show', $row->rekening_bank_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('auth/rekening_bank/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bank = Bank::select('bank_id')->addSelect('nama_bank')->get();
        return view('auth/rekening_bank/create', compact('bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required'],
        ]);

        $rekeningBank = Auth::user()->informasi_akun()->first()->rekening_bank()->create($this->rekeningBankData('in'));

        return redirect('/profil/rekening_bank/' . $rekeningBank->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Rekening Bank Profil telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekeningBank $rekeningBank)
    {
        return view('auth/rekening_bank/show', compact('rekeningBank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekeningBank $rekeningBank)
    {
        $bank = Bank::select('bank_id')->addSelect('nama_bank')->get();
        return view('auth/rekening_bank/edit', compact('bank', 'rekeningBank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekeningBank $rekeningBank)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'nama_pemilik' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required'],
        ]);

        $rekeningBank->update($this->rekeningBankData('out'));

        return redirect('/profil/rekening_bank/' . $rekeningBank->rekening_bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Rekening Bank Profil telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekeningBank $rekeningBank)
    {
        $rekeningBank->delete();

        return redirect('/profil/rekening_bank')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Rekening Bank Profil telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function get_saldo(RekeningBank $rekeningBank)
    {
        return response()->json([
            'data' => $rekeningBank->saldo,
            'message' => 'Rekening Bank has found',
            'status' => 'success'
        ]);
        exit;
    }

    public function rekeningBankData($type = null)
    {
        if ($type == 'in') {
            return [
                'bank_id' => request('bank_id'),
                'nomor_rekening' => request('nomor_rekening'),
                'nama_pemilik' => request('nama_pemilik'),
                'cabang' => request('cabang'),
                'mata_uang' => request('mata_uang'),
                'saldo' => 0,
                'nilai_awal' => 0
            ];
        } else {
            return [
                'bank_id' => request('bank_id'),
                'nomor_rekening' => request('nomor_rekening'),
                'nama_pemilik' => request('nama_pemilik'),
                'cabang' => request('cabang'),
                'mata_uang' => request('mata_uang')
            ];
        }
    }
}
