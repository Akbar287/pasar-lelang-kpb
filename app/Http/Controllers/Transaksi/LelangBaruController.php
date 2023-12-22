<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\LelangRequest;
use App\Models\InformasiAkun;
use App\Models\JenisHarga;
use App\Models\JenisInisiasi;
use App\Models\JenisPerdagangan;
use App\Models\Kontrak;
use App\Models\Lelang;
use App\Models\StatusLelang;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class LelangBaruController extends Controller
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
            $status = StatusLelang::where('nama_status', 'Daftar')->first();
            $data = Lelang::where('status_lelang_pivot.status_lelang_id', $status->status_lelang_id)->where('status_lelang_pivot.is_aktif', true)->join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (!is_null($row->kontrak()->first()->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('kontrak', function ($row) {
                    $actionBtn = $row->kontrak()->first()->kontrak_kode;
                    return $actionBtn;
                })
                ->addColumn('harga_awal', function ($row) {
                    $actionBtn = 'Rp. ' . number_format($row->harga_awal, 2, ",", ".");
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('transaksi.lelang_baru.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi_pasar_lelang/lelang_baru/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisPerdagangan = JenisPerdagangan::get();
        $jenisInisiasi = JenisInisiasi::get();
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->get();
        $jenisHarga = JenisHarga::get();
        return view('transaksi_pasar_lelang/lelang_baru/create', compact('jenisPerdagangan', 'jenisInisiasi', 'jenisHarga', 'informasiAkun'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LelangRequest $lelangRequest)
    {
        $kontrak = Kontrak::where('kontrak_id', $lelangRequest->kontrak_id)->first();
        $status = StatusLelang::where('nama_status', 'Daftar')->first();
        $lelang = $kontrak->lelang()->create($this->lelangData());

        $lelang->status_lelang_pivot()->create($this->status_lelang_pivot($status->status_lelang_id));

        return redirect('/transaksi/lelang_baru/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di Aktifkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lelang $lelang)
    {
        $jenisHarga = JenisHarga::get();
        return view('transaksi_pasar_lelang/lelang_baru/show', compact('lelang', 'jenisHarga'));
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
        return view('transaksi_pasar_lelang/lelang_baru/edit', compact('jenisPerdagangan', 'jenisInisiasi', 'kontrak', 'jenisHarga', 'lelang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LelangRequest $lelangRequest, Lelang $lelang)
    {
        $lelang->update($this->lelangData(true));

        return redirect('/transaksi/lelang_baru/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Lelang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lelang $lelang)
    {
        $lelang->delete();

        return redirect('/transaksi/lelang_baru')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function lelangData($update = null)
    {
        return !is_null($update) ?
            [
                'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
                'jenis_inisiasi_id' => request('jenis_inisiasi_id'),
                'jenis_harga_id' => request('jenis_harga_id'),
                'kontrak_id' => request('kontrak_id'),
                'judul' => request('judul'),
                'asal_komoditas' => request('asal_komoditas'),
                'spesifikasi_produk' => request('spesifikasi_produk'),
                'kuantitas' => str_replace(',', '', request('kuantitas')),
                'kemasan' => request('kemasan'),
                'lokasi_penyerahan' => request('lokasi_penyerahan'),
                'harga_awal' => str_replace(',', '', request('harga_awal')),
                'kelipatan_penawaran' => str_replace(',', '', request('kelipatan_penawaran')),
                'harga_beli_sekarang' => is_null(request('harga_beli_sekarang_check')) ? null : (request('harga_beli_sekarang') != null ? str_replace(',', '', request('harga_beli_sekarang')) : null),
            ]
            :
            [
                'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
                'jenis_inisiasi_id' => request('jenis_inisiasi_id'),
                'jenis_harga_id' => request('jenis_harga_id'),
                'kontrak_id' => request('kontrak_id'),
                'nomor_lelang' => $this->generateNomorLelang(),
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

    public function generateNomorLelang()
    {
        $kontrak = Kontrak::where('kontrak_id', request('kontrak_id'))->first();
        $temp = 'LELANG-' . strtoupper($kontrak->jenis_perdagangan()->first()->nama_perdagangan) . '-' . strtoupper($kontrak->komoditas()->first()->nama_komoditas) . '-';
        $i = 1;
        $check = true;
        do {
            $db = Lelang::where('nomor_lelang', $temp . $i)->count();
            if ($db == 0) {
                $check = false;
            } else {
                $i++;
            }
        } while ($check);

        return $temp . $i;
    }

    public function status_lelang_pivot($statusId)
    {
        return [
            'status_lelang_id' => $statusId,
            'is_aktif' => true
        ];
    }

    public function option(Request $request)
    {
        if ($request->jenis == 'informasi_akun') {
            $informasiAkun = InformasiAkun::where('informasi_akun_id', $request->informasi_akun_id)->first();

            return response()->json([
                'status' => 'success',
                'data' => $informasiAkun->kontrak()->select('kontrak.kontrak_id')->addSelect('kontrak.kontrak_kode')->addSelect('kontrak.simbol')->addSelect('komoditas.nama_komoditas')->addSelect('kontrak.minimum_transaksi')->addSelect('jenis_perdagangan.nama_perdagangan')->addSelect('kontrak.maksimum_transaksi')->addSelect('mutu.nama_mutu')->addSelect('komoditas.satuan_ukuran')->leftJoin('mutu', 'mutu.mutu_id', 'kontrak.mutu_id')->leftJoin('jenis_perdagangan', 'jenis_perdagangan.jenis_perdagangan_id', 'kontrak.jenis_perdagangan_id')->leftJoin('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')->where('kontrak.is_aktif', true)->where('kontrak.is_verified', true)->addSelect('komoditas.komoditas_id')->where('kontrak.is_status_verified', true)->get(),
                'message' => 'data komoditas has been reached'
            ], 200);
            exit;
        } else if ($request->jenis == 'kontrak_detail_komoditas') {
            $kontrak = Kontrak::where('kontrak_id', $request->kontrak_id)->first();
            if (is_null($kontrak)) {
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'no data can be reached'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'data' => [
                        "komoditas_id" => $kontrak->komoditas()->first()->komoditas_id,
                        "kontrak_id" => $kontrak->kontrak_id,
                        "kontrak_kode" => $kontrak->kontrak_kode,
                        "maksimum_transaksi" => $kontrak->maksimum_transaksi,
                        "minimum_transaksi" => $kontrak->minimum_transaksi,
                        "nama_komoditas" => $kontrak->komoditas()->first()->nama_komoditas,
                        "nama_mutu" => $kontrak->mutu()->first()->nama_mutu,
                        "nama_perdagangan" => $kontrak->jenis_perdagangan()->first()->nama_perdagangan,
                        "satuan_ukuran" => $kontrak->komoditas()->first()->satuan_ukuran,
                        "simbol" => $kontrak->simbol,
                    ],
                    'message' => 'no data can be reached'
                ], 200);
            }
            exit;
        } else {
            return response()->json([
                'status' => 'failed',
                'data' => [],
                'message' => 'no data can be reached'
            ], 200);
            exit;
        }
    }

    public function getStatusLelang()
    {
        $status = StatusLelang::get();

        return response()->json([
            'status' => true,
            'message' => 'status lelang has been catched',
            'data' => $status
        ], 200);
    }

    public function getStatusLelangById(Request $request, StatusLelang $statusLelang)
    {
        return response()->json([
            'status' => true,
            'message' => 'sttus lelang has been catched',
            'data' => $statusLelang->nama_status
        ], 200);
        exit;
    }

    public function api_index(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            $page = $request->get('page') ?? 0;
            $size = $request->get('size') ?? 5;
            $total = Lelang::join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->where('status_lelang_pivot.is_aktif', true)->leftJoin('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('kontrak.informasi_akun_id', $user->informasi_akun_id)->join('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')->where('lelang.deleted_at', null)->count();

            $page_count = ceil($total / $size);

            $data = DB::Table('lelang')->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->where('status_lelang_pivot.is_aktif', true)->leftJoin('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('kontrak.informasi_akun_id', $user->informasi_akun_id)->join('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')->where('lelang.deleted_at', null)
                ->orderBy('judul', 'asc')
                ->forPage($page, $size)
                ->get();

            // $total = Lelang::join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->where('status_lelang_pivot.is_aktif', true)->leftJoin('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->where('kontrak.informasi_akun_id', $user->informasi_akun_id)->join('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')->where('lelang.deleted_at', null)->count();

            // $page_count = ceil($total / $size);

            // $data = DB::Table('lelang')->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')->where('status_lelang_pivot.is_aktif', true)->leftJoin('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->where('kontrak.informasi_akun_id', $user->informasi_akun_id)->join('lelang_sesi_online', 'lelang_sesi_online.lelang_id', 'lelang.lelang_id')->where('lelang.deleted_at', null)
            //     ->orderBy('judul', 'asc')
            //     ->forPage($page, $size)
            //     ->get();

            if ($total != 0 || $page_count != 0) {
                $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

                return response()->json([
                    'data' => $paginator,
                    'message' => 'data pengajuan lelang has been catched',
                    'status' => 'success'
                ], 200);
            } else {
                return response()->json([
                    'data' => [],
                    'message' => 'data pengajuan lelang has been catched',
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

    public function api_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_perdagangan_id' => ['required'],
            'jenis_inisiasi_id' => ['required'],
            'jenis_harga_id' => ['required'],
            'kontrak_id' => ['required'],
            'asal_komoditas' => ['required', 'max:128'],
            'spesifikasi_produk' => ['required'],
            'kuantitas' => ['required'],
            'kemasan' => ['required', 'max:128'],
            'lokasi_penyerahan' => ['required'],
            'judul' => ['required'],
            'harga_awal' => ['required'],
            'kelipatan_penawaran' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        } else {
            $kontrak = Kontrak::where('kontrak_id', $request->kontrak_id)->first();
            $status = StatusLelang::where('nama_status', 'Daftar')->first();
            $lelang = $kontrak->lelang()->create($this->lelangData());

            $lelang->status_lelang_pivot()->create($this->status_lelang_pivot($status->status_lelang_id));

            return response()->json([
                'data' => [
                    'lelang' => $lelang,
                ],
                'status' => 'success',
                'message' => 'data lelang has been created'
            ], 200);
            exit;
        }
    }

    public function api_show(Lelang $lelang)
    {
        return response()->json([
            'data' => [
                'lelang' => $lelang,
            ],
            'status' => 'success',
            'message' => 'data lelang has been created'
        ], 200);
    }

    public function api_update(Request $request, Lelang $lelang)
    {
        $validator = Validator::make($request->all(), [
            'jenis_perdagangan_id' => ['required'],
            'jenis_inisiasi_id' => ['required'],
            'jenis_harga_id' => ['required'],
            'kontrak_id' => ['required'],
            'asal_komoditas' => ['required', 'max:128'],
            'spesifikasi_produk' => ['required'],
            'judul' => ['required'],
            'kuantitas' => ['required'],
            'kemasan' => ['required', 'max:128'],
            'lokasi_penyerahan' => ['required'],
            'harga_awal' => ['required'],
            'kelipatan_penawaran' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        }

        $lelang->update($this->lelangData(true));

        return response()->json([
            'data' => [
                'lelang' => $lelang,
            ],
            'status' => 'success',
            'message' => 'data lelang has been updated'
        ], 200);
    }

    public function api_delete(Lelang $lelang)
    {
        $lelang->delete();

        return response()->json([
            'data' => [
                'lelang' => null,
            ],
            'status' => 'success',
            'message' => 'data lelang has been deleted'
        ], 200);
    }
}
