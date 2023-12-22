<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\InformasiAkun;
use App\Models\JenisDokumen;
use App\Models\JenisVerifikasi;
use App\Models\StatusMember;
use App\Models\VerifiedLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class VerifikasiCalonAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = collect()->merge(StatusMember::where('nama_status', 'Calon Anggota')->first()->member()->get())->merge(StatusMember::where('nama_status', 'Calon Anggota')->first()->lembaga()->get());
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (isset($row->lembaga_id)) {
                        $actionBtn = $row->nama_lembaga;
                    } else {
                        $actionBtn = $row->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('member_id', function ($row) {
                    $actionBtn = $row->informasi_akun_id;
                    return $actionBtn;
                })
                ->addColumn('no_hp', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->no_hp;
                    return $actionBtn;
                })
                ->addColumn('email', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->email;
                    return $actionBtn;
                })
                ->addColumn('jenis_member', function ($row) {
                    $actionBtn = (isset($row->lembaga_id)) ? 'Lembaga' : "Perseorangan";
                    return $actionBtn;
                })
                ->addColumn('regist_oleh', function ($row) {
                    $actionBtn = is_null($row->informasi_akun()->first()->verified_log()->where('jenis_verifikasi_id', JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Calon Anggota')->first()->jenis_verifikasi_id)->first()) ? "Belum diverifikasi" : $row->informasi_akun()->first()->verified_log()->where('jenis_verifikasi_id', JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Calon Anggota')->first()->jenis_verifikasi_id)->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.verifikasi.show', $row->informasi_akun_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/verifikasi_calon_anggota/index');
    }

    public function store(Request $request, InformasiAkun $calon)
    {
        $request->validate([
            'tanggal_verifikasi' => ['required', 'date'],
            'is_agree' => ['required']
        ]);

        $jenis = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Calon Anggota')->first();
        $statusMember = StatusMember::where('nama_status', 'Aktif')->first();

        $verified = new VerifiedLog();
        $verified->informasi_akun_id = $calon->informasi_akun_id;
        $verified->admin_id = Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id;
        $verified->jenis_verifikasi_id = $jenis->jenis_verifikasi_id;
        $verified->is_agree = $request->is_agree == 'true' ? true : false;
        $verified->tanggal_verifikasi = $request->tanggal_verifikasi != '' ? $request->tanggal_verifikasi : date('Y-md-d');
        $verified->keterangan = $request->keterangan;
        $verified->save();

        if (is_null($calon->jaminan()->first())) {
            $calon->jaminan()->create([
                'total_saldo_jaminan' => 0,
                'saldo_teralokasi' => 0,
                'saldo_tersedia' => 0,
            ]);
        }

        if (!is_null($calon->member()->first())) {
            $calon->member()->first()->update([
                'status_member_id' => $statusMember->status_member_id
            ]);
        } else {
            $calon->lembaga()->first()->update([
                'status_member_id' => $statusMember->status_member_id
            ]);
        }

        return redirect('/master/anggota/verifikasi/' . $calon->informasi_akun_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Calon Anggota telah diverifikasi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiAkun $calon)
    {
        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Calon Anggota')->first();
        $dokumen = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/verifikasi_calon_anggota/show', compact('calon', 'dokumen', 'jenisVerifikasi'));
    }
}
