<?php

namespace App\Http\Controllers\MasterData\Kontrak;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengaturanKontrakRequest;
use App\Models\InformasiAkun;
use App\Models\JenisPerdagangan;
use App\Models\Komoditas;
use App\Models\Kontrak;
use App\Models\Mutu;
use App\Models\PenyelenggaraPasarLelang;
use App\Models\StatusKontrak;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class PengaturanKontrakController extends Controller
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
            $data = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first()->kontrak()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (!is_null($row->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = $row->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('komoditas', function ($row) {
                    $actionBtn = $row->komoditas()->first()->nama_komoditas;
                    return $actionBtn;
                })
                ->addColumn('jenis_perdagangan', function ($row) {
                    $actionBtn = $row->jenis_perdagangan()->first()->nama_perdagangan;
                    return $actionBtn;
                })
                ->addColumn('username', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->userlogin()->first()->username;
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $actionBtn = $row->status_kontrak()->first()->nama_status;
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $actionBtn = is_null($row->created_at) ? "Tidak ada Data" : $row->created_at->toDateTimeString();
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master.kontrak.pengaturan.show', $row->kontrak_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $komoditas = Komoditas::where('kadaluarsa', false)->get();
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        $mutu = Mutu::where('is_aktif', true)->get();
        $jenisPerdagangan = JenisPerdagangan::where('is_aktif', true)->get();
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->get();
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/create', compact('komoditas', 'penyelenggaraPasarLelang', 'mutu', 'jenisPerdagangan', 'informasiAkun'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengaturanKontrakRequest $pengaturanKontrakRequest)
    {
        $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();

        $informasi = InformasiAkun::where('informasi_akun_id', $pengaturanKontrakRequest->informasi_akun_id)->first();
        $kontrak = $informasi->kontrak()->create($this->pengaturanKontrakData($status, $informasi->informasi_akun_id, $this->generateSimbol()));

        $kontrak->kontrak_keuangan()->create($this->pengaturanKontrakKeuangan());

        return redirect('/master/kontrak/pengaturan/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di tambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $kontrak)
    {
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/show', compact('kontrak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontrak $kontrak)
    {
        $komoditas = Komoditas::where('kadaluarsa', false)->get();
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        $mutu = Mutu::where('is_aktif', true)->get();
        $jenisPerdagangan = JenisPerdagangan::where('is_aktif', true)->get();
        $informasiAkun = StatusMember::where('nama_status', 'Aktif')->first()->member()->get();
        return view('master_data/kontrak_pasar_lelang/pengaturan_kontrak/edit', compact('komoditas', 'penyelenggaraPasarLelang', 'mutu', 'jenisPerdagangan', 'informasiAkun', 'kontrak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengaturanKontrakRequest $pengaturanKontrakRequest, Kontrak $kontrak)
    {
        $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();
        $informasi = InformasiAkun::where('informasi_akun_id', $pengaturanKontrakRequest->informasi_akun_id)->first();
        $kontrak->update($this->pengaturanKontrakData($status, $informasi->informasi_akun_id));

        $kontrak->kontrak_keuangan()->first()->update($this->pengaturanKontrakKeuangan());

        return redirect('/master/kontrak/pengaturan/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        $kontrak->delete();

        return redirect('/master/kontrak/pengaturan')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function generateKontrakKode($id)
    {
        $informasiAkun = InformasiAkun::where('informasi_akun_id', $id)->first();
        $kontrakCount = is_null($informasiAkun->kontrak()->first()) ? 0 : $informasiAkun->kontrak()->count();
        return 'KONTRAK/' . date('Y') . '/' . $informasiAkun->userlogin()->first()->username . '/' . $kontrakCount;
    }

    public function pengaturanKontrakData($status = null, $informasiAkun = null, $simbol = null, $update = null)
    {
        return $update ?
            [
                'penyelenggara_pasar_lelang_id' => request('penyelenggara_pasar_lelang_id'),
                'mutu_id' => request('mutu_id'),
                'komoditas_id' => request('komoditas_id'),
                'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
                'status_kontrak_id' => $status != null ? $status->status_kontrak_id : 1,
                'minimum_transaksi' => is_null(request('minimum_transaksi')) ? 0 : (str_replace(',', '', request('minimum_transaksi'))),
                'maksimum_transaksi' => is_null(request('maksimum_transaksi')) ? 0 : (str_replace(',', '', request('maksimum_transaksi'))),
                'keterangan' => request('keterangan'),
            ]
            : [
                'penyelenggara_pasar_lelang_id' => request('penyelenggara_pasar_lelang_id'),
                'mutu_id' => request('mutu_id'),
                'kontrak_kode' => $this->generateKontrakKode(is_null($informasiAkun) ? request('informasi_akun_id') : $informasiAkun),
                'komoditas_id' => request('komoditas_id'),
                'informasi_akun_id' => is_null($informasiAkun) ? request('informasi_akun_id') : $informasiAkun,
                'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
                'status_kontrak_id' => $status != null ? $status->status_kontrak_id : 1,
                'simbol' => is_null($simbol) ? request('simbol') : $simbol,
                'minimum_transaksi' => is_null(request('minimum_transaksi')) ? 0 : (str_replace(',', '', request('minimum_transaksi'))),
                'maksimum_transaksi' => is_null(request('maksimum_transaksi')) ? 0 : (str_replace(',', '', request('maksimum_transaksi'))),
                'fluktuasi_harga_harian' => is_null(request('fluktuasi_harga_harian')) ? 0 : (str_replace(',', '', request('fluktuasi_harga_harian'))),
                'premium' => is_null(request('premium')) ? 0 : (str_replace(',', '', request('premium'))),
                'diskon' => is_null(request('diskon')) ? 0 : (str_replace(',', '', request('diskon'))),
                'jatuh_tempo_t_plus' => request('jatuh_tempo_t_plus'),
                'tanggal_aktif' => request('tanggal_aktif'),
                'tanggal_berakhir' => request('tanggal_berakhir'),
                'keterangan' => request('keterangan'),
                'tanggal_verifikasi' => null,
                'is_aktif' => false,
                'is_verified' => false,
                'is_status_verified' => false,
            ];
    }

    public function pengaturanKontrakKeuangan()
    {
        return [
            'jaminan_lelang' => is_null(request('jaminan_lelang')) ? 0 : str_replace(',', '', request('jaminan_lelang')),
            'denda' => is_null(request('denda')) ? 0 : str_replace(',', '', request('denda')),
            'fee_penjual' => is_null(request('fee_penjual')) ? 0 : str_replace(',', '', request('fee_penjual')),
            'fee_pembeli' => is_null(request('fee_pembeli')) ? 0 : str_replace(',', '', request('fee_pembeli')),
        ];
    }

    public function api_index(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
            $data = $request->has('status') ?  $user->informasi_akun()->first()->kontrak()->where('kontrak.is_aktif', request('status'))->get() : $user->informasi_akun()->first()->kontrak()->get();

            return response()->json([
                'data' => $data,
                'message' => 'kontrak has been catched',
                'status' => 'success'
            ], 200);
            exit;
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

    public function api_create(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();


            $validator = Validator::make($request->all(), [
                'penyelenggara_pasar_lelang_id' => ['required'],
                'mutu_id' => ['required'],
                'komoditas_id' => ['required'],
                'jenis_perdagangan_id' => ['required'],
                'minimum_transaksi' => ['required'],
                'maksimum_transaksi' => ['required'],
                // 'fluktuasi_harga_harian' => ['required'],
                // 'premium' => ['required'],
                // 'diskon' => ['required'],
                // 'jatuh_tempo_t_plus' => ['required'],
                // 'tanggal_aktif' => ['required'],
                // 'tanggal_berakhir' => ['required'],
                // 'jaminan_lelang' => ['required'],
                // 'denda' => ['required'],
                // 'fee_penjual' => ['required'],
                // 'fee_pembeli' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
                exit;
            } else {
                $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();
                $kontrak = $user->informasi_akun()->first()->kontrak()->create($this->pengaturanKontrakData($status, $user->informasi_akun_id, $this->generateSimbol()));

                $kontrakKeuangan = $kontrak->kontrak_keuangan()->create($this->pengaturanKontrakKeuangan());

                return response()->json([
                    'data' => [
                        'kontrak' => $kontrak,
                        'kontrak_keuangan' => $kontrakKeuangan,
                    ],
                    'status' => 'success',
                    'message' => 'data kontrak has been created'
                ], 200);
                exit;
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

    public function generateSimbol()
    {
        $komoditas = Komoditas::where('komoditas_id', request('komoditas_id'))->first();
        $jenisPerdagangan = JenisPerdagangan::where('jenis_perdagangan_id', request('jenis_perdagangan_id'))->first();

        $loop = true;
        $i = 1;
        do {
            $temp = strtoupper($jenisPerdagangan->nama_perdagangan) . '-' .  strtoupper($komoditas->nama_komoditas) . '-' . $i;
            $re = Kontrak::where('simbol', $temp)->count();

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
    }

    public function api_show(Kontrak $kontrak)
    {
        return response()->json([
            'data' => [
                'kontrak' => $kontrak,
                'kontrak_keuangan' => $kontrak->kontrak_keuangan()->first(),
            ],
            'status' => 'success',
            'message' => 'data kontrak has been catched'
        ], 200);
        exit;
    }
    public function api_update(Request $request, Kontrak $kontrak)
    {
        $validator = Validator::make($request->all(), [
            'penyelenggara_pasar_lelang_id' => ['required'],
            'mutu_id' => ['required'],
            'komoditas_id' => ['required'],
            'jenis_perdagangan_id' => ['required'],
            'minimum_transaksi' => ['required'],
            'maksimum_transaksi' => ['required'],
            // 'informasi_akun_id' => ['required'],
            // 'simbol' => ['required'],
            // 'fluktuasi_harga_harian' => ['required'],
            // 'premium' => ['required'],
            // 'diskon' => ['required'],
            // 'jatuh_tempo_t_plus' => ['required'],
            // 'tanggal_aktif' => ['required'],
            // 'tanggal_berakhir' => ['required'],
            // 'jaminan_lelang' => ['required'],
            // 'denda' => ['required'],
            // 'fee_penjual' => ['required'],
            // 'fee_pembeli' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        } else {
            $status = StatusKontrak::where('nama_status', 'Pendaftar Baru')->first();
            $kontrak->update($this->pengaturanKontrakData($status, null, null, true));
            $kontrak->kontrak_keuangan()->first()->update($this->pengaturanKontrakKeuangan());

            return response()->json([
                'data' => [
                    'kontrak' => $kontrak,
                    'kontrak_keuangan' => $kontrak->kontrak_keuangan()->first(),
                ],
                'status' => 'success',
                'message' => 'data kontrak has been catched'
            ], 200);
            exit;
        }
    }
    public function api_delete(Kontrak $kontrak)
    {
        $kontrak->delete();

        return response()->json([
            'data' => [],
            'message' => 'Kontrak deleted',
            'status' => 'success'
        ], 200);
    }
}
