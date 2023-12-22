<?php

namespace App\Http\Controllers\Konfigurasi\Status;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Status Member",
                "icon" => "th",
                "url" => route('konfigurasi.status.member'),
                "color" => "primary"
            ],
            [
                "nama" => "Status Lelang",
                "icon" => "upload",
                "url" => route('konfigurasi.status.lelang'),
                "color" => "warning"
            ],
            [
                "nama" => "Status Event Lelang",
                "icon" => "upload",
                "url" => route('konfigurasi.status.event_lelang'),
                "color" => "danger"
            ]
        ];
        return view('konfigurasi/status/index', compact('allMenu'));
    }
}
