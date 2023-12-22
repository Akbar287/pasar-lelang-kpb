<?php

namespace App\Http\Controllers\Konfigurasi\Area;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Provinsi::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kabupaten', function ($row) {
                    $actionBtn = $row->kabupaten()->count();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.area.provinsi.show', $row->provinsi_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi/area/provinsi/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/area/provinsi/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_provinsi' => ['required']
        ]);

        $provinsi = new Provinsi();
        $provinsi->nama_provinsi = request('nama_provinsi');
        $provinsi->save();

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Provinsi telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi)
    {
        return view('konfigurasi/area/provinsi/show', compact('provinsi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinsi $provinsi)
    {
        return view('konfigurasi/area/provinsi/edit', compact('provinsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provinsi $provinsi)
    {
        $request->validate([
            'nama_provinsi' => ['required']
        ]);

        $provinsi->update($this->provinsiData());

        return redirect('/konfigurasi/area/provinsi/' . $provinsi->provinsi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Provinsi telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinsi $provinsi)
    {
        $provinsi->delete();

        return redirect('/konfigurasi/area/provinsi')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Provinsi telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function provinsiData()
    {
        return [
            'nama_provinsi' => request('nama_provinsi')
        ];
    }

    public function api_provinsi(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = Provinsi::count();

        $page_count = ceil($total / $size);

        $data = DB::Table('provinsi')
            ->orderBy('nama_provinsi', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'status' => 'success',
                'message' => 'Provinsi has been catched'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => 'success',
                'message' => 'Provinsi has been catched'
            ], 200);
        }
    }
}
