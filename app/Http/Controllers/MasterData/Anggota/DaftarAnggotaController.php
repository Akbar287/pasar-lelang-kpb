<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\InformasiAkun;
use App\Models\JenisDokumen;
use App\Models\JenisVerifikasi;
use App\Models\StatusMember;
use App\Models\Suspend;
use App\Models\SuspendType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class DaftarAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = collect()->merge(StatusMember::where('nama_status', 'Aktif')->first()->member()->get())->merge(StatusMember::where('nama_status', 'Aktif')->first()->lembaga()->get());
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
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.list.show', $row->informasi_akun_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/daftar_anggota/index');
    }

    public function show(InformasiAkun $anggota)
    {
        $dokumen = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/daftar_anggota/show', compact('anggota', 'dokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiAkun $anggota)
    {
        $dokumen = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/daftar_anggota/edit', compact('anggota', 'dokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiAkun $anggota)
    {
        if (is_null($anggota->lembaga()->first())) {
            $request->validate([
                "nik" => ['required', 'size:16'],
                "nama" => ['required'],
                "jenis_kelamin" => ['required'],
                "tanggal_lahir" => ['required'],
                "tempat_lahir" => ['required'],
                "no_hp" => ['required'],
                "npwp" => ['required'],
                "pekerjaan" => ['required'],
                "pendapatan_tahunan" => ['required'],
                "kekayaan_bersih" => ['required'],
                "kekayaan_lancar" => ['required'],
                "sumber_dana" => ['required'],
            ]);
        } else {
            $request->validate([
                "nama_lembaga" => ['required'],
                "bidang_usaha" => ['required'],
                "npwp_lembaga" => ['required'],
                "no_hp_lembaga" => ['required']
            ]);
        }

        if ($request->password != '') {
            $anggota->userlogin()->first()->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $anggota->update([
            "no_hp" => $request->no_hp != '' ? $request->no_hp :  $anggota->no_hp,
            "no_wa" => $request->no_wa != '' ? $request->no_wa :  $anggota->no_wa,
            "no_fax" => $request->no_fax != '' ? $request->no_fax : $anggota->no_fax
        ]);

        if (is_null($anggota->lembaga()->first())) {
            $anggota->member()->first()->ktp()->first()->update([
                'nik' => $request->nik != '' ? $request->nik : $anggota->member()->first()->ktp()->first()->nik,
                'nama' => $request->nama != '' ? $request->nama : $anggota->member()->first()->ktp()->first()->nama,
                'jenis_kelamin' => $request->jenis_kelamin != '' ? $request->jenis_kelamin : $anggota->member()->first()->ktp()->first()->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir != '' ? $request->tempat_lahir : $anggota->member()->first()->ktp()->first()->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir != '' ? $request->tanggal_lahir : $anggota->member()->first()->ktp()->first()->tanggal_lahir,
            ]);

            $anggota->member()->first()->informasi_keuangan()->first()->update([
                "pekerjaan" => $request->pekerjaan,
                "pendapatan_tahunan" => $request->pendapatan_tahunan,
                "kekayaan_bersih" => str_replace(',', '', $request->kekayaan_bersih),
                "kekayaan_lancar" => str_replace(',', '', $request->kekayaan_lancar),
                "sumber_dana" => $request->sumber_dana,
            ]);

            $anggota->member()->first()->informasi_keuangan()->first()->npwp()->first()->update([
                'npwp' => $request->npwp
            ]);

            return redirect('/master/anggota/list/' . $anggota->informasi_akun_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $anggota->lembaga()->first()->update([
                'nama_lembaga' => $request->nama_lembaga,
                'bidang_usaha' => $request->bidang_usaha
            ]);

            $anggota->lembaga()->first()->npwp()->first()->update([
                'npwp' => $request->npwp_lembaga
            ]);

            return redirect('/master/anggota/list/' . $anggota->informasi_akun_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lembaga telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    public function suspend_index(Request $request, InformasiAkun $anggota)
    {
        $suspends = SuspendType::get();
        return view('master_data/anggota_pasar_lelang/daftar_anggota/suspend', compact('anggota', 'suspends'));
    }
    public function suspend(Request $request, InformasiAkun $anggota)
    {
        $request->validate([
            'suspend_type_id' => ['required']
        ]);

        $status = StatusMember::where('nama_status', 'Suspend')->first();
        $jenis = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Suspend Anggota')->first();

        $verified = $anggota->verified_log()->create([
            'admin_id' => Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->admin_id,
            'jenis_verifikasi_id' => $jenis->jenis_verifikasi_id,
            'is_agree' => true,
            'tanggal_verifikasi' => date('Y-m-d'),
            'keterangan' => $request->keterangan
        ]);

        if (!is_null($anggota->member()->first())) {
            $anggota->member()->first()->update([
                'status_member_id' => $status->status_member_id
            ]);
        } else {
            $anggota->lembaga()->first()->update([
                'status_member_id' => $status->status_member_id
            ]);
        }

        $suspendtype = SuspendType::where('suspend_type_id', $request->suspend_type_id)->first();

        $urutan = Suspend::count();
        $suspendtype->suspend()->create([
            'verified_log_id' => $verified->verified_log_id,
            'suspend_kode' => $this->suspendCode($urutan),
            'tanggal_suspend' => date('Y-m-d')
        ]);

        return redirect('/master/anggota/list')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota telah di suspend.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function suspendCode($urutan)
    {
        return 'SUSPEND/' . date('Y') . '/' . $urutan;
    }
}
