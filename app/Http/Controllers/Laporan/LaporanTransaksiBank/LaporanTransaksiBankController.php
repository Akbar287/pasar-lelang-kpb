<?php

namespace App\Http\Controllers\Laporan\LaporanTransaksiBank;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\JenisTransaksi;
use App\Models\Keuangan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanTransaksiBankController extends Controller
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
        $jenisTransaksi = JenisTransaksi::get();
        return view('laporan/transaksi_bank/transaksi_bank', compact('date', 'jenisTransaksi'));
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

        $jenisTransaksi = JenisTransaksi::get();
        $member = null;

        $data = null;
        if (is_null($request->member_id) && is_null($request->jenis_transaksi_id)) {
            $data = Keuangan::whereBetween('keuangan.created_at', [$temp['awal'], $temp['akhir']])->get();
        } else if (is_null($request->member_id) && !is_null($request->jenis_transaksi_id)) {
            $data = JenisTransaksi::where($request->jenis_transaksi_id)->first()->keuangan()->whereBetween('keuangan.created_at', [$temp['awal'], $temp['akhir']])->get();
        } else if (!is_null($request->member_id) && is_null($request->jenis_transaksi_id)) {
            $member = Member::where('member_id', $request->member_id)->first();
            $data = Keuangan::join('rekening_bank', 'rekening_bank.rekening_bank_id', 'keuangan.rekening_bank_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'rekening_bank.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->whereBetween('keuangan.created_at', [$temp['awal'], $temp['akhir']])->where('member.member_id', $request->member_id)->get();
        } else {
            $member = Member::where('member_id', $request->member_id)->first();
            $data = Keuangan::join('rekening_bank', 'rekening_bank.rekening_bank_id', 'keuangan.rekening_bank_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'rekening_bank.informasi_akun_id')->join('jenis_transaksi', 'jenis_transaksi.jenis_transaksi_id', 'keuangan.jenis_transaksi_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->where('jenis_transaksi.jenis_transaksi_id', $request->jenis_transaksi_id)->whereBetween('keuangan.created_at', [$temp['awal'], $temp['akhir']])->where('member.member_id', $request->member_id)->get();
        }

        return Helper::print_transaksi_bank($member, $data, $jenisTransaksi, $date);
    }
}
