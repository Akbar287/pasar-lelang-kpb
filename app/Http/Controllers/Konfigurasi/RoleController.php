<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_aktif', function ($row) {
                    $actionBtn = $row->is_aktif ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak</div>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.role.show', $row->role_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/role/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/role/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $roleRequest)
    {
        $role = Role::create($this->roleData());

        return redirect('/konfigurasi/role/' . $role->role_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Role telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('konfigurasi/role/show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('konfigurasi/role/edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $roleRequest, Role $role)
    {
        $role->update($this->roleData());

        return redirect('/konfigurasi/role/' . $role->role_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Role telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect('/konfigurasi/role')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Role telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function roleData()
    {
        return [
            'nama_role' => request('nama_role'),
            'keterangan' => request('keterangan'),
            'is_aktif' => request('is_aktif') == 'true' ? true : false,
        ];
    }
}
