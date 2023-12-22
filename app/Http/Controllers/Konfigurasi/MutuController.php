<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\MutuRequest;
use App\Models\Mutu;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Mutu::orderBy('nama_mutu', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.mutu.show', $row->mutu_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/mutu/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/mutu/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MutuRequest $mutuRequest)
    {
        $mutu = Mutu::create($this->mutuData());

        return redirect('/konfigurasi/mutu/' . $mutu->mutu_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Mutu telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mutu $mutu)
    {
        return view('konfigurasi/mutu/show', compact('mutu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mutu $mutu)
    {
        return view('konfigurasi/mutu/edit', compact('mutu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MutuRequest $mutuRequest, Mutu $mutu)
    {
        $mutu->update($this->mutuData());

        return redirect('/konfigurasi/mutu/' . $mutu->mutu_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Mutu telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutu $mutu)
    {
        $mutu->delete();

        return redirect('/konfigurasi/mutu')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Mutu telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function mutuData()
    {
        return [
            'nama_mutu' => request('nama_mutu'),
            'keterangan' => request('keterangan'),
            'is_aktif' => request('is_aktif')
        ];
    }

    public function api_get_mutu(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = Mutu::count();

        $page_count = ceil($total / $size);

        $data = DB::Table('mutu')
            ->orderBy('nama_mutu', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'message' => 'mutu has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'mutu has been catched',
                'status' => 'success'
            ], 200);
        }
    }
}
