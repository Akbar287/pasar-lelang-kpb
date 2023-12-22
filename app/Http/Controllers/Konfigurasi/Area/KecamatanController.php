<?php

namespace App\Http\Controllers\Konfigurasi\Area;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Provinsi $provinsi, Kabupaten $kabupaten)
    {
        if ($request->ajax()) {
            $data = $kabupaten->kecamatan()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('desa', function ($row) {
                    $actionBtn = $row->desa()->count();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.area.provinsi.kabupaten.kecamatan.show', [$row->kabupaten()->first()->provinsi()->first()->provinsi_id, $row->kabupaten()->first()->kabupaten_id, $row->kecamatan_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi/area/kecamatan/index', compact('provinsi', 'kabupaten'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Provinsi $provinsi, Kabupaten $kabupaten)
    {
        return view('konfigurasi/area/kecamatan/create', compact('provinsi', 'kabupaten'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Provinsi $provinsi, Kabupaten $kabupaten)
    {
        $request->validate([
            'nama_kecamatan' => ['required']
        ]);

        $kecamatan = $kabupaten->kecamatan()->create($this->kecamatanData());

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id . '/kecamatan/' . $kecamatan->kecamatan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kecamatan telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan)
    {
        return view('konfigurasi/area/kecamatan/show', compact('provinsi', 'kabupaten', 'kecamatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan)
    {
        return view('konfigurasi/area/kecamatan/edit', compact('provinsi', 'kabupaten', 'kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama_kecamatan' => ['required']
        ]);

        $kecamatan->update($this->kecamatanData());

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id . '/kecamatan/' . $kecamatan->kecamatan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kecamatan telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinsi $provinsi, Kabupaten $kabupaten, Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id . '/kecamatan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kecamatan telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function kecamatanData()
    {
        return [
            'nama_kecamatan' => request('nama_kecamatan')
        ];
    }

    public function api_kecamatan(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = $request->has('kabupatenId') ? Kecamatan::where('kabupaten_id', $request->get('kabupatenId'))->count() : Kecamatan::count();

        $page_count = ceil($total / $size);

        $data = $request->has('kabupatenId')
            ? DB::Table('kecamatan')
            ->where('kabupaten_id', $request->get('kabupatenId'))
            ->orderBy('nama_kecamatan', 'asc')
            ->forPage($page, $size)
            ->get()
            : DB::Table('kecamatan')
            ->orderBy('nama_kecamatan', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'status' => 'success',
                'message' => 'Kecamatan has been catched'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => 'success',
                'message' => 'Kecamatan has been catched'
            ], 200);
        }
    }
}
