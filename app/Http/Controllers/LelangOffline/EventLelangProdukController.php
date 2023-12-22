<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\DaftarPesertaLelang;
use App\Models\EventLelang;
use App\Models\JenisDokumenProduk;
use App\Models\Lelang;
use App\Models\StatusLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventLelangProdukController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request, EventLelang $event)
    {
        $data = $event->lelang()->paginate(12);
        return view('lelang_offline/event_produk/index', compact('event', 'data'));
    }

    public function show(EventLelang $event, Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('lelang_offline/event_produk/show', compact('event', 'lelang', 'jenisDokumen'));
    }

    public function sesi(EventLelang $event, Lelang $lelang)
    {
        return view('lelang_offline/event_produk/sesi', compact('event', 'lelang'));
    }

    public function sesi_doc(EventLelang $event, Lelang $lelang, Request $request)
    {
        $request->validate([
            'no_surat' => ['required'],
            'tipe_format' => ['required']
        ]);

        $tempPembeli = ($lelang->jenis_platform_lelang()->first()->online == true && $lelang->jenis_platform_lelang()->first()->offline == false) ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->member()->first() : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first();

        $kode = '00';
        if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            $kode = !is_null($lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first() ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first()->kode_peserta_lelang : '-');

            // is_null($lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first()) ? '-' : $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first()->kode_peserta_lelang;
        } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            $kode = !is_null($event->daftar_peserta_lelang()->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first()) ? $event->daftar_peserta_lelang()->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first()->kode_peserta_lelang : '-';
        } else if (!$lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            $kode = !is_null($event->daftar_peserta_lelang()->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first()) ? $event->daftar_peserta_lelang()->where('informasi_akun_id', $tempPembeli->informasi_akun()->first()->informasi_akun_id)->first()->kode_peserta_lelang : '-';
        }

        $pembeli = [
            'kode' => $request->has('no_kode_anggota_penjual') ? $request->no_kode_anggota_penjual : $kode,
            'nama' => $request->has('nama_penjual') ? $request->nama_penjual : (!is_null($tempPembeli->member()->first()) ? $tempPembeli->member()->first()->ktp()->first()->nama : $tempPembeli->lembaga()->first()->nama_lembaga),
            'alamat' => $request->has('alamat_penjual') ? $request->alamat_penjual : (is_null($tempPembeli->area_member()->first()) ? '-' : $tempPembeli->area_member()->first()->alamat),
            'no_hp' => $request->has('no_telp_penjual') ? $request->no_telp_penjual : $tempPembeli->no_hp
        ];
        unset($kode);

        $approval_lelang = null;
        if (is_null($lelang->approval_lelang()->first())) {
            $approval_lelang = $this->createApprovalLelang($lelang);
        } else {
            $approval_lelang = $lelang->approval_lelang()->first();
        }

        $nomor_surat = null;
        if (is_null($approval_lelang->nomor_surat()->first())) {
            $nomor_surat = $approval_lelang->nomor_surat()->create(['no_surat' => $request->no_surat]);
        } else {
            $nomor_surat = $approval_lelang->nomor_surat()->first()->update(['no_surat' => $request->no_surat]);
        }

        if (!is_null($approval_lelang->nomor_surat()->first()->waktu_penyerahan()->first())) {
            if ($approval_lelang->nomor_surat()->first()->waktu_penyerahan()->count() > 0) {
                $approval_lelang->nomor_surat()->first()->waktu_penyerahan()->delete();
            }
        }

        if ($request->has('volume_penyerahan')) {
            for ($i = 0; $i < count($request->waktu_penyerahan); $i++) {
                $approval_lelang->nomor_surat()->first()->waktu_penyerahan()->create(['tanggal' => $request->waktu_penyerahan[$i], 'volume' => $request->volume_penyerahan[$i]]);
            }
        }

        if ($request->tipe_format == 'pdf') {
            if ($lelang->jenis_platform_lelang()->first()->online == true && $lelang->jenis_platform_lelang()->first()->offline == false) {
                return Helper::print_perjanjian_jual_beli($lelang->kontrak()->first()->informasi_akun()->first()->member()->first(), $pembeli, $lelang, null);
            }
            if ($lelang->jenis_platform_lelang()->first()->online == true && $lelang->jenis_platform_lelang()->first()->offline == true) {
                return Helper::print_perjanjian_jual_beli($lelang->kontrak()->first()->informasi_akun()->first()->member()->first(), $pembeli, $lelang, $lelang->event_lelang()->first());
            }
            if ($lelang->jenis_platform_lelang()->first()->online == false && $lelang->jenis_platform_lelang()->first()->offline == true) {
                return Helper::print_perjanjian_jual_beli($lelang->kontrak()->first()->informasi_akun()->first()->member()->first(), $pembeli, $lelang, $lelang->event_lelang()->first());
            }
            return null;
            exit;
        }

        // if ($request->tipe_format == 'word') {
        //     $phpWord = new PhpWord();

        //     $section = $phpWord->addSection();
        //     $section->addText('PERJANJIAN JUAL BELI', ['textAglinment' => 'center', 'lineHeight' => '1.5'], ['indent' => '30.0']);
        //     $section->addText('KOMODITI AGRO DI E-PASAR LELANG', ['textAglinment' => 'center', 'lineHeight' => '1.5'], ['indent' => '30.0']);
        //     $section->addText('NO: ', []);

        //     $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        //     $objWriter->save('storage/print_odt/spjb.odt');

        //     return Storage::download('public/storage/print_odt/spjb.odt');
        // }
    }

    public function sesi_api(Request $request, EventLelang $event, Lelang $lelang)
    {
        $request->validate([
            'harga' => ['required'],
            'code' => ['required'],
            'peserta' => ['required']
        ]);

        if ($request->code == 'getAnyRequest') {
            $dplb = $lelang->daftar_peserta_lelang_berlangsung()->select('daftar_peserta_lelang_berlangsung.*')->addSelect('daftar_peserta_lelang.kode_peserta_lelang')->leftJoin('daftar_peserta_lelang', 'daftar_peserta_lelang.daftar_peserta_lelang_id', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id')->whereIn('daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id', $event->daftar_peserta_lelang()->select('daftar_peserta_lelang.daftar_peserta_lelang_id')->get()->toArray())->orderBy('daftar_peserta_lelang_berlangsung.waktu', 'asc')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'data has been collected',
                'data' => $dplb,
                'done' => $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai',
                'reset' => $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Aktif' && !is_null($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()),
                'aktif' => is_null($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()) ? false : $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->aktif,
                'count' => !is_null($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first())
                    ? ($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->aktif
                        ? Carbon::now()->timestamp  - $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->waktu_mulai
                        : $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->waktu_selesai - $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->waktu_mulai)
                    : 0
            ], 200);
            exit;
        } else if ($request->code == 'startEventLelang') {
            is_null($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()) ? $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->create([
                'event_lelang_id' => $event->event_lelang_id,
                'lelang_id' => $lelang->lelang_id,
                'waktu_mulai' => Carbon::now()->timestamp,
                'waktu_selesai' => null,
                'aktif' => true
            ]) : $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->update([
                'waktu_mulai' => Carbon::now()->timestamp,
                'waktu_selesai' => null,
                'aktif' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'data has been executed',
                'data' => null
            ], 200);
        } else if ($request->code == 'begin') {
            if (!is_null($event->daftar_peserta_lelang_aktif()->where('lelang_id', $lelang->lelang_id)->first())) {
                $dpla = $event->daftar_peserta_lelang_aktif()->where('lelang_id', $lelang->lelang_id)->first();
                $dplb = $lelang->daftar_peserta_lelang_berlangsung()->select('daftar_peserta_lelang_berlangsung.*')->addSelect('daftar_peserta_lelang.kode_peserta_lelang')->leftJoin('daftar_peserta_lelang', 'daftar_peserta_lelang.daftar_peserta_lelang_id', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id')->whereIn('daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id', $event->daftar_peserta_lelang()->select('daftar_peserta_lelang.daftar_peserta_lelang_id')->get()->toArray())->orderBy('daftar_peserta_lelang_berlangsung.waktu', 'asc')->get();

                return response()->json([
                    'status' => 'success',
                    'message' => 'data has been collected',
                    'data' => [
                        'aktif' => $dpla,
                        'berlangsung' => $dplb
                    ]
                ], 200);
                exit;
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'no data',
                    'data' => null
                ], 200);
                exit;
            }
        } else if ($request->code == 'penawaran') {
            $lastBid = $event->daftar_peserta_lelang()->select('daftar_peserta_lelang.kode_peserta_lelang')->addSelect('harga_ajuan')->join('daftar_peserta_lelang_berlangsung', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id', 'daftar_peserta_lelang.daftar_peserta_lelang_id')->orderBy('daftar_peserta_lelang_berlangsung.waktu', 'desc')->where('daftar_peserta_lelang_berlangsung.lelang_id', $lelang->lelang_id)->first();

            $dpl = DaftarPesertaLelang::where('kode_peserta_lelang', $request->peserta)->where('event_lelang_id', $event->event_lelang_id)->first()->informasi_akun_id;
            $dpl = is_null($dpl) ? Auth::user()->informasi_akun_id : $dpl;

            if ($lelang->kontrak()->first()->informasi_akun_id != $dpl) {
                if (!is_null($lastBid)) {
                    if ($lastBid->kode_peserta_lelang != $request->peserta) {
                        $event->daftar_peserta_lelang()->where('kode_peserta_lelang', $request->peserta)->first()->daftar_peserta_lelang_berlangsung()->create([
                            'lelang_id' => $lelang->lelang_id,
                            'harga_ajuan' => is_null($lastBid) ? $lelang->harga_awal : $lastBid->harga_ajuan + $lelang->kelipatan_penawaran,
                            'waktu' =>  Carbon::now()->timestamp  - $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->waktu_mulai
                        ]);

                        return response()->json([
                            'status' => 'success',
                            'message' => 'data has been collected',
                            'data' => $lelang->daftar_peserta_lelang_berlangsung()->get()
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Anda sudah bidding sebelumnya. Tunggu Orang Lain Bidding',
                            'data' => null
                        ], 200);
                    }
                } else {
                    $event->daftar_peserta_lelang()->where('kode_peserta_lelang', $request->peserta)->first()->daftar_peserta_lelang_berlangsung()->create([
                        'lelang_id' => $lelang->lelang_id,
                        'harga_ajuan' => is_null($lastBid) ? $lelang->harga_awal : $lastBid->harga_ajuan + $lelang->kelipatan_penawaran,
                        'waktu' =>  Carbon::now()->timestamp  - $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->waktu_mulai
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'data has been collected',
                        'data' => $lelang->daftar_peserta_lelang_berlangsung()->get()
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'penjual tidak boleh ikut bidding',
                    'data' => null
                ], 200);
            }
        } else if ($request->code == 'stopSesiLelang') {
            is_null($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()) ? $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->create([
                'event_lelang_id' => $event->event_lelang_id,
                'lelang_id' => $lelang->lelang_id,
                'waktu_mulai' => Carbon::now()->timestamp,
                'waktu_selesai' => Carbon::now()->timestamp,
                'aktif' => false
            ]) : $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->update([
                'waktu_selesai' => Carbon::now()->timestamp,
                'aktif' => false
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'lelang has been stopped',
                'data' => []
            ], 200);
        } else if ($request->code == 'reset') {
            if (!is_null($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first())) {
                $lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first()->delete();
            }

            if (is_null($lelang->jenis_platform_lelang()->first())) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'jenis platform lelang not found',
                    'data' => []
                ], 200);
            }

            if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
                $lelang->peserta_lelang_berlangsung()->delete();
            }

            if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
                $event->daftar_peserta_lelang()->where('kode_peserta_lelang', $request->peserta)->first()->daftar_peserta_lelang_berlangsung()->create([
                    'lelang_id' => $lelang->lelang_id,
                    'harga_ajuan' => 0,
                    'waktu' =>  0
                ]);
                $lelang->daftar_peserta_lelang_berlangsung()->delete();
            } else {
                $event->daftar_peserta_lelang()->where('kode_peserta_lelang', $request->peserta)->first()->daftar_peserta_lelang_berlangsung()->create([
                    'lelang_id' => $lelang->lelang_id,
                    'harga_ajuan' => 0,
                    'waktu' =>  0
                ]);
                $lelang->daftar_peserta_lelang_berlangsung()->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'data has been reset for this lelang',
                'data' => []
            ], 200);
        } else if ($request->code == 'selesai') {
            $statusLelang = StatusLelang::where('nama_status', 'Selesai')->first();

            foreach ($lelang->status_lelang_pivot()->get() as $l) {
                $l->update([
                    'is_aktif' => false
                ]);
            }

            $lelang->status_lelang_pivot()->create([
                'status_lelang_id' => $statusLelang->status_lelang_id,
                'is_aktif' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'lelang has been finished',
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'you dont have permission on this route',
                'data' => null
            ], 404);
        }
    }

    public function createApprovalLelang($lelang)
    {
        if (is_null($lelang->jenis_platform_lelang()->first())) {
            // Tidak Ada
            return 'Tidak Ada';
        } else if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            //Online
            $peserta_lelang_berlangsung = $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            if (is_null($peserta_lelang_berlangsung)) {
                return null;
                exit;
            } else {
                $informasiAkunIdPembeli = $peserta_lelang_berlangsung->peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
                if (is_null($peserta_lelang_berlangsung->approval_lelang()->first())) {
                    $approval_lelang = $this->createApprovalLelangOnline($lelang, $peserta_lelang_berlangsung);
                } else {
                    $approval_lelang = $peserta_lelang_berlangsung->approval_lelang()->first();
                }
            }
        } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            // Hybrid
            $daftar_peserta_lelang_berlangsung = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            if (is_null($daftar_peserta_lelang_berlangsung)) {
                return null;
                exit;
            } else {
                $informasiAkunIdPembeli = $daftar_peserta_lelang_berlangsung->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
                if (is_null($daftar_peserta_lelang_berlangsung->approval_lelang()->first())) {
                    $approval_lelang = $this->createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung);
                } else {
                    $approval_lelang = $daftar_peserta_lelang_berlangsung->approval_lelang()->first();
                }
            }
        } else {
            // Offline
            $daftar_peserta_lelang_berlangsung = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            if (is_null($daftar_peserta_lelang_berlangsung)) {
                return null;
                exit;
            } else {
                $informasiAkunIdPembeli = $daftar_peserta_lelang_berlangsung->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
                if (is_null($daftar_peserta_lelang_berlangsung->approval_lelang()->first())) {
                    $approval_lelang = $this->createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung);
                } else {
                    $approval_lelang = $daftar_peserta_lelang_berlangsung->approval_lelang()->first();
                }
            }
        }
        return $approval_lelang;
    }

    public function createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung)
    {
        return $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->create($this->approval_lelang($lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id, $lelang->lelang_id, $lelang->jenis_harga()->first()->jenis_harga_id, $daftar_peserta_lelang_berlangsung->harga_ajuan));
    }

    public function createApprovalLelangOnline($lelang, $peserta_lelang_berlangsung)
    {
        return $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->create($this->approval_lelang($lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id, $lelang->lelang_id, $lelang->jenis_harga()->first()->jenis_harga_id, $peserta_lelang_berlangsung->harga_ajuan));
    }

    public function approval_lelang($informasiAkunId, $lelangId, $jenisHargaId, $harga)
    {
        return [
            'informasi_akun_id' => $informasiAkunId,
            'lelang_id' => $lelangId,
            'jenis_harga_id' => $jenisHargaId,
            'harga_pemenang' => $harga
        ];
    }
}
