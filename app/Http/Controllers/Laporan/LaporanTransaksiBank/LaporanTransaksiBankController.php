<?php

namespace App\Http\Controllers\Laporan\LaporanTransaksiBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanTransaksiBankController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Transaksi Bank",
                "icon" => "th",
                "url" => route('anggota.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Keuangan Transaksi Harian",
                "icon" => "filter",
                "url" => route('menu.procurement'),
                "color" => "secondary"
            ],
            [
                "nama" => "Rekapitulasi Bank",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
            [
                "nama" => "Rekapitulasi Rekening Anggota",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ]
        ];
        return view('laporan/transaksi_bank/index', compact('allMenu'));
    }
}
