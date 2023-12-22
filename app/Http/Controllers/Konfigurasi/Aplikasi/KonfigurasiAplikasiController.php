<?php

namespace App\Http\Controllers\Konfigurasi\Aplikasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KonfigurasiAplikasiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Aplikasi",
                "icon" => "phone",
                "url" => route('konfigurasi.aplikasi.aplikasi'),
                "color" => "primary"
            ],
            [
                "nama" => "Carousel",
                "icon" => "file",
                "url" => route('konfigurasi.aplikasi.carousel'),
                "color" => "warning"
            ],
            [
                "nama" => "Web Link",
                "icon" => "globe",
                "url" => route('konfigurasi.aplikasi.web_link'),
                "color" => "info"
            ]
        ];
        return view('konfigurasi/aplikasi/index', compact('allMenu'));
    }
}
