<?php

namespace App\Http\Controllers\Konfigurasi\Jenis;

use App\Http\Controllers\Controller;
use App\Http\Requests\JenisHargaRequest;
use App\Models\JenisHarga;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JenisHargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JenisHarga::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.jenis.harga.show', $row->jenis_harga_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/jenis/harga/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/jenis/harga/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisHargaRequest $jenisHargaRequest)
    {
        $jenisHarga = JenisHarga::create($this->jenisHargaData());

        return redirect('/konfigurasi/jenis/harga/' . $jenisHarga->jenis_harga_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Harga telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisHarga $jenisHarga)
    {
        return view('konfigurasi/jenis/harga/show', compact('jenisHarga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisHarga $jenisHarga)
    {
        return view('konfigurasi/jenis/harga/edit', compact('jenisHarga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisHargaRequest $jenisHargaRequest, JenisHarga $jenisHarga)
    {
        $jenisHarga->update($this->jenisHargaData());

        return redirect('/konfigurasi/jenis/harga/' . $jenisHarga->jenis_harga_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Harga telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisHarga $jenisHarga)
    {
        $jenisHarga->delete();

        return redirect('/konfigurasi/jenis/harga')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Harga telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function jenisHargaData()
    {
        return [
            'nama_jenis_harga' => request('nama_jenis_harga')
        ];
    }

    public function api_jenis_harga(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = JenisHarga::count();

        $page_count = ceil($total / $size);

        $data = DB::Table('jenis_harga')
            ->orderBy('nama_jenis_harga', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'message' => 'Jenis Harga has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'Jenis Harga has been catched',
                'status' => 'success'
            ], 200);
        }
    }
}
