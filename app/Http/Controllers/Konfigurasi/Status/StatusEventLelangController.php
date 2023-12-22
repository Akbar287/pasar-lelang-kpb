<?php

namespace App\Http\Controllers\Konfigurasi\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusEventLelangRequest;
use App\Models\StatusEventLelang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StatusEventLelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusEventLelang::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.status.event_lelang.show', $row->status_event_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/status/event_lelang/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/status/event_lelang/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusEventLelangRequest $statusEventLelangRequest)
    {
        $count = StatusEventLelang::count();
        $statusEventLelang = StatusEventLelang::create($this->statusEventLelangData($count + 1));

        return redirect('/konfigurasi/status/event_lelang/' . $statusEventLelang->status_event_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Event Lelang telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusEventLelang $statusEventLelang)
    {
        return view('konfigurasi/status/event_lelang/show', compact('statusEventLelang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusEventLelang $statusEventLelang)
    {
        return view('konfigurasi/status/event_lelang/edit', compact('statusEventLelang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusEventLelangRequest $statusEventLelangRequest, StatusEventLelang $statusEventLelang)
    {
        $statusEventLelang->update($this->statusEventLelangData($statusEventLelang->urutan));

        return redirect('/konfigurasi/status/event_lelang/' . $statusEventLelang->status_event_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Event Lelang telah diupdate.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusEventLelang $statusEventLelang)
    {
        $statusEventLelang->delete();

        return redirect('/konfigurasi/status/event_lelang')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Event Lelang telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function statusEventLelangData($urutan)
    {
        return [
            'nama_status' => request('nama_status'),
            'is_aktif' => request('is_aktif') == 'true' ? true : false,
            'keterangan' => request('keterangan'),
            'icon' => 'th',
            'urutan' => $urutan
        ];
    }
}
