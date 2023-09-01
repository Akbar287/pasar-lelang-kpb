<?php

namespace App\Http\Controllers\MasterData\Lainnya;

use App\Http\Controllers\Controller;
use App\Http\Requests\KomoditasRequest;
use App\Models\JenisKomoditas;
use App\Models\Komoditas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KomoditasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Komoditas::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('inisiasi', function ($row) {
                    return $row->inisiasi ? 'Aktif' : "Tidak";
                })
                ->addColumn('kadaluarsa', function ($row) {
                    return $row->kadaluarsa ? 'Aktif' : "Tidak";
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.lain.komoditas.show', $row->komoditas_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/master_lainnya/komoditas/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisKomoditas = JenisKomoditas::get();
        return view('master_data/master_lainnya/komoditas/create', compact('jenisKomoditas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KomoditasRequest $request)
    {
        $jenisKomoditas = JenisKomoditas::find($request->jenis_komoditas_id);

        $komoditas = $jenisKomoditas->komoditas()->create($this->komoditasData());

        return redirect('/master/lain/komoditas/' . $komoditas->komoditas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Komoditas telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Komoditas $komoditas)
    {
        return view('master_data/master_lainnya/komoditas/show', compact('komoditas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Komoditas $komoditas)
    {
        $jenisKomoditas = JenisKomoditas::get();
        return view('master_data/master_lainnya/komoditas/edit', compact('jenisKomoditas', 'komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KomoditasRequest $request, Komoditas $komoditas)
    {
        $komoditas->update($this->komoditasData());

        return redirect('/master/lain/komoditas/' . $komoditas->komoditas_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Komoditas telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komoditas $komoditas)
    {
        $komoditas->delete();

        return redirect('/master/lain/komoditas')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Komoditas telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function komoditasData()
    {
        return [
            'nama_komoditas' => request('nama_komoditas'),
            'satuan_ukuran' => request('satuan_ukuran'),
            'inisiasi' => request('inisiasi') ?? false,
            'kadaluarsa' => request('kadaluarsa') ?? false,
        ];
    }

    public function check_satuan(Request $request)
    {
        $request->validate([
            'komoditas_id' => ['required']
        ]);

        $komoditas = Komoditas::where('komoditas_id', $request->komoditas_id)->first();
        return response()->json([
            'data' => $komoditas,
            'message' => 'data komoditas has been catched',
            'status' => 'success'
        ], 200);
    }
}
