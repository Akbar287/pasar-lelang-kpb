<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Models\EventLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HistoryOfflineController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $waktuMulai = $request->has('waktu_mulai') ? Carbon::createFromFormat('Y-m-d', $request->waktu_mulai) : Carbon::now()->subDays(7);
        $waktuSelesai = $request->has('waktu_selesai') ? Carbon::createFromFormat('Y-m-d', $request->waktu_selesai) : Carbon::now();
        if ($waktuMulai->gt($waktuSelesai)) {
            $temp = $waktuMulai;
            $waktuMulai = $waktuSelesai;
            $waktuSelesai = $temp;
        }
        $waktuMulai = $waktuMulai->format('Y-m-d');
        $waktuSelesai = $waktuSelesai->format('Y-m-d');

        if ($request->ajax()) {
            $data = EventLelang::select('event_lelang.event_lelang_id')->addSelect('event_lelang.event_kode')->addSelect('event_lelang.nama_lelang')->addSelect('event_lelang.tanggal_lelang')->addSelect('event_lelang.jam_mulai')->addSelect('event_lelang.jam_selesai')->addSelect('event_lelang.is_online')->addSelect('offline_profile.*')->addSelect('ktp.nama')->distinct()->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')->join('daftar_peserta_lelang', 'daftar_peserta_lelang.event_lelang_id', 'event_lelang.event_lelang_id')->join('member', 'member.member_id', 'admin.member_id')->join('ktp', 'ktp.member_id', 'member.member_id')->orderBy('event_lelang.tanggal_lelang', 'desc')->where('daftar_peserta_lelang.informasi_akun_id', Auth::user()->informasi_akun_id)->whereBetween('event_lelang.tanggal_lelang', [$waktuMulai, $waktuSelesai])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jam', function ($row) {
                    return $row->jam_mulai . '-' . $row->jam_selesai;
                })
                ->addColumn('jenis', function ($row) {
                    return $row->is_online ? 'Hybrid' : 'Offline';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.history.show', $row->event_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_offline/history/index', compact('waktuMulai', 'waktuSelesai'));
    }

    public function show(EventLelang $eventLelang)
    {
        return view('lelang_offline/history/show', compact('eventLelang'));
    }
}
