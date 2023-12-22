<?php

namespace App\Http\Controllers\Laporan\LaporanTransaksiLelang;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Member;
use App\Models\PembayaranLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanTransaksiLelangController extends Controller
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
        return view('laporan/transaksi_lelang/transaksi_lelang', compact('date'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tanggal_awal' => ['required'],
            'tanggal_akhir' => ['required'],
        ]);

        if (request('tanggal_awal') > request('tanggal_akhir')) {
            $temp = ['awal' => request('tanggal_akhir'), 'akhir' => request('tanggal_awal')];
        } else {
            $temp = ['awal' => request('tanggal_awal'), 'akhir' => request('tanggal_akhir')];
        }

        $date = [
            'awal' => Carbon::createFromFormat('Y-m-d', $temp['awal'])->format('d F Y'),
            'akhir' => Carbon::createFromFormat('Y-m-d', $temp['akhir'])->format('d F Y'),
        ];

        $member = null;

        $data = null;
        if (is_null($request->member_id)) {
            $data = PembayaranLelang::whereBetween('pembayaran_lelang.tanggal_pembayaran', [$temp['awal'], $temp['akhir']])->get();
        } else {
            $member = Member::where('member_id', $request->member_id)->first();
            $data = PembayaranLelang::join('approval_lelang', 'approval_lelang.approval_lelang_id', 'pembayaran_lelang.approval_lelang_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'approval_lelang.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->whereBetween('pembayaran_lelang.tanggal_pembayaran', [$temp['awal'], $temp['akhir']])->where('member.member_id', $request->member_id)->first();
        }

        return Helper::print_transaksi_lelang($member, $data, $date);
    }
}
