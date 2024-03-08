<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Role;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::where('nama_role', 'ROLE_DINAS')->first()->member()->select('ktp.nik')->addSelect('member.member_id')->addSelect('ktp.nama')->join('ktp', 'member.member_id', 'ktp.member_id')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($row) {
                    $actionBtn = $row->nik;
                    return $actionBtn;
                })
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->nama;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.dinas.show', $row->member_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi/dinas/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $temp = [];
            foreach (Role::where('nama_role', 'ROLE_DINAS')->first()->member()->get() as $a) {
                $temp[] = $a->member_id;
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
                    $actionBtn = '<form action="' . route('konfigurasi.dinas.accepted', $row->member_id) . '" method="post">' . csrf_field() . method_field('put') . '<button type="submit" class="btn btn-success" onClick="return confirm(`Apakah Anda yakin menjadikan ini akun Dinas ?`)"><i class="fas fa-pen"></i>Jadikan Dinas</button></form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('konfigurasi/dinas/create');
    }
    public function accepted(Member $member)
    {
        $role = Role::where('nama_role', 'ROLE_DINAS')->first();
        if (DB::table('role_member')->where('member_id', $member->member_id)->count() > 0) {
            DB::table('role_member')->where('member_id', $member->member_id)->delete();
        }
        DB::table('role_member')->insert([
            'member_id' => $member->member_id,
            'role_id' => $role->role_id
        ]);

        return redirect('/konfigurasi/dinas/' . $member->member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Dinas telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('konfigurasi/dinas/show', compact('member'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        if ($member->role()->where('nama_role', 'ROLE_DINAS')->count() > 0) {
            $roleDinas = Role::where('nama_role', 'ROLE_DINAS')->first();

            if (DB::table('role_member')->where(['member_id' => $member->member_id, 'role_id' => $roleDinas->role_id])->count() > 0) {
                DB::table('role_member')->where(['member_id' => $member->member_id, 'role_id' => $roleDinas->role_id])->delete();
            }

            $rolePengguna = Role::where('nama_role', 'ROLE_PEMBELI')->first();
            DB::table('role_member')->insert([
                'member_id' => $member->member_id,
                'role_id' => $rolePengguna->role_id
            ]);
        }

        return redirect('/konfigurasi/dinas')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Dinas telah diturunkan menjadi role pengguna.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
