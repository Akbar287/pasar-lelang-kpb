<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use App\Models\Member;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Laporan Jaminan",
                "icon" => "th",
                "url" => route('laporan.jaminan'),
                "color" => "primary"
            ],
            [
                "nama" => "Laporan Transaksi Lelang",
                "icon" => "filter",
                "url" => route('laporan.transaksi_lelang'),
                "color" => "warning"
            ],
            [
                "nama" => "Laporan Transaksi Bank",
                "icon" => "tint",
                "url" => route('laporan.transaksi_bank'),
                "color" => "info"
            ],
            [
                "nama" => "Laporan Daftar Anggota",
                "icon" => "tint",
                "url" => route('laporan.daftar_anggota'),
                "color" => "danger"
            ],
            [
                "nama" => "Laporan Event Lelang",
                "icon" => "tint",
                "url" => route('laporan.event_lelang'),
                "color" => "success"
            ],
            [
                "nama" => "Laporan Lelang",
                "icon" => "tint",
                "url" => route('laporan.lelang'),
                "color" => "primary"
            ],
        ];
        return view('laporan/index', compact('allMenu'));
    }

    public function api(Request $request)
    {
        if ($request->jenis == 'member') {
            $member = Member::select('member.member_id')->addSelect('ktp.nama')->addSelect('ktp.nik')->addSelect('ktp.ktp_id')->join('ktp', 'ktp.member_id', 'member.member_id')->where('ktp.nama', 'LIKE', '%' . $request->q . '%')->orWhere('ktp.nik', 'LIKE', '%' . $request->q . '%')->orWhere('ktp.nama', 'LIKE', $request->q . '%')->orWhere('ktp.nama', 'LIKE', '%' . $request->q)->limit(25)->get();

            return response()->json([
                'data' => $member,
                'message' => 'Data Member with name ' . $request->q . ' has been catched',
                'status' => 'success'
            ], 200);
        } else if ($request->jenis == 'lembaga') {
            $member = Lembaga::select('lembaga.lembaga_id')->addSelect('lembaga.nama_lembaga')->where('lembaga.nama_lembaga', 'LIKE', '%' . $request->q . '%')->orWhere('lembaga.nama_lembaga', 'LIKE', $request->q . '%')->orWhere('lembaga.nama_lembaga', 'LIKE', '%' . $request->q)->limit(25)->get();

            return response()->json([
                'data' => $member,
                'message' => 'Data Lembaga with name ' . $request->q . ' has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'no data to catched',
                'status' => 'failed'
            ], 404);
        }
    }
}
