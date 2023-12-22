<?php

namespace App\Http\Controllers\Konfigurasi\Jenis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Jenis Harga",
                "icon" => "th",
                "url" => route('konfigurasi.jenis.harga'),
                "color" => "primary"
            ],
            [
                "nama" => "Jenis Perdagangan",
                "icon" => "upload",
                "url" => route('konfigurasi.jenis.perdagangan'),
                "color" => "warning"
            ],
            [
                "nama" => "Jenis Inisiasi",
                "icon" => "upload",
                "url" => route('konfigurasi.jenis.inisiasi'),
                "color" => "danger"
            ]
        ];
        return view('konfigurasi/jenis/index', compact('allMenu'));
    }
}
