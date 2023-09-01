<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LelangOfflineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Offline Profile",
                "icon" => "th",
                "url" => route('offline.profile'),
                "color" => "primary"
            ],
            [
                "nama" => "Operator Lelang Offline",
                "icon" => "filter",
                "url" => route('offline.operator'),
                "color" => "secondary"
            ],
            [
                "nama" => "Event Lelang Offline",
                "icon" => "tint",
                "url" => route('offline.event'),
                "color" => "success"
            ]
        ];
        return view('lelang_offline/index', compact('allMenu'));
    }
}
