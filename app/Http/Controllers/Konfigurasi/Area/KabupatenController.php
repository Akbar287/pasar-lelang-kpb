<?php

namespace App\Http\Controllers\Konfigurasi\Area;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Provinsi $provinsi)
    {
        if ($request->ajax()) {
            $data = $provinsi->kabupaten()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kecamatan', function ($row) {
                    $actionBtn = $row->kecamatan()->count();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.area.provinsi.kabupaten.show', [$row->provinsi()->first()->provinsi_id, $row->kabupaten_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi/area/kabupaten/index', compact('provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Provinsi $provinsi)
    {
        return view('konfigurasi/area/kabupaten/create', compact('provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Provinsi $provinsi)
    {
        $request->validate([
            'nama_kabupaten' => ['required'],
        ]);

        $kabupaten = $provinsi->kabupaten()->create($this->kabupatenData());

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kabupaten telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi, Kabupaten $kabupaten)
    {
        return view('konfigurasi/area/kabupaten/show', compact('provinsi', 'kabupaten'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinsi $provinsi, Kabupaten $kabupaten)
    {
        return view('konfigurasi/area/kabupaten/edit', compact('provinsi', 'kabupaten'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provinsi $provinsi, Kabupaten $kabupaten)
    {
        $request->validate([
            'nama_kabupaten' => ['required'],
        ]);

        $kabupaten->update($this->kabupatenData());

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten/' . $kabupaten->kabupaten_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kabupaten telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinsi $provinsi, Kabupaten $kabupaten)
    {
        $kabupaten->delete();

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id . '/kabupaten')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kabupaten telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function kabupatenData()
    {
        return [
            'nama_kabupaten' => request('nama_kabupaten')
        ];
    }

    public function api_kabupaten(Request $request)
    {
        // $kabupaten = Kabupaten::get();
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = $request->has('provinsiId') ? Kabupaten::where('provinsi_id', $request->get('provinsiId'))->count() : Kabupaten::count();

        $page_count = ceil($total / $size);

        $data = $request->has('provinsiId')
            ? DB::Table('kabupaten')
            ->where('provinsi_id', $request->get('provinsiId'))
            ->orderBy('nama_kabupaten', 'asc')
            ->forPage($page, $size)
            ->get()
            : DB::Table('kabupaten')
            ->orderBy('nama_kabupaten', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'status' => 'success',
                'message' => 'Kabupaten has been catched'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => 'success',
                'message' => 'Kabupaten has been catched'
            ], 200);
        }
    }
}
