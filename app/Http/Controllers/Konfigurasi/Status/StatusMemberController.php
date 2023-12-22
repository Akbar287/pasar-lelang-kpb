<?php

namespace App\Http\Controllers\Konfigurasi\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusMemberRequest;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StatusMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusMember::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('konfigurasi.status.member.show', $row->status_member_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_aktif'])
                ->make(true);
        }
        return view('konfigurasi/status/member/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konfigurasi/status/member/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusMemberRequest $statusMemberRequest)
    {
        $statusMember = StatusMember::create($this->statusMemberData());

        return redirect('/konfigurasi/status/member/' . $statusMember->status_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Member telah ditambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusMember $statusMember)
    {
        return view('konfigurasi/status/member/show', compact('statusMember'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusMember $statusMember)
    {
        return view('konfigurasi/status/member/edit', compact('statusMember'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusMemberRequest $statusMemberRequest, StatusMember $statusMember)
    {
        $statusMember->update($this->statusMemberData());

        return redirect('/konfigurasi/status/member/' . $statusMember->status_member_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Member telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusMember $statusMember)
    {
        $statusMember->delete();

        return redirect('/konfigurasi/status/member')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Member telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function statusMemberData()
    {
        return [
            'nama_status' => request('nama_status'),
            'keterangan' => request('keterangan'),
        ];
    }
}
