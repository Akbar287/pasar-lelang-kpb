<?php

namespace App\Http\Controllers\Konfigurasi\Jenis;

use App\Http\Controllers\Controller;
use App\Http\Requests\JenisPerdaganganRequest;
use App\Models\JenisPerdagangan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JenisPerdaganganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JenisPerdagangan::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.jenis.perdagangan.show', $row->jenis_perdagangan_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/jenis/perdagangan/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/jenis/perdagangan/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisPerdaganganRequest $jenisPerdaganganRequest)
    {
        $jenisPerdagangan = JenisPerdagangan::create($this->jenisPerdaganganData());

        return redirect('/konfigurasi/jenis/perdagangan/' . $jenisPerdagangan->jenis_perdagangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Perdagangan telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPerdagangan $jenisPerdagangan)
    {
        return view('konfigurasi/jenis/perdagangan/show', compact('jenisPerdagangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPerdagangan $jenisPerdagangan)
    {
        return view('konfigurasi/jenis/perdagangan/edit', compact('jenisPerdagangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisPerdaganganRequest $jenisPerdaganganRequest, JenisPerdagangan $jenisPerdagangan)
    {
        $jenisPerdagangan->update($this->jenisPerdaganganData());

        return redirect('/konfigurasi/jenis/perdagangan/' . $jenisPerdagangan->jenis_perdagangan_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Perdagangan telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPerdagangan $jenisPerdagangan)
    {
        $jenisPerdagangan->delete();

        return redirect('/konfigurasi/jenis/perdagangan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Jenis Perdagangan telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function jenisPerdaganganData()
    {
        return [
            'nama_perdagangan' => request('nama_perdagangan'),
            'keterangan' => request('keterangan'),
            'is_aktif' => request('is_aktif'),
        ];
    }

    public function api_jenis_perdagangan(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = JenisPerdagangan::count();

        $page_count = ceil($total / $size);

        $data = DB::Table('jenis_perdagangan')
            ->orderBy('nama_perdagangan', 'asc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);
            return response()->json([
                'data' => $paginator,
                'message' => 'data perdagangan has been created',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'data perdagangan has been created',
                'status' => 'success'
            ], 200);
        }
    }
}
