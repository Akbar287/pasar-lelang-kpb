<?php

namespace App\Http\Controllers\LelangOnline;

use App\Http\Controllers\Controller;
use App\Models\Lelang;
use App\Models\LelangSesiOnline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EventLelangOnlineController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LelangSesiOnline::join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->whereBetween('lelang_sesi_online.tanggal', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(7)->format('Y-m-d')])->orderBy('tanggal', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penyelenggara', function ($row) {
                    return $row->master_sesi_lelang()->first()->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                })
                ->addColumn('sesi', function ($row) {
                    return $row->master_sesi_lelang()->first()->sesi . ' (' . $row->jam_mulai . '-' . $row->jam_berakhir . ')';
                })
                ->addColumn('produk', function ($row) {
                    return $row->lelang()->count() . ' Produk';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('online.event.show', $row->lelang_sesi_online_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_online/event/index');
    }

    public function show(LelangSesiOnline $event)
    {
        return view('lelang_online/event/show', compact('event'));
    }

    public function produk(LelangSesiOnline $event)
    {
        $data = $event->lelang()->paginate(6);
        return view('lelang_online/event/produk', compact('event', 'data'));
    }

    public function produk_show(LelangSesiOnline $event, Lelang $lelang)
    {
        return view('lelang_online/event/produk_show', compact('event', 'lelang'));
    }

    public function produk_sesi(LelangSesiOnline $event, Lelang $lelang)
    {
        return view('lelang_online/event/produk_sesi', compact('event', 'lelang'));
    }
}
