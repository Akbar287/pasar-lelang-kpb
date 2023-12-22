<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdministrasiPasarLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Kas dan Bank",
                "icon" => "th",
                "url" => route('administrasi.kas_bank'),
                "color" => "primary"
            ],
            [
                "nama" => "Gudang",
                "icon" => "filter",
                "url" => route('administrasi.gudang'),
                "color" => "secondary"
            ],
            [
                "nama" => "Jaminan Lelang",
                "icon" => "tint",
                "url" => route('administrasi.jaminan'),
                "color" => "success"
            ]
        ];
        return view('administrasi/index', compact('allMenu'));
    }
}
