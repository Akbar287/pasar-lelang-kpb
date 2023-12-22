<?php

namespace App\Http\Controllers\Laporan\LaporanEventOffline;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\EventLelang;
use Illuminate\Http\Request;

class LaporanEventLelangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('laporan/event_lelang/event_lelang');
    }

    public function api(Request $request)
    {
        $request->validate([
            'q' => ['required']
        ]);

        $event = EventLelang::select('event_kode')->addSelect('event_lelang_id')->addSelect('nama_lelang')->where('event_kode', 'LIKE', '%' . $request->q . '%')->orWhere('event_kode', 'LIKE', $request->q . '%')->orWhere('event_kode', 'LIKE', '%' . $request->q)->limit(25)->get()->toArray();

        return response()->json([
            'status' => 'success',
            'message' => 'Event Lelang has been catched.',
            'data' => $event
        ], 200);
        exit;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'event_lelang_id' => ['required']
        ]);

        $event = EventLelang::where('event_lelang_id', $request->event_lelang_id)->first();

        return Helper::print_event_lelang($event);
    }
}
