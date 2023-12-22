<?php

namespace App\Http\Controllers\Konfigurasi\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KonfigurasiLaporanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Perjanjian Jual Beli",
                "icon" => "handshake",
                "url" => route('konfigurasi.laporan.perjanjian_jual_beli'),
                "color" => "primary"
            ],
        ];
        return view('konfigurasi/laporan/index', compact('allMenu'));
    }
}
