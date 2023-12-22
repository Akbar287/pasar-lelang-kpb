<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventLelangRequest;
use App\Models\EventLelang;
use App\Models\Lelang;
use App\Models\OfflineProfile;
use App\Models\StatusEventLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EventLelangController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EventLelang::select('event_kode')->addSelect('event_lelang_id')->addSelect('lokasi')->addSelect('is_online')->addSelect('nama_lelang')->addSelect('tanggal_lelang')->addSelect('jam_mulai')->addSelect('jam_selesai')->addSelect('status_event_lelang.nama_status')->join('status_event_lelang', 'status_event_lelang.status_event_lelang_id', 'event_lelang.status_event_lelang_id')->where('status_event_lelang.nama_status', 'Lelang Baru')->orWhere('status_event_lelang.nama_status', 'Sinkronisasi Inisiasi Jual')->orWhere('status_event_lelang.nama_status', 'Sinkronisasi Anggota Lelang')->orWhere('status_event_lelang.nama_status', 'Lelang Berlangsung')->orderBy('created_at', 'desc')->orderBy('status_event_lelang.urutan', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jam_lelang', function ($row) {
                    $actionBtn = $row->jam_mulai . '-' . $row->jam_selesai;
                    return $actionBtn;
                })
                ->addColumn('penyelenggaraan', function ($row) {
                    $actionBtn = $row->is_online == true ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = null;
                    if ($row->nama_status == 'Lelang Baru') {
                        $actionBtn = '<div class="badge badge-primary">Lelang Baru</div>';
                    } else if ($row->nama_status == 'Sinkronisasi Inisiasi Jual') {
                        $actionBtn = '<div class="badge badge-info">Sinkronisasi Inisiasi Jual</div>';
                    } else if ($row->nama_status == 'Sinkronisasi Anggota Lelang') {
                        $actionBtn = '<div class="badge badge-warning">Sinkronisasi Anggota Lelang</div>';
                    } else if ($row->nama_status == 'Lelang Berlangsung') {
                        $actionBtn = '<div class="badge badge-success">Lelang Berlangsung</div>';
                    } else if ($row->nama_status == 'Selesai') {
                        $actionBtn = '<div class="badge badge-secondary">Selesai</div>';
                    } else {
                        $actionBtn = '<div class="badge badge-danger">No Status</div>';
                    }
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.event.show', $row->event_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'penyelenggaraan'])
                ->make(true);
        }
        $status = StatusEventLelang::where('is_aktif', true)->orderBy('urutan', 'asc')->get();
        return view('lelang_offline/event/index', compact('status'));
    }

    public function index_history(Request $request)
    {
        if ($request->ajax()) {
            $data = EventLelang::select('event_kode')->addSelect('event_lelang_id')->addSelect('lokasi')->addSelect('is_online')->addSelect('nama_lelang')->addSelect('tanggal_lelang')->addSelect('jam_mulai')->addSelect('jam_selesai')->addSelect('status_event_lelang.nama_status')->join('status_event_lelang', 'status_event_lelang.status_event_lelang_id', 'event_lelang.status_event_lelang_id')->where('status_event_lelang.nama_status', 'Selesai')->orderBy('created_at', 'desc')->orderBy('status_event_lelang.urutan', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jam_lelang', function ($row) {
                    $actionBtn = $row->jam_mulai . '-' . $row->jam_selesai;
                    return $actionBtn;
                })
                ->addColumn('penyelenggaraan', function ($row) {
                    $actionBtn = $row->is_online == true ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = null;
                    if ($row->nama_status == 'Lelang Baru') {
                        $actionBtn = '<div class="badge badge-primary">Lelang Baru</div>';
                    } else if ($row->nama_status == 'Sinkronisasi Inisiasi Jual') {
                        $actionBtn = '<div class="badge badge-info">Sinkronisasi Inisiasi Jual</div>';
                    } else if ($row->nama_status == 'Sinkronisasi Anggota Lelang') {
                        $actionBtn = '<div class="badge badge-warning">Sinkronisasi Anggota Lelang</div>';
                    } else if ($row->nama_status == 'Lelang Berlangsung') {
                        $actionBtn = '<div class="badge badge-success">Lelang Berlangsung</div>';
                    } else if ($row->nama_status == 'Selesai') {
                        $actionBtn = '<div class="badge badge-secondary">Selesai</div>';
                    } else {
                        $actionBtn = '<div class="badge badge-danger">No Status</div>';
                    }
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.event.history.show', $row->event_lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'penyelenggaraan'])
                ->make(true);
        }
        $status = StatusEventLelang::where('is_aktif', true)->orderBy('urutan', 'asc')->get();
        return view('lelang_offline/event/index', compact('status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offlineProfile = OfflineProfile::where('is_open', true)->get();
        return view('lelang_offline/event/create', compact('offlineProfile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventLelangRequest $eventLelangRequest)
    {
        $statusEventLelang = StatusEventLelang::where('nama_status', 'Lelang Baru')->first();
        $offlineProfile = OfflineProfile::where('offline_profile_id', $eventLelangRequest->offline_profile_id)->first();

        $event = $offlineProfile->event_lelang()->create($this->eventLelangData($statusEventLelang));

        return redirect('/offline/event/' . $event->event_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Event telah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventLelang $event)
    {
        $statusEvent = StatusEventLelang::where('is_aktif', true)->orderBy('urutan', 'asc')->get();
        return view('lelang_offline/event/show', compact('event', 'statusEvent'));
    }

    public function show_history(EventLelang $event)
    {
        $statusEvent = StatusEventLelang::where('is_aktif', true)->orderBy('urutan', 'asc')->get();
        return view('lelang_offline/event/show_history', compact('event', 'statusEvent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventLelang $event)
    {
        $offlineProfile = OfflineProfile::where('is_open', true)->get();
        return view('lelang_offline/event/edit', compact('offlineProfile', 'event'));
    }

    public function edit_status(EventLelang $event)
    {
        $status = StatusEventLelang::where('is_aktif', true)->orderBy('urutan', 'asc')->get();
        return view('lelang_offline/event/change_status', compact('event', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_status(Request $request, EventLelang $event)
    {
        $request->validate([
            'status_event_lelang_id' => ['required']
        ]);

        $event->update([
            'status_event_lelang_id' => $request->status_event_lelang_id
        ]);

        return redirect('/offline/event/' . $event->event_lelang_id . '/status')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Status Event telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function update(EventLelangRequest $eventLelangRequest, EventLelang $event)
    {
        $is_online = request('is_online') == 'true' ? true : false;

        if ($event->is_online != $is_online) {
            foreach ($event->lelang()->get() as $l) {
                $l->jenis_platform_lelang()->first()->update([
                    'online' => $is_online
                ]);
            }
        }
        $event->update($this->eventLelangData());


        return redirect('/offline/event/' . $event->event_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Event telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventLelang $event)
    {
        $event->delete();

        return redirect('/offline/event')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Event telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function eventLelangData($statusEventLelang = null)
    {
        if (is_null($statusEventLelang)) {
            return [
                'event_kode' => request('event_kode'),
                'nama_lelang' => request('nama_lelang'),
                'tanggal_lelang' => request('tanggal_lelang'),
                'lokasi' => request('lokasi'),
                'jam_mulai' => request('jam_mulai'),
                'jam_selesai' => request('jam_selesai'),
                'ketua_lelang' => request('ketua_lelang'),
                'waktu_sinkronisasi' => null,
                'sinkronisasi_oleh' => null,
                'keterangan' => request('keterangan'),
                'status_pendaftaran' => request('is_open') ? 'open' : 'closed',
                'is_open' => request('is_open'),
                'is_online' => request('is_online'),
            ];
        } else {
            return [
                'status_event_lelang_id' => $statusEventLelang->status_event_lelang_id,
                'event_kode' => request('event_kode'),
                'nama_lelang' => request('nama_lelang'),
                'tanggal_lelang' => request('tanggal_lelang'),
                'lokasi' => request('lokasi'),
                'jam_mulai' => request('jam_mulai'),
                'jam_selesai' => request('jam_selesai'),
                'ketua_lelang' => request('ketua_lelang'),
                'waktu_sinkronisasi' => null,
                'sinkronisasi_oleh' => null,
                'keterangan' => request('keterangan'),
                'status_pendaftaran' => request('is_open') ? 'open' : 'closed',
                'is_open' => request('is_open'),
                'is_online' => request('is_online'),
            ];
        }
    }

    public function api_sesi_event(Request $request)
    {
        $jenis = !is_null(request('jenis')) ? request('jenis') : 'hybrid';

        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = Carbon::createFromFormat('Y-m-d', $request->tanggal_awal, 'Asia/Jakarta');
            $tanggal_akhir = Carbon::createFromFormat('Y-m-d', $request->tanggal_akhir, 'Asia/Jakarta');

            if ($tanggal_akhir->diffInMicroseconds($tanggal_awal) < 0) {
                $temp = $tanggal_awal;
                $tanggal_awal = $tanggal_akhir;
                $tanggal_akhir = $temp;
            }
        }

        if ($request->has('jenis')) {
            $total = ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) ?
                EventLelang::select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->where('event_lelang.is_online', $jenis == 'hybrid' ? true : false)
                ->whereBetween('event_lelang.tanggal_lelang', [$tanggal_awal, $tanggal_akhir])
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->count() :
                EventLelang::select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->where('event_lelang.is_online', $jenis == 'hybrid' ? true : false)
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->count();

            $page_count = ceil($total / $size);

            $data = ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) ?
                DB::Table('event_lelang')->select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->where('event_lelang.is_online', $jenis == 'hybrid' ? true : false)
                ->whereBetween('event_lelang.tanggal_lelang', [$tanggal_awal, $tanggal_akhir])
                ->orderBy('tanggal_lelang', 'desc')
                ->forPage($page, $size)
                ->get() :
                DB::Table('event_lelang')->select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->where('event_lelang.is_online', $jenis == 'hybrid' ? true : false)
                ->orderBy('tanggal_lelang', 'desc')
                ->forPage($page, $size)
                ->get();
        } else {
            $total = ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) ?
                EventLelang::select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->whereBetween('event_lelang.tanggal_lelang', [$tanggal_awal, $tanggal_akhir])
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->count() :
                EventLelang::select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->count();

            $page_count = ceil($total / $size);

            $data = ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) ?
                DB::Table('event_lelang')->select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->whereBetween('event_lelang.tanggal_lelang', [$tanggal_awal, $tanggal_akhir])
                ->orderBy('tanggal_lelang', 'desc')
                ->forPage($page, $size)
                ->get() :
                DB::Table('event_lelang')->select('event_lelang.*')
                ->addSelect('offline_profile.*')
                ->addSelect('ktp.nama')
                ->join('offline_profile', 'offline_profile.offline_profile_id', 'event_lelang.offline_profile_id')
                ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'offline_profile.penyelenggara_pasar_lelang_id')
                ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
                ->join('member', 'member.member_id', 'admin.member_id')
                ->join('ktp', 'ktp.member_id', 'member.member_id')
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->orderBy('tanggal_lelang', 'desc')
                ->forPage($page, $size)
                ->get();
        }


        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'message' => 'Sesi Lelang ' . $jenis . ' has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'Sesi Lelang ' . $jenis . ' has been catched',
                'status' => 'success'
            ], 200);
        }
    }
    public function api_sesi_event_detail(Request $request, EventLelang $eventLelang)
    {
        $totalAnggota = $eventLelang->daftar_peserta_lelang()->select('kode_peserta_lelang')->get()->toArray();

        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = Carbon::createFromFormat('Y-m-d', $request->tanggal_awal, 'Asia/Jakarta');
            $tanggal_akhir = Carbon::createFromFormat('Y-m-d', $request->tanggal_akhir, 'Asia/Jakarta');

            if ($tanggal_akhir->diffInMicroseconds($tanggal_awal) < 0) {
                $temp = $tanggal_awal;
                $tanggal_awal = $tanggal_akhir;
                $tanggal_akhir = $temp;
            }
        }

        $total = $eventLelang->lelang()->count();

        $page_count = ceil($total / $size);

        $data = DB::Table('event_lelang')
            ->select('lelang.*')
            ->addSelect('jenis_perdagangan.nama_perdagangan')
            ->addSelect('jenis_inisiasi.nama_inisiasi')
            ->addSelect('jenis_harga.nama_jenis_harga')
            ->addSelect('dokumen_produk.dokumen_produk_id')
            ->addSelect('komoditas.nama_komoditas')
            ->join('event_lelang_relation', 'event_lelang_relation.event_lelang_id', 'event_lelang.event_lelang_id')
            ->join('lelang', 'lelang.lelang_id', 'event_lelang_relation.lelang_id')
            ->join('jenis_inisiasi', 'lelang.jenis_inisiasi_id', 'jenis_inisiasi.jenis_inisiasi_id')
            ->join('jenis_perdagangan', 'lelang.jenis_perdagangan_id', 'jenis_perdagangan.jenis_perdagangan_id')
            ->join('jenis_harga', 'lelang.jenis_harga_id', 'jenis_harga.jenis_harga_id')
            ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
            ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
            ->leftJoin('dokumen_produk', 'dokumen_produk.lelang_id', 'lelang.lelang_id')
            ->orderBy('lelang.judul', 'asc')
            ->where('event_lelang.event_lelang_id', $eventLelang->event_lelang_id)
            ->where('dokumen_produk.is_gambar_utama', true)
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'total_anggota' => $totalAnggota,
                'message' => 'data has show',
                'status' => 'success'
            ], 200);
            exit;
        } else {
            return response()->json([
                'data' => [],
                'total_anggota' => $totalAnggota,
                'message' => 'data has show',
                'status' => 'success'
            ], 200);
            exit;
        }
    }
    public function api_sesi_event_detail_lelang(Request $request, EventLelang $eventLelang, Lelang $lelang)
    {
        $peserta = $eventLelang->daftar_peserta_lelang()->select('kode_peserta_lelang')->get();
        $bidder = $lelang->daftar_peserta_lelang_berlangsung()
            ->select('daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_berlangsung_id')
            ->addSelect('daftar_peserta_lelang.kode_peserta_lelang')
            ->addSelect('daftar_peserta_lelang_berlangsung.harga_ajuan')
            ->addSelect('daftar_peserta_lelang_berlangsung.waktu')
            ->join('daftar_peserta_lelang', 'daftar_peserta_lelang.daftar_peserta_lelang_id', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id')
            ->get();

        return response()->json([
            'data' => [
                'total_peserta' => $peserta,
                'bidder' => $bidder,
            ],
            'message' => 'data has show',
            'status' => 'success'
        ], 200);
        exit;
    }

    public function api_sesi_event_detail_lelang_id(EventLelang $eventLelang)
    {
        return response()->json([
            'data' => $eventLelang,
            'message' => 'data has show',
            'status' => 'success'
        ], 200);
        exit;
    }
}
