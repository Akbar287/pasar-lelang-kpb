<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Models\EventLelang;
use App\Models\Lelang;
use App\Models\StatusLelang;
use Illuminate\Http\Request;

class EventLelangProdukController extends Controller
{
    public function index(Request $request, EventLelang $event)
    {
        $data = $event->lelang()->paginate(6);
        return view('lelang_offline/event_produk/index', compact('event', 'data'));
    }

    public function show(EventLelang $event, Lelang $lelang)
    {
        return view('lelang_offline/event_produk/show', compact('event', 'lelang'));
    }

    public function sesi(EventLelang $event, Lelang $lelang)
    {
        return view('lelang_offline/event_produk/sesi', compact('event', 'lelang'));
    }

    public function sesi_doc(EventLelang $event, Lelang $lelang, Request $file)
    {
        if ($file == 'doc') {
            // Generated Doc File
        } else if ($file == 'pdf') {
            // Generated PDF File
        } else {
            // Return false
        }
    }

    public function sesi_api(Request $request, EventLelang $event, Lelang $lelang)
    {
        $request->validate([
            'harga' => ['required'],
            'waktu' => ['required'],
            'code' => ['required'],
            'peserta' => ['required']
        ]);

        if ($request->code == 'penawaran') {
            $event->daftar_peserta_lelang()->where('kode_peserta_lelang', $request->peserta)->first()->daftar_peserta_lelang_berlangsung()->create([
                'lelang_id' => $lelang->lelang_id,
                'harga_ajuan' => $request->harga,
                'waktu' => $request->waktu
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'data has been collected',
                'data' => $lelang->daftar_peserta_lelang_berlangsung()->get()
            ], 200);
        } else if ($request->code == 'reset') {
            if (is_null($lelang->jenis_platform_lelang()->first())) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'jenis lelang not found',
                    'data' => []
                ], 200);
            } else if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
                $lelang->peserta_lelang_berlangsung()->delete();
            } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
                $lelang->daftar_peserta_lelang_berlangsung()->delete();
            } else {
                $lelang->daftar_peserta_lelang_berlangsung()->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'data has been reset for this lelang',
                'data' => []
            ], 200);
        } else if ($request->code == 'selesai') {
            $statusLelang = StatusLelang::where('nama_status', 'Selesai')->first();

            foreach ($lelang->status_lelang_pivot()->get() as $l) {
                $l->update([
                    'is_aktif' => false
                ]);
            }

            $lelang->status_lelang_pivot()->create([
                'status_lelang_id' => $statusLelang->status_lelang_id,
                'is_aktif' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'lelang has been finished',
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'you dont have permnission on this route',
                'data' => null
            ], 404);
        }
    }
}
