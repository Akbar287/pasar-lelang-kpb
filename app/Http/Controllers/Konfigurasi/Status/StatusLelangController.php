<?php

namespace App\Http\Controllers\Konfigurasi\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusLelangRequest;
use App\Models\StatusLelang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StatusLelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusLelang::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.status.lelang.show', $row->status_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/status/lelang/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/status/lelang/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusLelangRequest $statusLelangRequest)
    {
        $statusLelang = StatusLelang::create($this->statusLelangData());

        return redirect('/konfigurasi/status/lelang/' . $statusLelang->status_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Lelang telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusLelang $statusLelang)
    {
        return view('konfigurasi/status/lelang/show', compact('statusLelang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusLelang $statusLelang)
    {
        return view('konfigurasi/status/lelang/edit', compact('statusLelang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusLelangRequest $statusLelangRequest, StatusLelang $statusLelang)
    {
        $statusLelang->update($this->statusLelangData());

        return redirect('/konfigurasi/status/lelang/' . $statusLelang->status_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Lelang telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusLelang $statusLelang)
    {
        $statusLelang->delete();

        return redirect('/konfigurasi/status/lelang')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Lelang telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function statusLelangData()
    {
        return [
            'nama_status' => request('nama_status')
        ];
    }
}
