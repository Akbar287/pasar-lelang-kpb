<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\InformasiAkun;
use App\Models\JenisVerifikasi;
use App\Models\StatusMember;
use App\Models\Suspend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AnggotaDibekukanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = collect()->merge(StatusMember::where('nama_status', 'Suspend')->first()->member()->get())->merge(StatusMember::where('nama_status', 'Suspend')->first()->lembaga()->get());
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('suspend_kode', function ($row) {
                    return $row->informasi_akun()->first()->verified_log()->where('jenis_verifikasi_id', JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Suspend Anggota')->first()->jenis_verifikasi_id)->first()->suspend()->orderBy('tanggal_suspend', 'desc')->first()->suspend_kode ?? "Tidak Ada";
                })
                ->addColumn('nama', function ($row) {
                    if (!is_null($row->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->nama_lembaga;
                    } else {
                        $actionBtn = $row->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('username', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->userlogin()->first()->username;
                    return $actionBtn;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->informasi_akun()->first()->verified_log()->where('jenis_verifikasi_id', JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Suspend Anggota')->first()->jenis_verifikasi_id)->first()->suspend()->orderBy('tanggal_suspend', 'desc')->first()->tanggal_suspend ?? "Tidak ada data";
                })
                ->addColumn('jenis_anggota', function ($row) {
                    $actionBtn = (isset($row->lembaga_id)) ? 'Lembaga' : "Perseorangan";
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.dibekukan.show', [$row->informasi_akun()->first()->informasi_akun_id, $row->informasi_akun()->first()->verified_log()->where('jenis_verifikasi_id', JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Suspend Anggota')->first()->jenis_verifikasi_id)->first()->suspend()->orderBy('tanggal_suspend', 'desc')->first()->suspend_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/anggota_dibekukan/index');
    }

    public function show(InformasiAkun $anggota, Suspend $suspend)
    {
        return view('master_data/anggota_pasar_lelang/anggota_dibekukan/show', compact('anggota', 'suspend'));
    }

    public function store(Request $request, InformasiAkun $anggota, Suspend $suspend)
    {
        $jenisSuspend = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Suspend Anggota')->first()->jenis_verifikasi_id;
        $anggota->verified_log()->create([
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenisSuspend,
            'is_agree' => true,
            'tanggal_verifikasi' => date('Y-m-d'),
            'keterangan' => $request->keterangan
        ]);

        $status = StatusMember::where('nama_status', 'Aktif')->first();

        if (!is_null($anggota->member()->first())) {
            $anggota->member()->first()->update([
                'status_member_id' => $status->status_member_id
            ]);
        } else {
            $anggota->lembaga()->first()->update([
                'status_member_id' => $status->status_member_id
            ]);
        }

        return redirect('/master/anggota/dibekukan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota telah di Reaktivasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
