<?php

namespace App\Http\Controllers\Konfigurasi\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Provinsi",
                "icon" => "th",
                "url" => route('konfigurasi.area.provinsi'),
                "color" => "primary"
            ]
        ];
        return view('konfigurasi/area/index', compact('allMenu'));
    }
}
