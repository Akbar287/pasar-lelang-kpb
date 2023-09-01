<?php

namespace App\Http\Controllers\Laporan\LaporanTransaksiLelang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanTransaksiLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Transaksi Anggota",
                "icon" => "th",
                "url" => route('anggota.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Transaksi Lelang",
                "icon" => "filter",
                "url" => route('menu.procurement'),
                "color" => "secondary"
            ],
            [
                "nama" => "Transaksi lelang per anggota",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
            [
                "nama" => "Laporan Jumlah Peserta Lelang",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ]
        ];
        return view('laporan/transaksi_lelang/index', compact('allMenu'));
    }
}
