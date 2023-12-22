<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\LelangRequest;
use App\Models\EventLelang;
use App\Models\JenisHarga;
use App\Models\JenisInisiasi;
use App\Models\JenisPerdagangan;
use App\Models\Kontrak;
use App\Models\Lelang;
use App\Models\MasterSesiLelang;
use App\Models\StatusLelang;
use App\Models\Userlogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class DaftarLelangController extends Controller
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
            $data = Lelang::join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang_pivot.is_aktif', true)->whereNotIn('status_lelang.nama_status', ['Draft', 'Daftar', 'Verifikasi'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (!is_null($row->kontrak()->first()->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = is_null($row->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga) ? '-' : $row->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = is_null($row->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama) ? '-' : $row->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('tanggal', function ($row) {
                    return is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? $row->lelang_sesi_online()->first()->tanggal . ' (' . $row->lelang_sesi_online()->first()->master_sesi_lelang()->first()->sesi . ')' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? $row->event_lelang()->first()->tanggal_lelang : $row->event_lelang()->first()->tanggal_lelang));
                })
                ->addColumn('jam', function ($row) {
                    return is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? $row->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_mulai . '-' . $row->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_berakhir : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? $row->event_lelang()->first()->jam_mulai . '-' . $row->event_lelang()->first()->jam_selesai : $row->event_lelang()->first()->jam_mulai . '-' . $row->event_lelang()->first()->jam_selesai));
                })
                ->addColumn('kontrak', function ($row) {
                    $actionBtn = $row->kontrak()->first()->kontrak_kode;
                    return $actionBtn;
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->harga_awal, 2, ",", ".");
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' ? '<div class="badge badge-success">' . $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status . '</div>' : '<div class="badge badge-primary">' . $row->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status . '</div>';
                    return $actionBtn;
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-success">Online</div>' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>'));
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('transaksi.lelang_list.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'jenis', 'tanggal', 'jam'])
                ->make(true);
        }
        return view('transaksi_pasar_lelang/daftar_lelang/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        $masterSesiLelang = MasterSesiLelang::where('is_aktif', true)->get();
        $eventLelang = EventLelang::where('is_open', true)->get();
        return view('transaksi_pasar_lelang/daftar_lelang/show', compact('lelang', 'jenisHarga', 'masterSesiLelang', 'eventLelang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lelang $lelang)
    {
        $jenisPerdagangan = JenisPerdagangan::get();
        $jenisInisiasi = JenisInisiasi::get();
        $kontrak = Kontrak::where('informasi_akun_id', $lelang->kontrak()->first()->informasi_akun_id)->get();
        $jenisHarga = JenisHarga::get();
        return view('transaksi_pasar_lelang/daftar_lelang/edit', compact('jenisPerdagangan', 'jenisInisiasi', 'kontrak', 'jenisHarga', 'lelang'));
    }

    public function api_get_all(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            $page = $request->get('page') ?? 0;
            $size = $request->get('size') ?? 5;
            $status = $request->has('status') ? explode(';', $request->get('status')) : ['Aktif'];

            $status = StatusLelang::select('status_lelang_id')->whereIn('nama_status', $status)->get()->toArray();
            $temp = [];
            foreach ($temp as $t) {
                $temp[] = $t['status_lelang_id'];
            }

            $total = $request->platform == 'online' ? Lelang::select('lelang.*')
                ->addSelect('kontrak.informasi_akun_id')
                ->addSelect('komoditas.nama_komoditas')
                ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->leftJoin('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')
                ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                ->where('status_lelang_pivot.is_aktif', true)
                ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                ->orderBy('lelang_sesi_online.tanggal', 'desc')
                ->forPage($page, $size)
                ->count()
                : Lelang::select('lelang.*')
                ->addSelect('event_lelang.*')
                ->addSelect('kontrak.informasi_akun_id')
                ->addSelect('komoditas.nama_komoditas')
                ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                ->leftJoin('event_lelang_relation', 'lelang.lelang_id', 'event_lelang_relation.lelang_id')
                ->leftJoin('event_lelang', 'event_lelang.event_lelang_id', 'event_lelang_relation.event_lelang_id')
                ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                ->where('status_lelang_pivot.is_aktif', true)
                ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->count();

            $page_count = ceil($total / $size);

            if ($request->platform == 'online') {
                $data = DB::Table('lelang')
                    ->select('lelang.*')
                    ->addSelect('kontrak.informasi_akun_id')
                    ->addSelect('komoditas.nama_komoditas')
                    ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                    ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                    ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                    ->leftJoin('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')
                    ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                    ->where('status_lelang_pivot.is_aktif', true)
                    ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                    ->orderBy('lelang_sesi_online.tanggal', 'desc')
                    ->forPage($page, $size)
                    ->get();
            } else {
                $data = DB::Table('lelang')
                    ->select('lelang.*')
                    ->addSelect('event_lelang.*')
                    ->addSelect('kontrak.informasi_akun_id')
                    ->addSelect('komoditas.nama_komoditas')
                    ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                    ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                    ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                    ->leftJoin('event_lelang_relation', 'lelang.lelang_id', 'event_lelang_relation.lelang_id')
                    ->leftJoin('event_lelang', 'event_lelang.event_lelang_id', 'event_lelang_relation.event_lelang_id')
                    ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                    ->where('status_lelang_pivot.is_aktif', true)
                    ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                    ->orderBy('event_lelang.tanggal_lelang', 'desc')
                    ->forPage($page, $size)
                    ->get();
            }

            if ($total != 0 || $page_count != 0) {
                $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

                return response()->json([
                    'data' => [
                        'platform' => $request->platform,
                        'riwayat' => $paginator
                    ],
                    'message' => 'riwayat data lelang has been catched',
                    'status' => 'success'
                ], 200);
            } else {
                return response()->json([
                    'data' => [
                        'platform' => $request->platform,
                        'riwayat' => []
                    ],
                    'message' => 'riwayat data lelang has been catched',
                    'status' => 'success'
                ], 200);
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_expired: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (TokenInvalidException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_invalid: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (JWTException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_absent: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        }
    }

    public function api_get_guest(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        $status = $request->has('status') ? explode(';', $request->get('status')) : ['Aktif'];

        $status = StatusLelang::select('status_lelang_id')->whereIn('nama_status', $status)->get()->toArray();
        $temp = [];
        foreach ($temp as $t) {
            $temp[] = $t['status_lelang_id'];
        }

        $total = $request->platform == 'online' ? Lelang::select('lelang.*')
            ->addSelect('kontrak.informasi_akun_id')
            ->addSelect('komoditas.nama_komoditas')
            ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
            ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
            ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
            ->leftJoin('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')
            ->where('status_lelang_pivot.is_aktif', true)
            ->whereIn('status_lelang_pivot.status_lelang_id', $status)
            ->orderBy('lelang_sesi_online.tanggal', 'desc')
            ->forPage($page, $size)
            ->count()
            : Lelang::select('lelang.*')
            ->addSelect('event_lelang.*')
            ->addSelect('kontrak.informasi_akun_id')
            ->addSelect('komoditas.nama_komoditas')
            ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
            ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
            ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
            ->leftJoin('event_lelang_relation', 'lelang.lelang_id', 'event_lelang_relation.lelang_id')
            ->leftJoin('event_lelang', 'event_lelang.event_lelang_id', 'event_lelang_relation.event_lelang_id')
            ->where('status_lelang_pivot.is_aktif', true)
            ->whereIn('status_lelang_pivot.status_lelang_id', $status)
            ->orderBy('event_lelang.tanggal_lelang', 'desc')
            ->count();

        $page_count = ceil($total / $size);

        if ($request->platform == 'online') {
            $data = DB::Table('lelang')
                ->select('lelang.*')
                ->addSelect('kontrak.informasi_akun_id')
                ->addSelect('komoditas.nama_komoditas')
                ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                ->leftJoin('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')
                ->where('status_lelang_pivot.is_aktif', true)
                ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                ->orderBy('lelang_sesi_online.tanggal', 'desc')
                ->forPage($page, $size)
                ->get();
        } else {
            $data = DB::Table('lelang')
                ->select('lelang.*')
                ->addSelect('event_lelang.*')
                ->addSelect('kontrak.informasi_akun_id')
                ->addSelect('komoditas.nama_komoditas')
                ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                ->leftJoin('event_lelang_relation', 'lelang.lelang_id', 'event_lelang_relation.lelang_id')
                ->leftJoin('event_lelang', 'event_lelang.event_lelang_id', 'event_lelang_relation.event_lelang_id')
                ->where('status_lelang_pivot.is_aktif', true)
                ->whereIn('status_lelang_pivot.status_lelang_id', $status)
                ->orderBy('event_lelang.tanggal_lelang', 'desc')
                ->forPage($page, $size)
                ->get();
        }

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => [
                    'platform' => $request->platform,
                    'riwayat' => $paginator
                ],
                'message' => 'riwayat data lelang has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [
                    'platform' => $request->platform,
                    'riwayat' => []
                ],
                'message' => 'riwayat data lelang has been catched',
                'status' => 'success'
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LelangRequest $lelangRequest, Lelang $lelang)
    {
        $lelang->update($this->lelangData());

        return redirect('/transaksi/list_lelang/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function api_bid(Request $request, EventLelang $event, lelang $lelang)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            $lastBid = $event->daftar_peserta_lelang()->select('daftar_peserta_lelang.kode_peserta_lelang')->addSelect('harga_ajuan')->join('daftar_peserta_lelang_berlangsung', 'daftar_peserta_lelang_berlangsung.daftar_peserta_lelang_id', 'daftar_peserta_lelang.daftar_peserta_lelang_id')->orderBy('daftar_peserta_lelang_berlangsung.waktu', 'desc')->where('daftar_peserta_lelang_berlangsung.lelang_id', $lelang->lelang_id)->first();


            $kode = $event->daftar_peserta_lelang()->where('informasi_akun_id', $user->informasi_akun_id)->first();

            if (!is_null($kode)) {
                if (is_null($lelang->daftar_peserta_lelang_aktif()->where('event_lelang_id', $event->event_lelang_id)->first())) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'event lelang for this lelang session is not started',
                        'data' => $lelang->daftar_peserta_lelang_berlangsung()->get()
                    ], 200);
                } else {
                    if (!is_null($lastBid)) {
                        if ($lastBid->kode_peserta_lelang != $kode->kode_peserta_lelang) {
                            $event->daftar_peserta_lelang()->where('kode_peserta_lelang', $kode->kode_peserta_lelang)->first()->daftar_peserta_lelang_berlangsung()->create([
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
                                'message' => 'last bid is same on this bid. it s cannot do that',
                                'data' => null
                            ], 200);
                        }
                    } else {
                        $event->daftar_peserta_lelang()->where('kode_peserta_lelang', $kode->kode_peserta_lelang)->first()->daftar_peserta_lelang_berlangsung()->create([
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
                }
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_expired: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (TokenInvalidException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_invalid: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (JWTException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_absent: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        }
    }

    public function api_checking_user_id_regist(Request $request, Lelang $lelang)
    {
        if ($lelang->jenis_platform_lelang()->count() > 0) {
            // Sudah Verif
            try {
                $token = JWTAuth::getToken();
                $apy = JWTAuth::getPayload($token)->toArray();

                $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

                if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
                    // Online
                    if ($lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $user->informasi_akun_id)->count() > 0) {
                        // Terdaftar
                        return response()->json([
                            'data' => [$lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $user->informasi_akun_id)->first()],
                            'message' => 'User Sudah Terdaftar di lelang ini',
                            'status' => 'success'
                        ], 200);
                        exit;
                    } else {
                        // Belum Terdaftar
                        return response()->json([
                            'data' => [],
                            'message' => 'User Belum Terdaftar di lelang ini',
                            'status' => 'failed'
                        ], 200);
                        exit;
                    }
                } else {
                    // Offline / Hybrid
                    if ($lelang->event_lelang()->count() > 0) {
                        // Sudah Ada Event Lelang  / Terkonfirmasi Offline / Hybrid
                        $event = $lelang->event_lelang()->orderBy('event_lelang.tanggal_lelang', 'desc')->first();

                        if ($event->daftar_peserta_lelang()->where('informasi_akun_id', $user->informasi_akun_id)->count() > 0) {
                            // Sudah Terdaftar
                            return response()->json([
                                'data' => [$event->daftar_peserta_lelang()->where('informasi_akun_id', $user->informasi_akun_id)->first()],
                                'message' => 'User ini telah terdaftar di lelang ini sebagai peserta',
                                'status' => 'success'
                            ], 200);
                            exit;
                        } else {
                            // Belum Terdaftar
                            return response()->json([
                                'data' => [],
                                'message' => 'User ini belum terdaftar di lelang ini',
                                'status' => 'failed'
                            ], 200);
                            exit;
                        }
                    } else {
                        // Event Lelang Belum Terelasi / Belum Terkonfirmasi
                        return response()->json([
                            'data' => [],
                            'message' => 'Lelang ini belum terelasi dengan event manapun',
                            'status' => 'failed'
                        ], 200);
                        exit;
                    }
                }
            } catch (TokenExpiredException $e) {
                return response()->json([
                    'data' => [],
                    'message' => 'token_expired: ' . $e->getMessage(),
                    'status' => 'error'
                ], 500);
                exit;
            } catch (TokenInvalidException $e) {
                return response()->json([
                    'data' => [],
                    'message' => 'token_invalid: ' . $e->getMessage(),
                    'status' => 'error'
                ], 500);
                exit;
            } catch (JWTException $e) {
                return response()->json([
                    'data' => [],
                    'message' => 'token_absent: ' . $e->getMessage(),
                    'status' => 'error'
                ], 500);
                exit;
            }
        } else {
            // Belum Verif
            return response()->json([
                'data' => [],
                'message' => 'Lelang Belum di verifikasi sehingga belum membuka kode peserta',
                'status' => 'error'
            ], 500);
            exit;
        }
    }

    public function lelangData()
    {
        return [
            'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
            'jenis_inisiasi_id' => request('jenis_inisiasi_id'),
            'jenis_harga_id' => request('jenis_harga_id'),
            'kontrak_id' => request('kontrak_id'),
            'nomor_lelang' => request('nomor_lelang'),
            'judul' => request('judul'),
            'asal_komoditas' => request('asal_komoditas'),
            'spesifikasi_produk' => request('spesifikasi_produk'),
            'kuantitas' => str_replace(',', '', request('kuantitas')),
            'kemasan' => request('kemasan'),
            'lokasi_penyerahan' => request('lokasi_penyerahan'),
            'harga_awal' => str_replace(',', '', request('harga_awal')),
            'kelipatan_penawaran' => str_replace(',', '', request('kelipatan_penawaran')),
            'harga_beli_sekarang' => is_null(request('harga_beli_sekarang_check')) ? null : (request('harga_beli_sekarang') != null ? str_replace(',', '', request('harga_beli_sekarang')) : null),
        ];
    }

    public function penawaranPadaHargaSatuan()
    {
        $data = JenisHarga::where('nama_jenis_harga', 'Penawaran Pada Harga Satuan')->first();

        return response()->json([
            'message' => 'id has been collected',
            'status' => 200,
            'data' => $data->jenis_harga_id
        ], 200);
    }

    public function getStatusLelangRiwayat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        } else {
            try {
                $token = JWTAuth::getToken();
                $apy = JWTAuth::getPayload($token)->toArray();

                $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

                $page = $request->get('page') ?? 0;
                $size = $request->get('size') ?? 5;

                $total = $request->platform == 'online' ? $user->informasi_akun()->first()->peserta_lelang()->select('peserta_lelang.tanggal')->addSelect('peserta_lelang.peserta_lelang_id')->addSelect('peserta_lelang.kode_peserta_lelang')->addSelect('master_sesi_lelang.sesi')->addSelect('master_sesi_lelang.jam_mulai')->addSelect('master_sesi_lelang.jam_berakhir')->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'peserta_lelang.master_sesi_lelang_id')->count() : $user->informasi_akun()->first()->daftar_peserta_lelang()->select('daftar_peserta_lelang.daftar_peserta_lelang_id')->addSelect('daftar_peserta_lelang.kode_peserta_lelang')->addSelect('jam_mulai')->addSelect('jam_selesai')->addSelect('lokasi')->addSelect('tanggal_lelang')->addSelect('nama_lelang')->addSelect('event_kode')->join('event_lelang', 'event_lelang.event_lelang_id', 'daftar_peserta_lelang.event_lelang_id')->count();

                $page_count = ceil($total / $size);

                if ($request->platform == 'online') {
                    $data = DB::Table('peserta_lelang')
                        ->select('peserta_lelang.tanggal')
                        ->addSelect('peserta_lelang.peserta_lelang_id')
                        ->addSelect('peserta_lelang.kode_peserta_lelang')
                        ->addSelect('master_sesi_lelang.sesi')
                        ->addSelect('master_sesi_lelang.jam_mulai')
                        ->addSelect('master_sesi_lelang.jam_berakhir')
                        ->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'peserta_lelang.master_sesi_lelang_id')
                        ->where('peserta_lelang.informasi_akun_id', $user->informasi_akun_id)
                        ->orderBy('tanggal', 'desc')
                        ->forPage($page, $size)
                        ->get();
                } else {
                    $data = DB::Table('daftar_peserta_lelang')
                        ->select('daftar_peserta_lelang.daftar_peserta_lelang_id')
                        ->addSelect('daftar_peserta_lelang.kode_peserta_lelang')
                        ->addSelect('jam_mulai')
                        ->addSelect('jam_selesai')
                        ->addSelect('lokasi')
                        ->addSelect('tanggal_lelang')
                        ->addSelect('nama_lelang')
                        ->addSelect('event_kode')
                        ->join('event_lelang', 'event_lelang.event_lelang_id', 'daftar_peserta_lelang.event_lelang_id')
                        ->where('daftar_peserta_lelang.informasi_akun_id', $user->informasi_akun_id)
                        ->orderBy('tanggal_lelang', 'desc')
                        ->forPage($page, $size)
                        ->get();
                }

                if ($total != 0 || $page_count != 0) {
                    $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

                    return response()->json([
                        'data' => [
                            'platform' => $request->platform,
                            'riwayat' => $paginator
                        ],
                        'message' => 'riwayat data lelang has been catched',
                        'status' => 'success'
                    ], 200);
                } else {
                    return response()->json([
                        'data' => [
                            'platform' => $request->platform,
                            'riwayat' => []
                        ],
                        'message' => 'riwayat data lelang has been catched',
                        'status' => 'success'
                    ], 200);
                }
            } catch (TokenExpiredException $e) {
                return response()->json([
                    'data' => [],
                    'message' => 'token_expired: ' . $e->getMessage(),
                    'status' => 'error'
                ], 500);
                exit;
            } catch (TokenInvalidException $e) {
                return response()->json([
                    'data' => [],
                    'message' => 'token_invalid: ' . $e->getMessage(),
                    'status' => 'error'
                ], 500);
                exit;
            } catch (JWTException $e) {
                return response()->json([
                    'data' => [],
                    'message' => 'token_absent: ' . $e->getMessage(),
                    'status' => 'error'
                ], 500);
                exit;
            }
        }
    }

    public function api_index(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            $status = is_null($request->status) ? ['Draft', 'Daftar', 'Verifikasi'] : explode(', ', $request->status);
            $page = $request->get('page') ?? 0;
            $size = $request->get('size') ?? 5;
            $total = Lelang::select('komoditas.nama_komoditas')
                ->addSelect('lelang.*')
                ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                ->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')
                ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                ->where('status_lelang_pivot.is_aktif', true)
                ->whereNotIn('status_lelang.nama_status', $status)->count();

            $page_count = ceil($total / $size);

            $data = DB::Table('lelang')
                ->select('komoditas.nama_komoditas')
                ->addSelect('lelang.*')
                ->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')
                ->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')
                ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                ->where('status_lelang_pivot.is_aktif', true)
                ->whereNotIn('status_lelang.nama_status', $status)
                ->orderBy('judul', 'asc')
                ->forPage($page, $size)
                ->get();

            if ($total != 0 || $page_count != 0) {
                $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

                return response()->json([
                    'data' => $paginator,
                    'message' => 'data lelang has been catched',
                    'status' => 'success',
                    'status' => $status
                ], 200);
            } else {
                return response()->json([
                    'data' => [],
                    'message' => 'data lelang has been catched',
                    'status' => 'success',
                    'status' => $status
                ], 200);
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_expired: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (TokenInvalidException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_invalid: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (JWTException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_absent: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        }
    }

    public function api_show(Lelang $lelang)
    {
        return response()->json([
            'data' => [
                'lelang' => $lelang,
                'kontrak' => $lelang->kontrak()->first(),
                'komoditas' => $lelang->kontrak()->first()->komoditas()->first(),
                'dokumen' => $lelang->dokumen_produk()->get()
            ],
            'message' => 'lelang has been catched',
            'status' => 'success'
        ], 200);
    }
}
