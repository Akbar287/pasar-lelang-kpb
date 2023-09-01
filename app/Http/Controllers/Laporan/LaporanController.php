<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
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
                "url" => route('anggota.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Laporan Transaksi Lelang",
                "icon" => "filter",
                "url" => route('menu.procurement'),
                "color" => "secondary"
            ],
            [
                "nama" => "Laporan Transaksi Bank",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
            [
                "nama" => "Laporan Daftar Anggota",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
            [
                "nama" => "Laporan Event Lelang Offline",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
        ];
        return view('laporan/index', compact('allMenu'));
    }
}
