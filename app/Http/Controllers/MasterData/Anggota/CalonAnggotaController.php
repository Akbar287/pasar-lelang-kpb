<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\AreaMember;
use App\Models\Bank;
use App\Models\DokumenMember;
use App\Models\InformasiAkun;
use App\Models\InformasiKeuangan;
use App\Models\JenisDokumen;
use App\Models\Ktp;
use App\Models\Lembaga;
use App\Models\LembagaInformasiPic;
use App\Models\Member;
use App\Models\Npwp;
use App\Models\Provinsi;
use App\Models\RekeningBank;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CalonAnggotaController extends Controller
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
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.anggota.calon.show', $row->informasi_akun_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/anggota_pasar_lelang/calon_anggota/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = Provinsi::get();
        $banks = Bank::get();
        $dokumen = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/calon_anggota/create', compact('provinsi', 'banks', 'dokumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "jenis_perseorangan" => ['required'],
            "nik" => ['required', 'size:16'],
            "nama" => ['required'],
            "jenis_kelamin" => ['required'],
            "npwp" => ['required'],
            "email" => ['required', 'email'],
            "tanggal_lahir" => ['required'],
            "tempat_lahir" => ['required'],
            "no_hp" => ['required'],
            "username" => ['required', 'unique:App\Models\Userlogin,username'],
            "password" => ['required'],
            "provinsi" => ['required'],
            "kabupaten" => ['required'],
            "kecamatan" => ['required'],
            "desa" => ['required'],
            "alamat" => ['required'],
            "kode_pos" => ['required'],
            "pekerjaan" => ['required'],
            "pendapatan_tahunan" => ['required'],
            "kekayaan_bersih" => ['required'],
            "kekayaan_lancar" => ['required'],
            "sumber_dana" => ['required'],
            "nama_bank" => ['required'],
            "nomor_rekening" => ['required'],
            "nama_pemilik" => ['required'],
            "cabang" => ['required'],
            "mata_uang" => ['required'],
        ]);

        if ($request->jenis_perseorangan == 'lembaga') {
            $request->validate([
                "nama_lembaga" => ['required'],
                "bidang_usaha" => ['required'],
                "npwp_lembaga" => ['required'],
                "email_lembaga" => ['required', 'email'],
                "no_hp_lembaga" => ['required'],
                "username_lembaga" => ['required', 'unique:App\Models\Userlogin,username'],
                "password_lembaga" => ['required'],
                "provinsi_lembaga" => ['required'],
                "kabupaten_lembaga" => ['required'],
                "kecamatan_lembaga" => ['required'],
                "desa_lembaga" => ['required'],
                "alamat_lembaga" => ['required'],
                "kode_pos_lembaga" => ['required'],
                "nama_bank_lembaga" => ['required'],
                "nomor_rekening_lembaga" => ['required'],
                "nama_pemilik_lembaga" => ['required'],
                "cabang_lembaga" => ['required'],
                "mata_uang_lembaga" => ['required'],
            ]);
        }

        $informasi = new InformasiAkun();
        $informasi->email = $request->email;
        $informasi->no_hp = $request->no_hp;
        $informasi->no_wa = $request->no_wa;
        $informasi->no_fax = $request->no_fax;
        $informasi->avatar = 'default.png';
        $informasi->save();

        $area = new AreaMember();
        $area->desa_id = $request->desa;
        $area->kode_pos = $request->kode_pos;
        $area->alamat = $request->alamat;
        $area->alamat_ke = 1;
        $area->save();

        DB::table('area_member_informasi_akun')->insert([
            'informasi_akun_id' => $informasi->informasi_akun_id,
            'area_member_id' => $area->area_member_id
        ]);

        $statusMember = StatusMember::where('nama_status', 'Calon Anggota')->first();

        $member = new Member();
        $member->informasi_akun_id = $informasi->informasi_akun_id;
        $member->status_member_id = $statusMember->status_member_id;
        $member->save();

        $npwp = new Npwp();
        $npwp->npwp = $request->npwp;
        $npwp->save();

        $informasiKeuangan = new InformasiKeuangan();
        $informasiKeuangan->npwp_id = $npwp->npwp_id;
        $informasiKeuangan->member_id = $member->member_id;
        $informasiKeuangan->pekerjaan = $request->pekerjaan;
        $informasiKeuangan->pendapatan_tahunan = $request->pendapatan_tahunan;
        $informasiKeuangan->kekayaan_bersih = str_replace(',', '', $request->kekayaan_bersih);
        $informasiKeuangan->kekayaan_lancar = str_replace(',', '', $request->kekayaan_lancar);
        $informasiKeuangan->sumber_dana = $request->sumber_dana;
        $informasiKeuangan->keterangan = $request->keterangan;
        $informasiKeuangan->save();

        $rekening = new RekeningBank();
        $rekening->informasi_akun_id = $informasi->informasi_akun_id;
        $rekening->bank_id = $request->nama_bank;
        $rekening->nomor_rekening = $request->nomor_rekening;
        $rekening->nama_pemilik = $request->nama_pemilik;
        $rekening->cabang = $request->cabang;
        $rekening->mata_uang = $request->mata_uang;
        $rekening->nilai_awal = 0;
        $rekening->saldo = 0;
        $rekening->save();

        $ktp = new Ktp();
        $ktp->member_id = $member->member_id;
        $ktp->nik = $request->nik;
        $ktp->nama = $request->nama;
        $ktp->jenis_kelamin = $request->jenis_kelamin;
        $ktp->tanggal_lahir = $request->tanggal_lahir;
        $ktp->tempat_lahir = $request->tempat_lahir;
        $ktp->verified = false;
        $ktp->save();

        $userlogin = new Userlogin();
        $userlogin->informasi_akun_id = $informasi->informasi_akun_id;
        $userlogin->username = $request->username;
        $userlogin->password = Hash::make($request->password);
        $userlogin->is_aktif = true;
        $userlogin->save();

        if (count($request->file) > 0) {
            $keys = array_keys($request->file);
            for ($i = 0; $i < count($request->file); $i++) {
                $filenameWithExt = $request->file[$i]->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file[$i]->getClientOriginalExtension();
                $foto = $filename . '_' . time() . '.' . $extension;
                $request->file[$i]->storeAs('public/dokumen_member', $foto);

                $jenis = JenisDokumen::where('nama_jenis', $request->jenis_file[$keys[$i]])->first();
                $dokumen = new DokumenMember();
                $dokumen->jenis_dokumen_id = $jenis->jenis_dokumen_id;
                $dokumen->informasi_akun_id = $informasi->informasi_akun_id;
                $dokumen->versi_unggah = 1;
                $dokumen->tanggal_unggah = date('Y-m-d');
                $dokumen->nama_dokumen = $foto;
                $dokumen->nama_file = $foto;
                $dokumen->save();
            }
        }


        if ($request->jenis_perseorangan == 'lembaga') {
            $informasi_lembaga = new InformasiAkun();
            $informasi_lembaga->email = $request->email_lembaga;
            $informasi_lembaga->no_hp = $request->no_hp_lembaga;
            $informasi_lembaga->no_wa = $request->no_wa_lembaga;
            $informasi_lembaga->no_fax = $request->no_fax_lembaga;
            $informasi_lembaga->avatar = 'default.png';
            $informasi_lembaga->save();

            $area_lembaga = new AreaMember();
            $area_lembaga->desa_id = $request->desa_lembaga;
            $area_lembaga->kode_pos = $request->kode_pos_lembaga;
            $area_lembaga->alamat = $request->alamat_lembaga;
            $area_lembaga->alamat_ke = 1;
            $area_lembaga->save();

            DB::table('area_member_informasi_akun')->insert([
                'informasi_akun_id' => $informasi_lembaga->informasi_akun_id,
                'area_member_id' => $area_lembaga->area_member_id
            ]);

            $npwp_lembaga = new Npwp();
            $npwp_lembaga->npwp = $request->npwp;
            $npwp_lembaga->save();

            $lembaga = new Lembaga();
            $lembaga->informasi_akun_id = $informasi_lembaga->informasi_akun_id;
            $lembaga->npwp_id = $npwp_lembaga->npwp_id;
            $lembaga->status_member_id = $statusMember->status_member_id;
            $lembaga->nama_lembaga = $request->nama_lembaga;
            $lembaga->bidang_usaha = $request->bidang_usaha;
            $lembaga->is_aktif = true;
            $lembaga->save();

            $userlogin_lembaga = new Userlogin();
            $userlogin_lembaga->informasi_akun_id = $informasi_lembaga->informasi_akun_id;
            $userlogin_lembaga->username = $request->username_lembaga;
            $userlogin_lembaga->password = Hash::make($request->password_lembaga);
            $userlogin_lembaga->is_aktif = true;
            $userlogin_lembaga->save();

            $lembaga_pic = new LembagaInformasiPic();
            $lembaga_pic->lembaga_id = $lembaga->lembaga_id;
            $lembaga_pic->member_id = $member->member_id;
            $lembaga_pic->jabatan = $request->jabatan;
            $lembaga_pic->is_aktif = true;
            $lembaga_pic->save();

            $rekening = new RekeningBank();
            $rekening->informasi_akun_id = $informasi_lembaga->informasi_akun_id;
            $rekening->bank_id = $request->nama_bank_lembaga;
            $rekening->nomor_rekening = $request->nomor_rekening_lembaga;
            $rekening->nama_pemilik = $request->nama_pemilik_lembaga;
            $rekening->cabang = $request->cabang_lembaga;
            $rekening->mata_uang = $request->mata_uang_lembaga;
            $rekening->nilai_awal = 0;
            $rekening->saldo = 0;
            $rekening->save();

            if (count($request->file_lembaga) > 0) {
                $keys = array_keys($request->file);
                for ($i = 0; $i < count($request->file_lembaga); $i++) {
                    $filenameWithExt = $request->file_lembaga[$i]->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file_lembaga[$i]->getClientOriginalExtension();
                    $foto = $filename . '_' . time() . '.' . $extension;
                    $request->file_lembaga[$i]->storeAs('public/dokumen_member_lembaga', $foto);

                    $jenis = JenisDokumen::where('nama_jenis', $request->jenis_file[$keys[$i]])->first();
                    $dokumen = new DokumenMember();
                    $dokumen->jenis_dokumen_id = $jenis->jenis_dokumen_id;
                    $dokumen->informasi_akun_id = $informasi_lembaga->informasi_akun_id;
                    $dokumen->versi_unggah = 1;
                    $dokumen->tanggal_unggah = date('Y-m-d');
                    $dokumen->nama_dokumen = $foto;
                    $dokumen->nama_file = $foto;
                    $dokumen->save();
                }
            }
        }

        if ($request->jenis_perseorangan == 'lembaga') {
            return redirect('/master/anggota/calon/' . $informasi_lembaga->informasi_akun_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lembaga telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/master/anggota/calon/' . $informasi->informasi_akun_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Perseorangan telah ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiAkun $calon)
    {
        $dokumen = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/calon_anggota/show', compact('calon', 'dokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiAkun $calon)
    {
        $provinsi = Provinsi::get();
        $banks = Bank::get();
        $dokumen = JenisDokumen::get();
        return view('master_data/anggota_pasar_lelang/calon_anggota/edit', compact('calon', 'provinsi', 'banks', 'dokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiAkun $calon)
    {
        if (!is_null($calon->member())) {
            $request->validate([
                "nik" => ['required', 'size:16'],
                "nama" => ['required'],
                "jenis_kelamin" => ['required'],
                "npwp" => ['required'],
                "email" => ['required', 'email'],
                "tanggal_lahir" => ['required'],
                "tempat_lahir" => ['required'],
                "no_hp" => ['required'],
                "alamat" => ['required'],
                "kode_pos" => ['required'],
                "pekerjaan" => ['required'],
                "pendapatan_tahunan" => ['required'],
                "kekayaan_bersih" => ['required'],
                "kekayaan_lancar" => ['required'],
                "sumber_dana" => ['required'],
                "nama_bank" => ['required'],
                "nomor_rekening" => ['required'],
                "nama_pemilik" => ['required'],
                "cabang" => ['required'],
                "mata_uang" => ['required'],
            ]);
        } else {
            $request->validate([
                "nama_lembaga" => ['required'],
                "bidang_usaha" => ['required'],
                "npwp_lembaga" => ['required'],
                "email_lembaga" => ['required', 'email'],
                "no_hp_lembaga" => ['required'],
                "alamat_lembaga" => ['required'],
                "kode_pos_lembaga" => ['required'],
                "nama_bank_lembaga" => ['required'],
                "nomor_rekening_lembaga" => ['required'],
                "nama_pemilik_lembaga" => ['required'],
                "cabang_lembaga" => ['required'],
                "mata_uang_lembaga" => ['required'],
            ]);
        }

        if (!is_null($calon->member())) {
            $informasi = $calon;
            $informasi->email = $request->email;
            $informasi->no_hp = $request->no_hp;
            $informasi->no_wa = $request->no_wa;
            $informasi->no_fax = $request->no_fax;
            $informasi->avatar = 'default.png';
            $informasi->save();

            if ($request->desa != null) {
                $area = new AreaMember();
                $area->desa_id = $request->desa;
                $area->kode_pos = $request->kode_pos;
                $area->alamat = $request->alamat;
                $area->alamat_ke = 1;
                $area->save();

                DB::table('area_member_informasi_akun')->where('informasi_akun_id', $informasi->informasi_akun_id)->where('area_member_id', $area->area_member_id)->delete();

                DB::table('area_member_informasi_akun')->insert([
                    'informasi_akun_id' => $informasi->informasi_akun_id,
                    'area_member_id' => $area->area_member_id
                ]);
            }

            $statusMember = StatusMember::where('nama_status', 'Calon Anggota')->first();

            $member = $calon->member()->first();
            $member->informasi_akun_id = $informasi->informasi_akun_id;
            $member->status_member_id = $statusMember->status_member_id;
            $member->save();

            if (!is_null($calon->member()->first())) {
                if (!is_null($calon->member()->first()->informasi_keuangan()->first())) {
                    if (!is_null($calon->member()->first()->informasi_keuangan()->first()->npwp())) {
                        $npwp = $calon->member()->first()->informasi_keuangan()->first()->npwp()->first();
                        $npwp->npwp = $request->npwp;
                        $npwp->save();
                    }

                    $informasiKeuangan = $calon->member()->first()->informasi_keuangan()->first();
                    $informasiKeuangan->npwp_id = $npwp->npwp_id;
                    $informasiKeuangan->member_id = $member->member_id;
                    $informasiKeuangan->pekerjaan = $request->pekerjaan;
                    $informasiKeuangan->pendapatan_tahunan = $request->pendapatan_tahunan;
                    $informasiKeuangan->kekayaan_bersih = str_replace(',', '', $request->kekayaan_bersih);
                    $informasiKeuangan->kekayaan_lancar = str_replace(',', '', $request->kekayaan_lancar);
                    $informasiKeuangan->sumber_dana = $request->sumber_dana;
                    $informasiKeuangan->keterangan = $request->keterangan;
                    $informasiKeuangan->save();
                } else {
                    $npwp = new Npwp();
                    $npwp->npwp = $request->npwp != '' ? $request->npwp : 0;
                    $npwp->save();

                    $informasiKeuangan = new InformasiKeuangan();
                    $informasiKeuangan->npwp_id =  $npwp->npwp_id;
                    $informasiKeuangan->member_id = $member->member_id;
                    $informasiKeuangan->pekerjaan = $request->pekerjaan;
                    $informasiKeuangan->pendapatan_tahunan = $request->pendapatan_tahunan;
                    $informasiKeuangan->kekayaan_bersih = str_replace(',', '', $request->kekayaan_bersih);
                    $informasiKeuangan->kekayaan_lancar = str_replace(',', '', $request->kekayaan_lancar);
                    $informasiKeuangan->sumber_dana = $request->sumber_dana;
                    $informasiKeuangan->keterangan = $request->keterangan;
                    $informasiKeuangan->save();
                }
            } else {
                if (!is_null($calon->lembaga()->first())) {
                    if (!is_null($calon->lembaga()->first()->npwp())) {
                        $npwp = $calon->lembaga()->first()->npwp()->first();
                        $npwp->npwp = $request->npwp;
                        $npwp->save();
                    }
                } else {
                    $npwp = new Npwp();
                    $npwp->npwp = $request->npwp != '' ? $request->npwp : 0;
                    $npwp->save();
                }
            }

            $rekening = !is_null($calon->rekening_bank()->first()) ? $calon->rekening_bank()->first() : new RekeningBank();
            $rekening->informasi_akun_id = $informasi->informasi_akun_id;
            $rekening->bank_id = $request->nama_bank;
            $rekening->nomor_rekening = $request->nomor_rekening;
            $rekening->nama_pemilik = $request->nama_pemilik;
            $rekening->cabang = $request->cabang;
            $rekening->mata_uang = $request->mata_uang;
            $rekening->nilai_awal = 0;
            $rekening->saldo = 0;
            $rekening->save();

            $ktp = $calon->member()->first()->ktp()->first();
            $ktp->member_id = $member->member_id;
            $ktp->nik = $request->nik;
            $ktp->nama = $request->nama;
            $ktp->jenis_kelamin = $request->jenis_kelamin;
            $ktp->tanggal_lahir = $request->tanggal_lahir;
            $ktp->tempat_lahir = $request->tempat_lahir;
            $ktp->verified = false;
            $ktp->save();

            if (isset($request->file)) {
                $keys = array_keys($request->file);
                for ($i = 0; $i < count($keys); $i++) {
                    Storage::delete("storage/dokumen_member/" . $calon->dokumen_member()->where('jenis_dokumen_id', JenisDokumen::where('nama_jenis', $request->jenis_file[$keys[$i]])->first()->jenis_dokumen_id)->first()->nama_file);
                }

                for ($i = 0; $i < count($request->file); $i++) {
                    $filenameWithExt = $request->file[$i]->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file[$i]->getClientOriginalExtension();
                    $foto = $filename . '_' . time() . '.' . $extension;
                    $request->file[$i]->storeAs('public/dokumen_member', $foto);

                    $jenis = JenisDokumen::where('nama_jenis', $request->jenis_file[$keys[$i]])->first();
                    $dokumen = new DokumenMember();
                    $dokumen->jenis_dokumen_id = $jenis->jenis_dokumen_id;
                    $dokumen->informasi_akun_id = $informasi->informasi_akun_id;
                    $dokumen->versi_unggah = 1;
                    $dokumen->tanggal_unggah = date('Y-m-d');
                    $dokumen->nama_dokumen = $foto;
                    $dokumen->nama_file = $foto;
                    $dokumen->save();
                }
            }
        }

        if (!is_null($calon->lembaga()->first())) {
            $informasi_lembaga = $calon;
            $informasi_lembaga->email = $request->email_lembaga;
            $informasi_lembaga->no_hp = $request->no_hp_lembaga;
            $informasi_lembaga->no_wa = $request->no_wa_lembaga;
            $informasi_lembaga->no_fax = $request->no_fax_lembaga;
            $informasi_lembaga->avatar = 'default.png';
            $informasi_lembaga->save();

            if ($request->desa_lembaga != '') {
                $area_lembaga = new AreaMember();
                $area_lembaga->desa_id = $request->desa_lembaga;
                $area_lembaga->kode_pos = $request->kode_pos_lembaga;
                $area_lembaga->alamat = $request->alamat_lembaga;
                $area_lembaga->alamat_ke = 1;
                $area_lembaga->save();

                DB::table('area_member_informasi_akun')->where('informasi_akun_id', $informasi_lembaga->informasi_akun_id)->where('area_member_id', $area_lembaga->area_member_id)->delete();

                DB::table('area_member_informasi_akun')->insert([
                    'informasi_akun_id' => $informasi_lembaga->informasi_akun_id,
                    'area_member_id' => $area_lembaga->area_member_id
                ]);
            }

            $npwp_lembaga = new Npwp();
            $npwp_lembaga->npwp = $request->npwp;
            $npwp_lembaga->save();

            $lembaga = new Lembaga();
            $lembaga->informasi_akun_id = $informasi_lembaga->informasi_akun_id;
            $lembaga->npwp_id = $npwp_lembaga->npwp_id;
            $lembaga->status_member_id = $statusMember->status_member_id;
            $lembaga->nama_lembaga = $request->nama_lembaga;
            $lembaga->bidang_usaha = $request->bidang_usaha;
            $lembaga->is_aktif = true;
            $lembaga->save();

            $rekening = new RekeningBank();
            $rekening->informasi_akun_id = $informasi_lembaga->informasi_akun_id;
            $rekening->bank_id = $request->nama_bank_lembaga;
            $rekening->nomor_rekening = $request->nomor_rekening_lembaga;
            $rekening->nama_pemilik = $request->nama_pemilik_lembaga;
            $rekening->cabang = $request->cabang_lembaga;
            $rekening->mata_uang = $request->mata_uang_lembaga;
            $rekening->nilai_awal = 0;
            $rekening->saldo = 0;
            $rekening->save();

            if (count($request->file_lembaga) > 0) {
                $keys = array_keys($request->file);

                for ($i = 0; $i < count($keys); $i++) {
                    Storage::delete("storage/dokumen_member/" . $calon->dokumen_member()->where('jenis_dokumen_id', JenisDokumen::where('nama_jenis', $request->jenis_file[$keys[$i]])->first()->jenis_dokumen_id)->first()->nama_file);
                }

                for ($i = 0; $i < count($request->file_lembaga); $i++) {
                    $filenameWithExt = $request->file_lembaga[$i]->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file_lembaga[$i]->getClientOriginalExtension();
                    $foto = $filename . '_' . time() . '.' . $extension;
                    $request->file_lembaga[$i]->storeAs('public/dokumen_member_lembaga', $foto);

                    $jenis = JenisDokumen::where('nama_jenis', $request->jenis_file[$keys[$i]])->first();
                    $dokumen = new DokumenMember();
                    $dokumen->jenis_dokumen_id = $jenis->jenis_dokumen_id;
                    $dokumen->informasi_akun_id = $informasi_lembaga->informasi_akun_id;
                    $dokumen->versi_unggah = 1;
                    $dokumen->tanggal_unggah = date('Y-m-d');
                    $dokumen->nama_dokumen = $foto;
                    $dokumen->nama_file = $foto;
                    $dokumen->save();
                }
            }
        }

        if (!is_null($calon->lembaga()->first())) {
            return redirect('/master/anggota/calon/' . $informasi_lembaga->informasi_akun_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lembaga telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/master/anggota/calon/' . $informasi->informasi_akun_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Perseorangan telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformasiAkun $calon)
    {
        for ($i = 0; $i < count($calon->dokumen_member()->get()); $i++) {
            Storage::delete("storage/dokumen_member/" . $calon->dokumen_member()->where('jenis_dokumen_id', JenisDokumen::where('nama_jenis',)->first()->jenis_dokumen_id)->first()->nama_file);
        }

        $calon->delete();

        return redirect('/master/anggota/calon')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
}
