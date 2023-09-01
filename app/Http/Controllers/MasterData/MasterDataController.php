<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Anggota Pasar Lelang",
                "icon" => "users",
                "url" => route('master.anggota'),
                "color" => "primary"
            ],
            [
                "nama" => "Kontrak Pasar Lelang",
                "icon" => "handshake",
                "url" => route('master.kontrak'),
                "color" => "info"
            ],
            [
                "nama" => "Lembaga Pendukung",
                "icon" => "building",
                "url" => route('master.lembaga'),
                "color" => "success"
            ],
            [
                "nama" => "Master lainnya",
                "icon" => "th",
                "url" => route('master.lain'),
                "color" => "danger"
            ]
        ];
        return view('master_data/index', compact('allMenu'));
    }
}
