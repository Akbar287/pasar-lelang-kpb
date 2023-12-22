<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorPasarLelangRequest;
use App\Models\InformasiAkun;
use App\Models\OfflineProfile;
use App\Models\OperatorPasarLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class OperatorPasarLelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OperatorPasarLelang::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Terbuka</div>' : '<div class="badge badge-danger">Tertutup</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.operator.show', $row->operator_pasar_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('lelang_offline/operator/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offlineProfile = OfflineProfile::where('is_open', true)->get();
        return view('lelang_offline/operator/create', compact('offlineProfile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperatorPasarLelangRequest $operatorPasarLelangRequest)
    {
        $offlineProfile = OfflineProfile::where('offline_profile_id', $operatorPasarLelangRequest->offline_profile_id)->first();
        $informasi_akun = InformasiAkun::create([
            'email' => $offlineProfile->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->informasi_akun()->first()->email,
            'no_hp' => $offlineProfile->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->informasi_akun()->first()->no_hp,
            'no_wa' => $offlineProfile->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->informasi_akun()->first()->no_wa,
            'no_fax' => $offlineProfile->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->informasi_akun()->first()->no_fax,
            'avatar' => $offlineProfile->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->informasi_akun()->first()->avatar,
        ]);
        $userlogin = $informasi_akun->userlogin()->create([
            'username' => $operatorPasarLelangRequest->user_id,
            'password' => Hash::make($operatorPasarLelangRequest->password),
            'is_aktif' => true,
            'access_token' => null,
            'access' => null,
            'last_login' => null
        ]);

        $operator = $offlineProfile->operator_pasar_lelang()->create($this->operatorPasarLelang(true, $userlogin));

        return redirect('/offline/operator/' . $operator->operator_pasar_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Operator telah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(OperatorPasarLelang $operator)
    {
        return view('lelang_offline/operator/show', compact('operator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperatorPasarLelang $operator)
    {
        $offlineProfile = OfflineProfile::where('is_open', true)->get();
        return view('lelang_offline/operator/edit', compact('operator', 'offlineProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OperatorPasarLelangRequest $operatorPasarLelangRequest, OperatorPasarLelang $operator)
    {
        $operator->update($this->operatorPasarLelang(false, $operator->userlogin_id));

        return redirect('/offline/operator/' . $operator->operator_pasar_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Operator telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperatorPasarLelang $operator)
    {
        if (!is_null($operator->userlogin()->first())) {
            if (!is_null($operator->userlogin()->first()->informasi_akun())) {
                $operator->userlogin()->first()->informasi_akun()->delete();
            }
            $operator->userlogin()->first()->delete();
        }
        $operator->delete();

        return redirect('/offline/operator')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Operator telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function operatorPasarLelang($cek, $userlogin = null)
    {
        return $cek ? [
            'userlogin_id' => $userlogin->userlogin_id,
            'user_id' => request('user_id'),
            'nama_lengkap' => request('nama_lengkap'),
            'password' => Hash::make(request('password')),
            'is_aktif' => request('is_aktif'),
        ] : [
            'userlogin_id' => $userlogin->userlogin_id,
            'offline_profile_id' => request('offline_profile_id'),
            'user_id' => request('user_id'),
            'password' => Hash::make(request('password')),
            'nama_lengkap' => request('nama_lengkap'),
            'is_aktif' => request('is_aktif'),

        ];
    }
}
