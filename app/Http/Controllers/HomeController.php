<?php

namespace App\Http\Controllers;

use App\Models\ApprovalLelang;
use App\Models\DokumenProduk;
use App\Models\Jaminan;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Komoditas;
use App\Models\Lelang;
use App\Models\Member;
use App\Models\Npwp;
use App\Models\Provinsi;
use App\Models\Role;
use App\Models\StatusKontrak;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request)
    {
        if (is_null(Auth::user()->operator_pasar_lelang()->first())) {
            if (is_null(Auth::user()->informasi_akun()->first()->member()->first()->admin()->first())) {
                // User
                $data = [
                    'kontrak' => Auth::user()->informasi_akun()->first()->kontrak()->count(),
                    'produk' => Lelang::join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->where('kontrak.informasi_akun_id', Auth::user()->informasi_akun_id)->count(),
                    'jaminan' => Auth::user()->informasi_akun()->first()->jaminan()->first()->total_saldo_jaminan ?? 0,
                    'saldo' => !is_null(Auth::user()->informasi_akun()->first()->rekening_bank()->select(DB::raw('SUM("saldo")'))->first()->sum) ? number_format(Auth::user()->informasi_akun()->first()->rekening_bank()->select(DB::raw('SUM("saldo")'))->first()->sum, 0, ".", ",") : 0,
                ];
            }
            if (Auth::user()->informasi_akun()->first()->member()->first()->role()->where('nama_role', 'ROLE_DINAS')->count() > 0) {
                //Dinas
                $data = [
                    'anggota' => Member::count(),
                    'produk' => Lelang::join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->count(),
                    'jaminan' => Jaminan::selectRaw('SUM(total_saldo_jaminan)')->first()->sum,
                    'transaksi' => ApprovalLelang::selectRaw('SUM("harga_pemenang")')->join('lelang', 'lelang.lelang_id', 'approval_lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->first()->sum ?? 0,
                    'summary_anggota' => StatusMember::get(), // Nama Status | Jumlah Member
                    'role_anggota' => Role::get(), // Nama Role | Jumlah Member
                ];
            }
            if (!is_null(Auth::user()->informasi_akun()->first()->member()->first()->admin()->first())) {
                // Admin
                $data = [
                    'komoditas' => Komoditas::count(),
                    'transaksi' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('approval_lelang.harga_pemenang'),
                    'produk' => Lelang::count(),
                    'anggota' => Member::count(),
                    'lelang' => [
                        'today' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereDate('lelang.created_at', Carbon::today())->sum('approval_lelang.harga_pemenang'),
                        'week' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('approval_lelang.harga_pemenang'),
                        'month' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('approval_lelang.harga_pemenang'),
                        'year' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('approval_lelang.harga_pemenang'),


                        'online' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', false)->where('jenis_platform_lelang.online', true)->sum('approval_lelang.harga_pemenang'),
                        'offline' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', false)->sum('approval_lelang.harga_pemenang'),
                        'hybrid' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', true)->sum('approval_lelang.harga_pemenang'),
                    ],
                    'produkData' => [
                        'today' => Lelang::whereDate('lelang.created_at', Carbon::today())->count(),
                        'week' => Lelang::whereBetween('lelang.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
                        'month' => Lelang::whereBetween('lelang.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count(),
                        'year' => Lelang::whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count(),
                        'online' => Lelang::join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', false)->where('jenis_platform_lelang.online', true)->count(),
                        'offline' => Lelang::join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', false)->count(),
                        'hybrid' => Lelang::join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', true)->count(),
                    ]
                ];
            }
        }

        if (!is_null(Auth::user()->operator_pasar_lelang()->first())) {
            // Operator
            $data = [
                'komoditas' => Komoditas::count(),
                'transaksi' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('approval_lelang.harga_pemenang'),
                'produk' => Lelang::count(),
                'anggota' => Member::count(),
                'lelang' => [
                    'today' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereDate('lelang.created_at', Carbon::today())->sum('approval_lelang.harga_pemenang'),
                    'week' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('approval_lelang.harga_pemenang'),
                    'month' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('approval_lelang.harga_pemenang'),
                    'year' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('approval_lelang.harga_pemenang')
                ],
                'produkData' => [
                    'today' => Lelang::whereDate('lelang.created_at', Carbon::today())->count(),
                    'week' => Lelang::whereBetween('lelang.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
                    'month' => Lelang::whereBetween('lelang.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count(),
                    'year' => Lelang::whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count(),

                ]
            ];
        }

        $ca = StatusMember::where('nama_status', 'Calon Anggota')->first()->member()->select('member.informasi_akun_id')->addSelect('member.created_at')->addSelect('ktp.nama')->join('ktp', 'ktp.member_id', 'member.member_id')->orderBy('member.created_at', 'asc')->limit(5)->get();
        $kontrak = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first()->kontrak()->select('kontrak.kontrak_id')->addSelect('kontrak.created_at')->addSelect('komoditas.nama_komoditas')->addSelect('jenis_perdagangan.nama_perdagangan')->join('jenis_perdagangan', 'jenis_perdagangan.jenis_perdagangan_id', 'kontrak.jenis_perdagangan_id')->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')->orderBy('kontrak.created_at', 'asc')->limit(5)->get();
        return view('home', compact('data', 'ca', 'kontrak'));
    }

    public function provinsi()
    {
        $provinsi = Provinsi::get();
        return response()->json([
            "data" => $provinsi,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }

    public function kabupaten(Provinsi $provinsi)
    {
        $kabupaten = $provinsi->kabupaten()->get();
        return response()->json([
            "data" => $kabupaten,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }

    public function kecamatan(Kabupaten $kabupaten)
    {
        $kecamatan = $kabupaten->kecamatan()->get();
        return response()->json([
            "data" => $kecamatan,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }

    public function desa(Kecamatan $kecamatan)
    {
        $desa = $kecamatan->desa()->get();
        return response()->json([
            "data" => $desa,
            'message' => 'data has been fetched',
            'status' => 200
        ], 200);
    }

    public function api(Request $request)
    {
        $request->validate([
            'jenis' => ['required']
        ]);

        if ($request->jenis == 'transaksi_lelang') {
            return response()->json([
                'status' => true,
                'message' => 'data has been catched',
                'data' => [
                    'lelang' => [
                        'online' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', false)->where('jenis_platform_lelang.online', true)->sum('approval_lelang.harga_pemenang'),
                        'offline' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', false)->sum('approval_lelang.harga_pemenang'),
                        'hybrid' => Lelang::join('approval_lelang', 'approval_lelang.lelang_id', 'lelang.lelang_id')->join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', true)->sum('approval_lelang.harga_pemenang'),
                    ],
                    'produk' => [
                        'online' => Lelang::join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', false)->where('jenis_platform_lelang.online', true)->count(),
                        'offline' => Lelang::join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', false)->count(),
                        'hybrid' => Lelang::join('jenis_platform_lelang', 'jenis_platform_lelang.lelang_id', 'lelang.lelang_id')->whereBetween('lelang.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('jenis_platform_lelang.offline', true)->where('jenis_platform_lelang.online', true)->count(),
                    ]
                ]
            ], 200);
        }
    }

    public function profil()
    {
        return view('auth/profil');
    }
    public function profil_update(Request $request)
    {
        $request->validate([
            'nik' => ['required'],
            'nama' => ['required'],
            'jenis_kelamin' => ['required'],
            'tempat_lahir' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'no_hp' => ['required'],
            'no_wa' => ['required'],
            'no_fax' => ['required'],
            'pendapatan_tahunan' => ['required'],
            'pekerjaan' => ['required'],
            'kekayaan_bersih' => ['required'],
            'kekayaan_bersih' => ['required'],
            'kekayaan_lancar' => ['required'],
            'sumber_dana' => ['required'],
            'npwp' => ['required'],
        ]);

        Auth::user()->informasi_akun()->first()->update([
            'no_hp' => request('no_hp'),
            'no_wa' => request('no_wa'),
            'no_fax' => request('no_fax'),
        ]);

        if (!is_null(Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first())) {
            Auth::user()->informasi_akun()->first()->member()->first()->ktp()->first()->update([
                'nik' => request('nik'),
                'nama' => request('nama'),
                'jenis_kelamin' => request('jenis_kelamin'),
                'tempat_lahir' => request('tempat_lahir'),
                'tempat_lahir' => request('tempat_lahir'),
                'tanggal_lahir' => request('tanggal_lahir'),
            ]);

            if (!is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first())) {
                Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->update([
                    'pendapatan_tahunan' => request('pendapatan_tahunan'),
                    'pekerjaan' => request('pekerjaan'),
                    'kekayaan_bersih' => str_replace(',', '', request('kekayaan_bersih')),
                    'kekayaan_lancar' => str_replace(',', '', request('kekayaan_lancar')),
                    'keterangan' => request('keterangan'),
                    'sumber_dana' => request('sumber_dana'),
                ]);

                if (!is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->npwp()->first())) {
                    Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->npwp()->first()->update([
                        'npwp' => request('npwp')
                    ]);
                } else {
                    Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()->npwp()->create([
                        'npwp' => request('npwp')
                    ]);
                }
            } else {
                if (is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first())) {
                    $npwp = Npwp::create([
                        'npwp' => request('npwp')
                    ]);

                    $informasiKeuangan = Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->create([
                        'pendapatan_tahunan' => request('pendapatan_tahunan'),
                        'pekerjaan' => request('pekerjaan'),
                        'kekayaan_bersih' => str_replace(',', '', request('kekayaan_bersih')),
                        'kekayaan_lancar' => str_replace(',', '', request('kekayaan_lancar')),
                        'keterangan' => request('keterangan'),
                        'sumber_dana' => request('sumber_dana'),
                        'npwp_id' => $npwp->npwp_id
                    ]);
                } else {
                    $informasiKeuangan = Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->create([
                        'pendapatan_tahunan' => request('pendapatan_tahunan'),
                        'pekerjaan' => request('pekerjaan'),
                        'kekayaan_bersih' => str_replace(',', '', request('kekayaan_bersih')),
                        'kekayaan_lancar' => str_replace(',', '', request('kekayaan_lancar')),
                        'keterangan' => request('keterangan'),
                        'sumber_dana' => request('sumber_dana')
                    ]);

                    $informasiKeuangan->npwp()->first()->update([
                        'npwp' => request('npwp')
                    ]);
                }
            }
        }

        return redirect('/profil')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Profil telah diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
    public function profil_edit()
    {
        return view('auth/profil_edit');
    }
    public function area()
    {
        return view('auth/area');
    }
    public function rekening_bank()
    {
        return view('auth/rekening_bank');
    }
    public function dokumen()
    {
        return view('auth/dokumen');
    }

    public function get_dokumen_lelang(DokumenProduk $dokumenProduk)
    {
        $storage = Storage::get("public/produk/" . $dokumenProduk->nama_file);


        if (is_null($storage)) {
            return response()->json(['message' => 'Dokumen not found.'], 404);
        }

        return response($storage)->header("Content-Type", 'image/jpeg');
    }

    public function profil_pw()
    {
        return view('auth/password_change');
    }
    public function profil_pw_edit(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'min:6'],
            'new_password' => ['required', 'min:6'],
            'confirmation_password' => ['required', 'min:6'],
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            if ($request->new_password == $request->confirmation_password) {
                Userlogin::where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return redirect('/profil/password')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Password Berhasil Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/profil/password')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Konfirmasi Password Tidak Sesuai.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/profil/password')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Password Lama Salah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
}
