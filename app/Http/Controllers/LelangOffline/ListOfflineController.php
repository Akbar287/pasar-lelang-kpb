<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Models\EventLelang;
use App\Models\JenisDokumenProduk;
use App\Models\Lelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ListOfflineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EventLelang::select('event_lelang.event_lelang_id')
                ->addSelect('event_lelang.event_kode')
                ->addSelect('event_lelang.nama_lelang')
                ->addSelect('event_lelang.tanggal_lelang')
                ->addSelect('event_lelang.jam_mulai')
                ->addSelect('event_lelang.jam_selesai')
                ->addSelect('event_lelang.is_online')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->where('event_lelang.tanggal_lelang', '>=', Carbon::now()->format('Y-m-d'))
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jam', function ($row) {
                    return $row->jam_mulai . '-' . $row->jam_selesai;
                })
                ->addColumn('jenis', function ($row) {
                    return $row->is_online ? 'Hybrid' : 'Offline';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.list.show', $row->event_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_offline/list/index');
    }

    public function show(Request $request, EventLelang $eventLelang)
    {
        if ($request->ajax()) {
            $data = $eventLelang->lelang()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penjual', function ($row) {
                    $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('gambar', function ($row) {
                    $img = is_null($row->dokumen_produk()->where('is_gambar_utama', true)->first()) ? 'default.png' : $row->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file;

                    return '<img src="' . asset('storage/produk/' . $img) . '" alt="' . $row->nama_dokumen . '" style="width: 75px;height: 75px;" class="img img-thumbnail" />';
                })
                ->addColumn('nama_produk', function ($row) {
                    return $row->judul ?? "-";
                })
                ->addColumn('kuantitas', function ($row) {
                    return number_format($row->kuantitas ?? 0, 0, ".", ",");
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->harga_awal ?? 0, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('kelipatan', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->kelipatan_penawaran ?? 0, 0, ".", ",");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.list.lelang', [$row->event_lelang()->first()->event_lelang_id, $row->lelang_id]) . '" class="edit btn btn-success btn-sm">Lelang</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('lelang_offline/list/show', compact('eventLelang'));
    }

    public function join(EventLelang $eventLelang)
    {
        $data = $eventLelang->daftar_peserta_lelang()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first();

        if (is_null($data)) {
            $data =  $eventLelang->daftar_peserta_lelang()->create([
                'informasi_akun_id' => Auth::user()->informasi_akun_id,
                'kode_peserta_lelang' => $this->rekomendasiKodeAnggota($eventLelang)
            ]);
        }

        return redirect('/offline/list/' . $eventLelang->event_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Anda sudah bergabung di event lelang ini.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function event_lelang(EventLelang $eventLelang, Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('lelang_offline/list/show_detail_lelang', compact('eventLelang', 'lelang', 'jenisDokumen'));
    }

    public function sesi_lelang(EventLelang $eventLelang, Lelang $lelang)
    {
        return view('lelang_offline/list/show_detail_sesi_lelang', compact('eventLelang', 'lelang'));
    }

    public function rekomendasiKodeAnggota($event)
    {
        $temp = $event->daftar_peserta_lelang()->count();
        return is_null($temp) ? 1 : intval($temp) + 1;
    }
}
