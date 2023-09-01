<?php

namespace App\Http\Controllers\MasterData\Kontrak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KontrakPasarLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Pengaturan Kontrak",
                "icon" => "th",
                "url" => route('master.kontrak.pengaturan'),
                "color" => "primary"
            ],
            [
                "nama" => "Verifikasi Kontrak",
                "icon" => "filter",
                "url" => route('master.kontrak.verifikasi'),
                "color" => "info"
            ],
            [
                "nama" => "Daftar Kontrak",
                "icon" => "tint",
                "url" => route('master.kontrak.list'),
                "color" => "success"
            ],
            [
                "nama" => "Kontrak Tidak Aktif",
                "icon" => "upload",
                "url" => route('master.kontrak.nonaktif'),
                "color" => "danger"
            ],
        ];
        return view('master_data/kontrak_pasar_lelang/index', compact('allMenu'));
    }
}
