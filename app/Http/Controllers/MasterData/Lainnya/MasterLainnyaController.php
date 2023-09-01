<?php

namespace App\Http\Controllers\MasterData\Lainnya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterLainnyaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Sesi Perdagangan",
                "icon" => "th",
                "url" => route('master.lain.sesi'),
                "color" => "primary"
            ],
            [
                "nama" => "Rekening Bank",
                "icon" => "filter",
                "url" => route('master.lain.rekening'),
                "color" => "secondary"
            ],
            [
                "nama" => "Komoditas",
                "icon" => "tint",
                "url" => route('master.lain.komoditas'),
                "color" => "success"
            ],
            [
                "nama" => "Dokumen Persyaratan",
                "icon" => "upload",
                "url" => route('master.lain.dokumen_persyaratan'),
                "color" => "danger"
            ],
        ];
        return view('master_data/master_lainnya/index', compact('allMenu'));
    }
}
