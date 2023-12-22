<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Member;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($row) {
                    $actionBtn = $row->member()->first()->ktp()->first()->nik;
                    return $actionBtn;
                })
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Non-Aktif</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.admin.show', $row->admin_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/admin/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $temp = [];
            foreach (Admin::get() as $a) {
                $temp[] = $a->member()->first()->member_id;
            }
            $data = StatusMember::where('nama_status', 'Aktif')->first()->member()->whereNotIn('member_id', $temp)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($row) {
                    return $row->ktp()->first()->nik;
                })
                ->addColumn('nama', function ($row) {
                    return $row->ktp()->first()->nama;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<form action="' . route('konfigurasi.admin.accepted', $row->member_id) . '" method="post">' . csrf_field() . method_field('put') . '<button type="submit" class="btn btn-success" onClick="return confirm(`Apakah Anda yakin menjadikan ini admin ?`)"><i class="fas fa-pen"></i>Jadikan Admin</button></form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi/admin/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function accepted(Member $member)
    {
        $admin = $member->admin()->create([
            'member_id' => $member->member_id,
            'is_aktif' => true
        ]);

        return redirect('/konfigurasi/admin/' . $admin->admin_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Admin telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function aktif(Admin $admin)
    {
        $admin->update([
            'is_aktif' => true
        ]);

        return redirect('/konfigurasi/admin/' . $admin->admin_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Admin telah diaktifkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function nonaktif(Admin $admin)
    {
        $admin->update([
            'is_aktif' => false
        ]);

        return redirect('/konfigurasi/admin/' . $admin->admin_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Admin telah dinon-aktifkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return view('konfigurasi/admin/show', compact('admin'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect('/konfigurasi/admin')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Admin telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
