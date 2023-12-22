<?php

namespace App\Http\Controllers\Konfigurasi\Jenis;

use App\Http\Controllers\Controller;
use App\Http\Requests\JenisInisiasiRequest;
use App\Models\JenisInisiasi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JenisInisiasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JenisInisiasi::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.jenis.inisiasi.show', $row->jenis_inisiasi_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/jenis/inisiasi/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/jenis/inisiasi/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisInisiasiRequest $jenisInisiasiRequest)
    {
        $jenisInisiasi = JenisInisiasi::create($this->jenisInisiasiData());

        return redirect('/konfigurasi/jenis/inisiasi/' . $jenisInisiasi->jenis_inisiasi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Inisiasi telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisInisiasi $jenisInisiasi)
    {
        return view('konfigurasi/jenis/inisiasi/show', compact('jenisInisiasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisInisiasi $jenisInisiasi)
    {
        return view('konfigurasi/jenis/inisiasi/edit', compact('jenisInisiasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisInisiasiRequest $jenisInisiasiRequest, JenisInisiasi $jenisInisiasi)
    {
        $jenisInisiasi->update($this->jenisInisiasiData());

        return redirect('/konfigurasi/jenis/inisiasi/' . $jenisInisiasi->jenis_inisiasi_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Inisiasi telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisInisiasi $jenisInisiasi)
    {
        $jenisInisiasi->delete();

        return redirect('/konfigurasi/jenis/inisiasi')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Inisiasi telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function jenisInisiasiData()
    {
        return [
            'nama_inisiasi' => request('nama_inisiasi'),
            'keterangan' => request('keterangan'),
            'is_aktif' => request('is_aktif'),
        ];
    }

    public function api_jenis_inisiasi(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = JenisInisiasi::count();

        $page_count = ceil($total / $size);

        $data = DB::Table('jenis_inisiasi')
            ->orderBy('nama_inisiasi', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);
            return response()->json([
                'data' => $paginator,
                'message' => 'Jenis Inisiasi has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'Jenis Inisiasi has been catched',
                'status' => 'success'
            ], 200);
        }
    }
}
