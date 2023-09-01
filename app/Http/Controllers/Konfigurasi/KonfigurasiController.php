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
                "url" => route('anggota.index'),
                "color" => "primary"
            ],
            [
                "nama" => "Jenis Inisiasi",
                "icon" => "filter",
                "url" => route('menu.procurement'),
                "color" => "secondary"
            ],
            [
                "nama" => "Jenis Perdagangan",
                "icon" => "tint",
                "url" => route('fasilitas.index'),
                "color" => "success"
            ],
            [
                "nama" => "Jenis Suspend",
                "icon" => "upload",
                "url" => route('produk.index'),
                "color" => "danger"
            ],
            [
                "nama" => "Jenis Status member",
                "icon" => "upload",
                "url" => route('produk.index'),
                "color" => "danger"
            ],
        ];
        return view('konfigurasi/index', compact('allMenu'));
    }
}
