<?php

namespace App\Http\Controllers\Laporan\LaporanJaminan;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\DetailJaminan;
use App\Models\Member;
use App\Models\PengeluaranJaminan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanJaminanController extends Controller
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
        return view('laporan/jaminan/jaminan', compact('date'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tanggal_awal' => ['required'],
            'tanggal_akhir' => ['required'],
            'jenis' => ['required'],
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

        $member = Member::where('member_id', request('member_id'))->first();
        $data['masuk'] = null;
        $data['keluar'] = null;

        if (is_null(request('member_id'))) {
            if (request('jenis') == 'masuk' || request('jenis') == 'semua') {
                $data['masuk'] = DetailJaminan::whereBetween('detail_jaminan.tanggal_transaksi', [$temp['awal'], $temp['akhir']])->get();
            }
            if (request('jenis') == 'keluar' || request('jenis') == 'semua') {
                $data['keluar'] = PengeluaranJaminan::whereBetween('pengeluaran_jaminan.tanggal', [$temp['awal'], $temp['akhir']])->get();
            }
        } else {
            if (request('jenis') == 'masuk' || request('jenis') == 'semua') {
                $data['masuk'] = !is_null(!is_null($member->informasi_akun()->first()->jaminan()->first()) ? $member->informasi_akun()->first()->jaminan()->first()->detail_jaminan()->first() : null) ? $member->informasi_akun()->first()->jaminan()->first()->detail_jaminan()->whereBetween('detail_jaminan.tanggal_transaksi', [$temp['awal'], $temp['akhir']])->get() : [];
            }
            if (request('jenis') == 'keluar' || request('jenis') == 'semua') {
                $data['keluar'] = !is_null($member->informasi_akun()->first()->jaminan()->first()) ? $member->informasi_akun()->first()->jaminan()->first()->pengeluaran_jaminan()->whereBetween('pengeluaran_jaminan.tanggal', [$temp['awal'], $temp['akhir']])->get() : [];
            }
        }

        return Helper::print_laporan_jaminan($data, $member, $date);
    }
}
