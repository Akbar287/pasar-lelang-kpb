<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventLelangRequest;
use App\Models\EventLelang;
use App\Models\OfflineProfile;
use App\Models\StatusEventLelang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EventLelangController extends Controller
{
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
}
