<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfflineProfileRequest;
use App\Models\OfflineProfile;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OfflineProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OfflineProfile::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_lengkap', function ($row) {
                    $actionBtn = $row->nama_profile;
                    return $actionBtn;
                })
                ->addColumn('is_open', function ($row) {
                    $actionBtn = $row->is_open ? '<div class="badge badge-success">Terbuka</div>' : '<div class="badge badge-danger">Tertutup</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.profile.show', $row->offline_profile_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_open'])
                ->make(true);
        }
        return view('lelang_offline/profile/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lelang_offline/profile/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfflineProfileRequest $offlineProfileRequest)
    {
        $profile = OfflineProfile::create($this->offlineProfileData(true));

        return redirect('/offline/profile/' . $profile->offline_profile_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Profil telah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(OfflineProfile $profile)
    {
        return view('lelang_offline/profile/show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfflineProfile $profile)
    {
        return view('lelang_offline/profile/edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OfflineProfileRequest $offlineProfileRequest, OfflineProfile $profile)
    {
        $profile->update($this->offlineProfileData(false));

        return redirect('/offline/profile/' . $profile->offline_profile_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Profil telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfflineProfile $profile)
    {
        $profile->delete();

        return redirect('/offline/profile')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Profil telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
    public function offlineProfileData($cekTanggal)
    {
        return $cekTanggal ? [
            'registrasi_id' => request('registrasi_id'),
            'nama_profile' => request('nama_profile'),
            'is_open' => request('is_open'),
            'tanggal_register' => date('Y-m-d'),
            'keterangan' => request('keterangan'),
        ] : [
            'registrasi_id' => request('registrasi_id'),
            'nama_profile' => request('nama_profile'),
            'is_open' => request('is_open'),
            'keterangan' => request('keterangan'),
        ];
    }
}
