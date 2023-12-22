<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\RekeningPusat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RekeningPusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RekeningPusat::select('rekening_pusat_id')->addSelect('rekening_pusat.saldo')->addSelect('rekening_pusat.aktif')->addSelect('bank.nama_bank')->addSelect('rekening_pusat.status')->addSelect('rekening_pusat.nomor_rekening')->join('bank', 'bank.bank_id', 'rekening_pusat.bank_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Nonaktif</div>';
                    return $actionBtn;
                })
                ->addColumn('nomor_rekening', function ($row) {
                    $actionBtn = $row->nomor_rekening;
                    return $actionBtn;
                })
                ->addColumn('aktif', function ($row) {
                    $actionBtn = $row->aktif ? '<div class="badge badge-success">Default</div>' : '<div class="badge badge-danger">Bukan Default</div>';
                    return $actionBtn;
                })
                ->addColumn('saldo', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->saldo, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.rekening_pusat.show', $row->rekening_pusat_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'aktif'])
                ->make(true);
        }
        return view('konfigurasi/rekening_pusat/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bank = Bank::get();
        return view('konfigurasi/rekening_pusat/create', compact('bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required'],
            'saldo' => ['required'],
            'aktif' => ['required'],
            'status' => ['required'],
        ]);

        $bank = Bank::where('bank_id', $request->bank_id)->first();
        $rekeningPusat = $bank->rekening_pusat()->create($this->rekening_pusat_data());

        return redirect('/konfigurasi/rekening_pusat/' . $rekeningPusat->rekening_pusat_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Rekening Pusat sudah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekeningPusat $rekeningPusat)
    {
        return view('konfigurasi/rekening_pusat/show', compact('rekeningPusat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekeningPusat $rekeningPusat)
    {
        $bank = Bank::get();
        return view('konfigurasi/rekening_pusat/edit', compact('rekeningPusat', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekeningPusat $rekeningPusat)
    {
        $request->validate([
            'bank_id' => ['required'],
            'nomor_rekening' => ['required'],
            'cabang' => ['required'],
            'mata_uang' => ['required'],
            'saldo' => ['required'],
            'aktif' => ['required'],
            'status' => ['required'],
        ]);

        $rekeningPusat->update($this->rekening_pusat_data());

        return redirect('/konfigurasi/rekening_pusat/' . $rekeningPusat->rekening_pusat_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Rekening Pusat sudah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekeningPusat $rekeningPusat)
    {
        if ($rekeningPusat->saldo == 0) {
            $rekeningPusat->delete();

            return redirect('/konfigurasi/rekening_pusat')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Rekening Pusat sudah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/konfigurasi/rekening_pusat/' . $rekeningPusat->rekening_pusat_id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Rekening Pusat tidak dapat dihapus karena ada sisa saldo sebesar Rp. ' . number_format($rekeningPusat->saldo, 0, ".", ",") . '.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    public function rekening_pusat_data()
    {
        return [
            'bank_id' => request('bank_id'),
            'nomor_rekening' => request('nomor_rekening'),
            'cabang' => request('cabang'),
            'mata_uang' => request('mata_uang'),
            'saldo' => str_replace(',', '', request('saldo')),
            'aktif' => request('aktif'),
            'status' => request('status')
        ];
    }
}
