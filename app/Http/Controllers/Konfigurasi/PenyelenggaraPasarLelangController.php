<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\PenyelenggaraPasarLelang;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PenyelenggaraPasarLelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PenyelenggaraPasarLelang $penyelenggaraPasarLelang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenyelenggaraPasarLelang $penyelenggaraPasarLelang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenyelenggaraPasarLelang $penyelenggaraPasarLelang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenyelenggaraPasarLelang $penyelenggaraPasarLelang)
    {
        //
    }

    public function api_penyelenggara(Request $request)
    {
        $data = PenyelenggaraPasarLelang::select('penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id')->addSelect('ktp.nama')->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')->join('member', 'member.member_id', 'admin.member_id')->join('ktp', 'ktp.member_id', 'member.member_id')->where('admin.is_aktif', true)->get();

        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $total = PenyelenggaraPasarLelang::count();

        $page_count = ceil($total / $size);

        $data = DB::Table('penyelenggara_pasar_lelang')->select('penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id')->addSelect('ktp.nama')->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')->join('member', 'member.member_id', 'admin.member_id')->join('ktp', 'ktp.member_id', 'member.member_id')->where('admin.is_aktif', true)
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'message' => 'penyelenggara pasar lelang has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'penyelenggara pasar lelang has been catched',
                'status' => 'success'
            ], 200);
        }
    }
}
