<?php

namespace App\Http\Controllers\Laporan\LaporanDaftarAnggota;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Lembaga;
use App\Models\Member;
use App\Models\StatusMember;
use Illuminate\Http\Request;

class LaporanDaftarAnggotaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $status = StatusMember::get();
        return view('laporan/daftar_anggota/daftar_anggota', compact('status'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'chooser' => ['required']
        ]);

        if ($request->chooser == '1') {
            $request->validate([
                'member_id' => ['required']
            ]);
        }
        if ($request->chooser == '3') {
            $request->validate([
                'lembaga_id' => ['required']
            ]);
        }
        if ($request->chooser == '2' || $request->chooser == '4') {
            $request->validate([
                'status' => ['required']
            ]);
        }

        $member = null;
        $lembaga = null;
        $status = null;
        $filterStatus = null;
        $statusList = null;
        $statusCount = 0;

        if ($request->chooser == '1') {
            $member = is_null(request('member_id')) ? null : Member::where('member_id', request('member_id'))->first();
        }
        if ($request->chooser == '3') {
            $lembaga = is_null(request('lembaga_id')) ? null : Lembaga::where('lembaga_id', request('lembaga_id'))->first();
        }
        if ($request->chooser == '2' || $request->chooser == '4') {
            if (request('status') == 'semua' || $request->chooser == '2') {
                $status = (is_null(request('status')) ? 0 : request('status') == 'semua') ? 'semua' : StatusMember::where('status_member_id', request('status'))->first()->member()->get();
                $filterStatus = request('status') == 'semua' ? 'semua' : StatusMember::where('status_member_id', request('status'))->first();
                $statusList = StatusMember::get();
                $statusCount = Member::count();
            }
            if (request('status') == 'semua' || $request->chooser == '4') {
                $status = (is_null(request('status')) ? 0 : request('status') == 'semua') ? 'semua' : StatusMember::where('status_member_id', request('status'))->first()->lembaga()->get();
                $filterStatus = request('status') == 'semua' ? 'semua' : StatusMember::where('status_member_id', request('status'))->first();
                $statusList = StatusMember::get();
                $statusCount = Lembaga::count();
            }
        }

        return Helper::print_laporan_daftar_anggota(request('chooser'), $member, $lembaga, $status, is_null($filterStatus) ? 0 : (is_string($filterStatus) ? $filterStatus : $filterStatus->nama_status), $statusList, $statusCount);
    }
}
