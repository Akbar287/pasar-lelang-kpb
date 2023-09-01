<?php

namespace App\Http\Controllers\Laporan\LaporanJaminan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanJaminanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Jaminan Terpakai",
                "icon" => "th",
                "url" => route('anggota.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Ringkasan Jaminan",
                "icon" => "filter",
                "url" => route('menu.procurement'),
                "color" => "secondary"
            ],
            [
                "nama" => "Ringkasan Jaminan per Anggota",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ]
        ];
        return view('laporan/jaminan/index', compact('allMenu'));
    }
}
