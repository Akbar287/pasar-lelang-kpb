<?php

namespace App\Http\Controllers\MasterData\Lembaga;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bank::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('count', function ($row) {
                    return $row->rekening_bank()->count();
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.lembaga.bank.show', $row->bank_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/lembaga_pendukung/bank/index');
    }

    public function create()
    {
        return view('master_data/lembaga_pendukung/bank/create');
    }

    public function store(BankRequest $bankRequest)
    {
        $bank = new Bank();
        $bank->kode_bank = $bankRequest->kode_bank;
        $bank->nama_bank = $bankRequest->nama_bank;
        $bank->logo = $bankRequest->logo;
        $bank->save();

        return redirect('/master/lembaga/bank/' . $bank->bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Bank telah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function show(Bank $bank)
    {
        return view('master_data/lembaga_pendukung/bank/show', compact('bank'));
    }

    public function edit(Bank $bank)
    {
        return view('master_data/lembaga_pendukung/bank/edit', compact('bank'));
    }

    public function update(BankRequest $bankRequest, Bank $bank)
    {
        $bank->update($this->bankData());

        return redirect('/master/lembaga/bank/' . $bank->bank_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Bank telah di uabh.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect('/master/lembaga/bank')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Bank telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function bankData()
    {
        return [
            'kode_bank' => request('kode_bank'),
            'nama_bank' => request('nama_bank'),
        ];
    }
}
