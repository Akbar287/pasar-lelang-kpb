<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KonfigurasiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Role",
                "icon" => "th",
                "url" => route('konfigurasi.role'),
                "color" => "primary"
            ],
            [
                "nama" => "Admin",
                "icon" => "upload",
                "url" => route('konfigurasi.admin'),
                "color" => "warning"
            ],
            [
                "nama" => "Area",
                "icon" => "map",
                "url" => route('konfigurasi.area'),
                "color" => "info"
            ],
            [
                "nama" => "Mutu",
                "icon" => "upload",
                "url" => route('konfigurasi.mutu'),
                "color" => "danger"
            ],
            [
                "nama" => "Jenis",
                "icon" => "filter",
                "url" => route('konfigurasi.jenis'),
                "color" => "info"
            ],
            [
                "nama" => "Aplikasi",
                "icon" => "phone",
                "url" => route('konfigurasi.aplikasi'),
                "color" => "primary"
            ],
            [
                "nama" => "Status",
                "icon" => "tint",
                "url" => route('konfigurasi.status'),
                "color" => "success"
            ],
            [
                "nama" => "Laporan",
                "icon" => "file",
                "url" => route('konfigurasi.laporan'),
                "color" => "primary"
            ],
        ];
        return view('konfigurasi/index', compact('allMenu'));
    }
}
