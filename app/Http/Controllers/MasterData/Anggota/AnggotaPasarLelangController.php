<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaPasarLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Calon Anggota",
                "icon" => "user-plus",
                "url" => route('master.anggota.calon'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Calon Anggota",
                "icon" => "filter",
                "url" => route('master.anggota.verifikasi'),
                "color" => "info"
            ],
            [
                "nama" => "Daftar Anggota",
                "icon" => "list",
                "url" => route('master.anggota.list'),
                "color" => "success"
            ],
            [
                "nama" => "Anggota Dibekukan",
                "icon" => "user-times",
                "url" => route('master.anggota.dibekukan'),
                "color" => "danger"
            ],
        ];
        return view('master_data/anggota_pasar_lelang/index', compact('allMenu'));
    }
}
