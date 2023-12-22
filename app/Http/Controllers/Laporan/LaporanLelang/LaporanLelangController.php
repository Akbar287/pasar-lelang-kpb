<?php

namespace App\Http\Controllers\Laporan\LaporanLelang;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\LelangSesiOnline;
use App\Models\MasterSesiLelang;
use App\Models\PenyelenggaraPasarLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $date = [
            'awal' => Carbon::now()->day(-7)->format('Y-m-d'),
            'akhir' => Carbon::now()->format('Y-m-d')
        ];
        $ppl = PenyelenggaraPasarLelang::get();
        return view('laporan/lelang/lelang', compact('date', 'ppl'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tanggal' => ['required'],
            'sesi' => ['required'],
            'penyelenggara_pasar_lelang_id' => ['required'],
        ]);

        if ($request->sesi == 'semua') {
            $sesi = MasterSesiLelang::get()->toArray();
            for ($i = 0; $i < count($sesi); $i++) {
                $sesi[$i]['data'] = LelangSesiOnline::join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')->leftJoin('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')->leftJoin('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->where('master_sesi_lelang.penyelenggara_pasar_lelang_id', $request->penyelenggara_pasar_lelang_id)->where('lelang_sesi_online.tanggal', $request->tanggal)->where('master_sesi_lelang.sesi', $sesi[$i]['sesi'])->get()->toArray();
            }
        } else {
            $sesi = MasterSesiLelang::where('master_sesi_lelang.sesi', $request->sesi)->get()->toArray();
            for ($i = 0; $i < count($sesi); $i++) {
                $sesi[$i]['data'] = LelangSesiOnline::join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')->leftJoin('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')->leftJoin('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->where('master_sesi_lelang.penyelenggara_pasar_lelang_id', $request->penyelenggara_pasar_lelang_id)->where('lelang_sesi_online.tanggal', $request->tanggal)->where('master_sesi_lelang.sesi', $sesi[$i]['sesi'])->get()->toArray();
            }
        }

        return Helper::print_lelang($sesi, $request->tanggal);
    }
}
