<?php

namespace App\Http\Controllers;

use App\Models\EventLelang;
use App\Models\InformasiAkun;
use App\Models\Jaminan;
use App\Models\JenisPerdagangan;
use App\Models\JenisPlatformLelang;
use App\Models\Komoditas;
use App\Models\Kontrak;
use App\Models\Lelang;
use App\Models\Member;
use App\Models\OfflineProfile;
use App\Models\RekeningPusat;
use App\Models\Role;
use App\Models\StatusKontrak;
use App\Models\StatusMember;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EksekutifController extends Controller
{
    public function index(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Anggota Pasar Lelang",
                "icon" => "users",
                "url" => route('eksekutif.anggota'),
                "color" => "primary"
            ],
            [
                "nama" => "Saldo Jaminan",
                "icon" => "percent",
                "url" => route('eksekutif.saldo-jaminan'),
                "color" => "info"
            ],
            [
                "nama" => "Kontrak Lelang",
                "icon" => "file",
                "url" => route('eksekutif.kontrak-lelang'),
                "color" => "success"
            ],
            [
                "nama" => "Produk Lelang",
                "icon" => "box",
                "url" => route('eksekutif.produk-lelang'),
                "color" => "danger"
            ],
            [
                "nama" => "Event Lelang",
                "icon" => "building",
                "url" => route('eksekutif.event-lelang'),
                "color" => "danger"
            ]
        ];
        return view('eksekutif.index', compact('allMenu'));
    }
    public function anggota_view(Request $request)
    {
        $statusMember = StatusMember::get();
        $role = Role::get();
        $member = Member::get();
        $anggota = [
            'anggota_aktif' => $statusMember->where('nama_status', 'Aktif')->first()->member()->count(),
            'anggota_tidak_aktif' => $statusMember->where('nama_status', 'Tidak Aktif')->first()->member()->count(),
            'anggota_kontrak' => InformasiAkun::join('kontrak', 'kontrak.informasi_akun_id', 'informasi_akun.informasi_akun_id')->count(),
            'tidak_login' => InformasiAkun::join('userlogin', 'userlogin.informasi_akun_id', 'informasi_akun.informasi_akun_id')->where('last_login', '<', Carbon::now()->subDays(60))->count()
        ];
        return view('eksekutif.anggota', compact('statusMember', 'member', 'role', 'anggota'));
    }
    public function saldo_jaminan_view(Request $request)
    {
        $jaminan = [
            'member' => Member::select('ktp.nama')->addSelect('ktp.nik')->addSelect('jaminan.*')->join('ktp', 'ktp.member_id', 'member.member_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->join('jaminan', 'jaminan.informasi_akun_id', 'informasi_akun.informasi_akun_id')->get(),
            'total_saldo_jaminan' => Jaminan::selectRaw('SUM("total_saldo_jaminan") as total_saldo_jaminan')->first()->total_saldo_jaminan,
            'total_saldo_teralokasi' => Jaminan::selectRaw('SUM("saldo_teralokasi") as saldo_teralokasi')->first()->saldo_teralokasi,
            'total_saldo_bebas' => Jaminan::selectRaw('SUM("saldo_tersedia") as saldo_tersedia')->first()->saldo_tersedia,
            'total_saldo_rekening_pusat' => RekeningPusat::selectRaw('SUM("saldo") as saldo')->first()->saldo,
            'rekening_pusat' => RekeningPusat::select('bank.nama_bank')
                ->addSelect('rekening_pusat.nomor_rekening')
                ->addSelect('rekening_pusat.cabang')
                ->addSelect('rekening_pusat.mata_uang')
                ->addSelect('rekening_pusat.saldo')
                ->addSelect('rekening_pusat.status')
                ->join('bank', 'bank.bank_id', 'rekening_pusat.bank_id')
                ->get()
        ];
        return view('eksekutif.saldo_jaminan', compact('jaminan'));
    }
    public function kontrak_lelang_view(Request $request)
    {
        $kontrak = Kontrak::count();
        $statusKontrak = StatusKontrak::get();
        $kontrak = [
            'total_kontrak' => $kontrak,
            'total_kontrak_aktif' => $statusKontrak->where('nama_status', 'Aktif')->first()->kontrak()->count(),
            'total_kontrak_verifikasi' => $statusKontrak->where('nama_status', 'Pendaftar Baru')->first()->kontrak()->count(),
            'total_kontrak_tidak_aktif' => $statusKontrak->where('nama_status', 'Non-Aktif')->first()->kontrak()->count(),
            'list_anggota' => Member::get()
        ];
        return view('eksekutif.kontrak_lelang', compact('kontrak'));
    }
    public function produk_lelang_view(Request $request)
    {
        $produk = [
            'total_produk' =>  Lelang::count(),
            'total_produk_terjual' => Lelang::join('approval_lelang', 'lelang.lelang_id', 'approval_lelang.lelang_id')->count(),
            'total_produk_tidak_jual' => Lelang::leftJoin('approval_lelang', 'lelang.lelang_id', 'approval_lelang.lelang_id')->where('approval_lelang_id', null)->count(),
            'total_produk_konfirmasi' => Lelang::leftJoin('jenis_platform_lelang', 'lelang.lelang_id', 'jenis_platform_lelang.lelang_id')->where('jenis_platform_lelang.jenis_platform_lelang_id', null)->count(),
            'produk_lelang' => Lelang::get(),
        ];
        return view('eksekutif.produk_lelang', compact('produk'));
    }
    public function event_lelang_view(Request $request)
    {
        $event = [
            'total_event_lelang' => EventLelang::count(),
            'total_event_lelang_hybrid' => EventLelang::where('is_online', true)->count(),
            'total_event_lelang_offline' => EventLelang::where('is_online', false)->count(),
            'total_event_bulan' => EventLelang::whereBetween('tanggal_lelang', [Carbon::now()->subMonth()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])->count(),
        ];
        return view('eksekutif.event_lelang', compact('event'));
    }
    public function saldo_jaminan(Request $request)
    {
        $request->validate(['type' => 'required']);

        if ($request->type == 'grafik_sebaran') {
            $jaminan = [
                'saldo_teralokasi' => Jaminan::selectRaw('SUM("saldo_teralokasi")')->first()->sum,
                'saldo_tersedia' => Jaminan::selectRaw('SUM("saldo_tersedia")')->first()->sum
            ];
            return response()->json([
                'data' => $jaminan,
                'status' => 'success',
                'message' => 'data has been catched'
            ], 200);
        }

        return response()->json([
            'data' => null,
            'status' => 'failed',
            'message' => 'No request type found'
        ], 404);
    }
    public function kontrak(Request $request)
    {
        $request->validate(['type' => 'required']);

        if ($request->type == 'grafik_sebaran') {
            $k = Komoditas::selectRaw('COUNT("kontrak") as jumlah')->addSelect('komoditas.nama_komoditas')->join('kontrak', 'kontrak.komoditas_id', 'komoditas.komoditas_id')->groupBy('komoditas.nama_komoditas')->get();
            $bg = [];
            $label = [];
            $data = [];

            foreach ($k as $kl) {
                $label[] = $kl->nama_komoditas;
                $data[] = $kl->jumlah;
                $bg[] = 'rgb(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ')';
            }
            unset($k);
            $komoditas = [
                'label' => $label,
                'bgColor' => $bg,
                'data' => $data
            ];

            $perdagangan = JenisPerdagangan::selectRaw('COUNT("kontrak") as jumlah')->addSelect('jenis_perdagangan.nama_perdagangan')->join('kontrak', 'kontrak.jenis_perdagangan_id', 'jenis_perdagangan.jenis_perdagangan_id')->groupBy('jenis_perdagangan.nama_perdagangan')->get();

            $bg = [];
            $label = [];
            $data = [];

            foreach ($perdagangan as $p) {
                $label[] = $p->nama_perdagangan;
                $data[] = $p->jumlah;
                $bg[] = 'rgb(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ')';
            }

            $perdagangan = [
                'label' => $label,
                'bgColor' => $bg,
                'data' => $data
            ];

            return response()->json([
                'data' => [
                    'komoditas' => $komoditas,
                    'perdagangan' => $perdagangan
                ],
                'status' => 'success',
                'message' => 'data has been catched'
            ], 200);
        }

        return response()->json([
            'data' => null,
            'status' => 'failed',
            'message' => 'No request type found'
        ], 404);
    }
    public function produk(Request $request)
    {
        $request->validate(['type' => 'required']);

        if ($request->type == 'grafik_sebaran') {
            $lelang = Lelang::selectRaw('COUNT("approval_lelang_id") as sukses, COUNT(*) as semua')->leftJoin('approval_lelang', 'lelang.lelang_id', 'approval_lelang.lelang_id')->first();

            $platform = [
                'online' => JenisPlatformLelang::where('online', true)->where('offline', false)->count(),
                'offline' => JenisPlatformLelang::where('online', false)->where('offline', true)->count(),
                'hybrid' => JenisPlatformLelang::where('online', true)->where('offline', true)->count(),
            ];
            return response()->json([
                'data' => [
                    'lelang_sukses' => $lelang,
                    'lelang_platform' => $platform
                ],
                'status' => 'success',
                'message' => 'data has been catched'
            ], 200);
        }

        return response()->json([
            'data' => null,
            'status' => 'failed',
            'message' => 'No request type found'
        ], 404);
    }
    public function event(Request $request)
    {
        $request->validate(['type' => 'required']);

        if ($request->type == 'event_detail') {

            $event = EventLelang::where('event_lelang_id', $request->data)->first();

            $penjual = [];
            $produk = [];

            foreach ($event->lelang()->get() as $l) {
                $produk[] = [
                    'nomor_lelang' => $l->nomor_lelang,
                    'komoditas' => $l->kontrak()->first()->komoditas()->first()->nama_komoditas,
                    'judul' => $l->judul,
                    'harga_awal' => $l->harga_awal,
                    'kelipatan' => $l->kelipatan_penawaran,
                    'harga_pemenang' => !is_null($l->approval_lelang()->first()) ? $l->approval_lelang()->first()->harga_pemenang : '0',
                    'status' => !is_null($l->approval_lelang()->first()) ? 'Terjual' : 'Tidak',
                ];

                $penjual[] = [
                    'nama_penjual' => $l->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama,
                    'komoditas' => $l->kontrak()->first()->komoditas()->first()->nama_komoditas,
                ];
            }

            $total_penjualan = 0;
            foreach ($event->lelang()->get() as $l) {
                $total_penjualan += is_null($l->approval_lelang()->first()) ? 0 : $l->approval_lelang()->first()->harga_pemenang;
            }

            $data = [
                'deskripsi' => [
                    'event_kode' => $event->event_kode,
                    'jam_mulai' => $event->jam_mulai,
                    'nama_lelang' => $event->nama_lelang,
                    'jam_selesai' => $event->jam_selesai,
                    'tanggal_lelang' => Carbon::createFromFormat('Y-m-d', $event->tanggal_lelang)->format('d F Y'),
                    'total_peserta' => $event->daftar_peserta_lelang()->count(),
                    'lokasi' => $event->lokasi,
                    'total_produk' => $event->lelang()->count(),
                    'ketua_lelang' => $event->ketua_lelang,
                    'status' => $event->status_event_lelang()->first()->nama_status,
                    'total_penjualan' => $total_penjualan
                ],
                'peserta' => $event->daftar_peserta_lelang()->select('daftar_peserta_lelang.kode_peserta_lelang')->addSelect('ktp.nama')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'daftar_peserta_lelang.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('ktp', 'ktp.member_id', 'member.member_id')->orderBy('daftar_peserta_lelang.kode_peserta_lelang')->get(),
                'penjual' => $penjual,
                'produk' => $produk
            ];

            return response()->json([
                'data' => $data,
                'status' => 'success',
                'message' => 'data has been catched'
            ], 200);
        }

        return response()->json([
            'data' => null,
            'status' => 'failed',
            'message' => 'No request type found'
        ], 404);
    }
    public function transaksi_lelang(Request $request)
    {
    }

    public function api_home(Request $request)
    {
        $member = Member::select('member.*')->addSelect('role.nama_role')->addSelect('status_member.nama_status')->join('status_member', 'status_member.status_member_id', 'member.status_member_id')->join('role_member', 'role_member.member_id', 'member.member_id')->join('role', 'role.role_id', 'role_member.role_id')->get();

        return response()->json([
            'message' => 'data has been catched',
            'status' => 'success',
            'data' => [
                'produk' => [
                    'produk_lelang' => Lelang::count(),
                    'jaminan' => Jaminan::selectRaw('SUM("total_saldo_jaminan") as sum')->first()->sum,
                    'transaksi' => 0,
                    'event_lelang' => EventLelang::count()
                ],
                'anggota' => [
                    'total_anggota' => Member::count(),
                    'aktif' => StatusMember::where('nama_status', 'Aktif')->count(),
                    'calon_anggota' => StatusMember::where('nama_status', 'Calon Anggota')->count(),
                    'pembeli' => Role::where('nama_role', 'ROLE_PEMBELI')->first()->member()->count(),
                    'penyelenggara' => OfflineProfile::count(),
                ],
                'produk_lelang' => 0,
                'produk_lelang' => 0,
            ]
        ], 200);
    }
}
