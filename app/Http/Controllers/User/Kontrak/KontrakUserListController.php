<?php

namespace App\Http\Controllers\User\Kontrak;

use App\Http\Controllers\Controller;
use App\Models\Kontrak;
use App\Models\StatusKontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class KontrakUserListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = StatusKontrak::select('status_kontrak_id')->whereNot('nama_status', 'Pendaftar Baru')->get();
            $data = Auth::user()->informasi_akun()->first()->kontrak()->whereIn('status_kontrak_id', $status)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penyelenggara', function ($row) {
                    return $row->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                })
                ->addColumn('komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('jenis_perdagangan', function ($row) {
                    $actionBtn = $row->jenis_perdagangan()->first()->nama_perdagangan;
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status_kontrak()->first()->nama_status == 'Aktif' ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak Aktif</div>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('kontrak.list.show', $row->kontrak_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('user/kontrak_pasar_lelang/list/index');
    }

    public function show(Kontrak $kontrak)
    {
        return view('user/kontrak_pasar_lelang/list/show', compact('kontrak'));
    }
}
