<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use App\Models\AreaMember;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AreaProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Auth::user()->informasi_akun()->first()->area_member()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_provinsi', function ($row) {
                    return $row->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->nama_provinsi;
                })
                ->addColumn('nama_kabupaten', function ($row) {
                    return $row->desa()->first()->kecamatan()->first()->kabupaten()->first()->nama_kabupaten;
                })
                ->addColumn('nama_kecamatan', function ($row) {
                    return $row->desa()->first()->kecamatan()->first()->nama_kecamatan;
                })
                ->addColumn('nama_desa', function ($row) {
                    return $row->desa()->first()->nama_desa;
                })
                ->addColumn('alamat', function ($row) {
                    return $row->alamat;
                })
                ->addColumn('kode_pos', function ($row) {
                    return $row->kode_pos;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('home.profil.area.show', $row->area_member_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('auth/area/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = Provinsi::select('provinsi_id')->addSelect('nama_provinsi')->get();
        return view('auth/area/create', compact('provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'desa_id' => ['required'],
            'kode_pos' => ['required'],
            'alamat' => ['required'],
        ]);

        $areaMember = Auth::user()->informasi_akun()->first()->area_member()->create($this->areaMemberData());

        return redirect('/profil/area/' . $areaMember->area_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Area Profil telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaMember $areaMember)
    {
        return view('auth/area/show', compact('areaMember'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaMember $areaMember)
    {
        $alamat = [
            'provinsi' => Provinsi::get(),
            'kabupaten' => $areaMember->desa()->first()->kecamatan()->first()->kabupaten()->first()->provinsi()->first()->kabupaten()->get(),
            'kecamatan' => $areaMember->desa()->first()->kecamatan()->first()->kabupaten()->first()->kecamatan()->get(),
            'desa' => $areaMember->desa()->first()->kecamatan()->first()->desa()->get()
        ];

        return view('auth/area/edit', compact('areaMember', 'alamat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaMember $areaMember)
    {
        $request->validate([
            'desa_id' => ['required'],
            'kode_pos' => ['required'],
            'alamat' => ['required'],
        ]);

        $areaMember->update($this->areaMemberData('update'));

        return redirect('/profil/area/' . $areaMember->area_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Area Profil telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaMember $areaMember)
    {
        $areaMember->delete();

        return redirect('/profil/area')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Area Profil telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function areaMemberData($type = null)
    {
        return $type == 'update' ? [
            'desa_id' => request('desa_id'),
            'kode_pos' => request('kode_pos'),
            'alamat' => request('alamat')
        ] :  [
            'desa_id' => request('desa_id'),
            'kode_pos' => request('kode_pos'),
            'alamat' => request('alamat'),
            'alamat_ke' => $this->cekAlamatKe()
        ];
    }

    public function cekAlamatKe()
    {
        return Auth::user()->informasi_akun()->first()->area_member()->count() + 1;
    }

    public function api(Request $request)
    {
        $request->validate([
            'jenis' => ['required']
        ]);

        if ($request->jenis == 'get-kabupaten') {
            $kabupaten = Provinsi::where('provinsi_id', $request->provinsi_id)->first()->kabupaten()->select('kabupaten_id')->addSelect('nama_kabupaten')->get();

            return response()->json([
                'data' => [
                    'kabupaten' => $kabupaten
                ],
                'status' => 'success',
                'message' => 'Kabupaten has been catched'
            ], 200);
            exit;
        }
        if ($request->jenis == 'get-kecamatan') {
            $kecamatan = Kabupaten::where('kabupaten_id', $request->kabupaten_id)->first()->kecamatan()->select('kecamatan_id')->addSelect('nama_kecamatan')->get();

            return response()->json([
                'data' => [
                    'kecamatan' => $kecamatan
                ],
                'status' => 'success',
                'message' => 'Kecamatan has been catched'
            ], 200);
            exit;
        }
        if ($request->jenis == 'get-desa') {
            $desa = Kecamatan::where('kecamatan_id', $request->kecamatan_id)->first()->desa()->select('desa_id')->addSelect('nama_desa')->get();

            return response()->json([
                'data' => [
                    'desa' => $desa
                ],
                'status' => 'success',
                'message' => 'Desa has been catched'
            ], 200);
            exit;
        }
    }
}
