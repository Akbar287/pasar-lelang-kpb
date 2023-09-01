<?php

namespace App\Http\Controllers\LelangOnline;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LelangSesiOnline;
use App\Models\PesertaLelang;
use App\Models\StatusMember;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AnggotaEventLelangOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LelangSesiOnline $event)
    {
        if ($request->ajax()) {
            $data = PesertaLelang::where('tanggal', $event->tanggal)->where('master_sesi_lelang_id', $event->master_sesi_lelang()->first()->master_sesi_lelang_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('username', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->userlogin()->first()->username;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('online.event.anggota.show', [$row->master_sesi_lelang()->first()->lelang_sesi_online()->where('tanggal', $row->tanggal)->first()->lelang_sesi_online_id, $row->peserta_lelang_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_online/event_anggota/index', compact('event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(LelangSesiOnline $event)
    {
        $members = StatusMember::where('nama_status', 'Aktif')->first()->member()->whereNotIn('member_id', Admin::select('member.member_id')->join('member', 'member.member_id', 'admin.member_id')->get()->toArray())->whereNotIn('member_id', $event->master_sesi_lelang()->first()->peserta_lelang()->select('member.member_id')->join('informasi_akun', 'peserta_lelang.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->get()->toArray())->get();
        return view('lelang_online/event_anggota/create', compact('event', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LelangSesiOnline $event)
    {
        $request->validate([
            'informasi_akun_id' => ['required'],
            'kode_peserta_lelang' => ['required'],
        ]);

        if ($event->master_sesi_lelang()->first()->peserta_lelang()->where('kode_peserta_lelang', $request->kode_peserta_lelang)->count() == 0) {
            $anggota = $event->master_sesi_lelang()->first()->peserta_lelang()->where('informasi_akun_id', request('informasi_akun_id'))->first();

            if (!is_null($anggota)) {
                $anggota->update($this->pesertaLelangData($event->tanggal));
            } else {
                $anggota = $event->master_sesi_lelang()->first()->peserta_lelang()->create($this->pesertaLelangData($event->tanggal));
            }

            return redirect('/online/event/' . $event->lelang_sesi_online_id . '/anggota/' . $anggota->daftar_peserta_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota Lelang telah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/online/event/' . $event->lelang_sesi_online_id . '/anggota/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Kode Event: ' . $request->kode_peserta_lelang . ' telah ada sebelumnya.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LelangSesiOnline $event, PesertaLelang $anggota)
    {
        return view('lelang_online/event_anggota/show', compact('event', 'anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LelangSesiOnline $event, PesertaLelang $anggota)
    {
        $members = StatusMember::where('nama_status', 'Aktif')->first()->member()->whereNotIn('member_id', Admin::select('member.member_id')->join('member', 'member.member_id', 'admin.member_id')->get()->toArray())->whereNotIn('member_id', $event->master_sesi_lelang()->first()->peserta_lelang()->select('member.member_id')->join('informasi_akun', 'peserta_lelang.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->whereNot('member_id', $anggota->informasi_akun()->first()->member()->first()->member_id)->get()->toArray())->get();
        return view('lelang_online/event_anggota/edit', compact('event', 'anggota', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LelangSesiOnline $event, PesertaLelang $anggota)
    {
        $request->validate([
            'informasi_akun_id' => ['required'],
            'kode_peserta_lelang' => ['required'],
        ]);

        $anggota->update($this->pesertaLelangData($event->tanggal));

        return redirect('/online/event/' . $event->lelang_sesi_online_id . '/anggota/' . $anggota->peserta_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota Lelang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LelangSesiOnline $event, PesertaLelang $anggota)
    {
        $anggota->delete();

        return redirect('/online/event/' . $event->lelang_sesi_online_id . '/anggota')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota Lelang telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function pesertaLelangData($tanggal)
    {
        return [
            'tanggal' => $tanggal,
            'informasi_akun_id' => request('informasi_akun_id'),
            'kode_peserta_lelang' => request('kode_peserta_lelang'),
        ];
    }
}
