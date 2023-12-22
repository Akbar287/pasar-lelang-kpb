<?php

namespace App\Http\Controllers\MasterData\Kontrak;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\InformasiAkun;
use App\Models\JenisPerdagangan;
use App\Models\Komoditas;
use App\Models\Kontrak;
use App\Models\Mutu;
use App\Models\PenyelenggaraPasarLelang;
use App\Models\StatusKontrak;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class ListKontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusKontrak::where('nama_status', 'Aktif')->first()->kontrak()->get();
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
                    $actionBtn = '<a href="' . route('master.kontrak.list.show', $row->kontrak_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master_data/kontrak_pasar_lelang/daftar_kontrak/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $kontrak)
    {
        return view('master_data/kontrak_pasar_lelang/daftar_kontrak/show', compact('kontrak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontrak $kontrak)
    {
        $komoditas = Komoditas::get();
        $penyelenggaraPasarLelang = PenyelenggaraPasarLelang::get();
        $mutu = Mutu::get();
        $jenisPerdagangan = JenisPerdagangan::get();
        $informasiAkun = InformasiAkun::whereNotIn('informasi_akun_id', Admin::select('informasi_akun.informasi_akun_id')->join('member', 'member.member_id', 'admin.member_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->get())->get();
        return view('master_data/kontrak_pasar_lelang/daftar_kontrak/edit', compact('komoditas', 'penyelenggaraPasarLelang', 'mutu', 'jenisPerdagangan', 'informasiAkun', 'kontrak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontrak $kontrak)
    {
        $kontrak->update($this->pengaturanKontrakData());
        $kontrak->kontrak_keuangan()->first()->update($this->pengaturanKontrakKeuangan());

        return redirect('/master/kontrak/list/' . $kontrak->kontrak_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di Ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        $status = StatusKontrak::where('nama_status', 'Non-Aktif')->first();
        $kontrak->update([
            'status_kontrak_id' => $status->status_kontrak_id,
            'is_aktif' => false
        ]);

        return redirect('/master/kontrak/list')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Kontrak telah di Non-Aktifkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function pengaturanKontrakData()
    {
        return [
            'penyelenggara_pasar_lelang_id' => request('penyelenggara_pasar_lelang_id'),
            'mutu_id' => request('mutu_id'),
            'komoditas_id' => request('komoditas_id'),
            'informasi_akun_id' => request('informasi_akun_id'),
            'jenis_perdagangan_id' => request('jenis_perdagangan_id'),
            'simbol' => request('simbol'),
            'minimum_transaksi' => str_replace(',', '', request('minimum_transaksi')),
            'maksimum_transaksi' => str_replace(',', '', request('maksimum_transaksi')),
            'fluktuasi_harga_harian' => str_replace(',', '', request('fluktuasi_harga_harian')),
            'premium' => str_replace(',', '', request('premium')),
            'diskon' => str_replace(',', '', request('diskon')),
            'jatuh_tempo_t_plus' => request('jatuh_tempo_t_plus'),
            'tanggal_aktif' => request('tanggal_aktif'),
            'tanggal_berakhir' => request('tanggal_berakhir'),
            'is_aktif' => request('is_aktif'),
        ];
    }

    public function pengaturanKontrakKeuangan()
    {
        return [
            'jaminan_lelang' => str_replace(',', '', request('jaminan_lelang')),
            'denda' => str_replace(',', '', request('denda')),
            'fee_penjual' => str_replace(',', '', request('fee_penjual')),
            'fee_pembeli' => str_replace(',', '', request('fee_pembeli')),
        ];
    }

    public function api_index_all(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();

            $status = $request->has('status') ? StatusKontrak::select('status_kontrak_id')->whereIn('nama_status', explode('; ', $request->status))->get()->toArray() : null;
            $page = $request->get('page') ?? 0;
            $size = $request->get('size') ?? 5;

            if ($request->has('status')) {
                $temp = [];
                foreach ($status as $s) {
                    $temp[] = $s['status_kontrak_id'];
                }
                $status = $temp;
                unset($temp);
            }


            $total = is_null($status) ? Auth::user()->informasi_akun()->first()->kontrak()->count() : Auth::user()->informasi_akun()->first()->kontrak()->whereIn('status_kontrak_id', $status)->count();

            $page_count = ceil($total / $size);

            $data = !is_null($status) ? DB::Table('kontrak')
                ->select('komoditas.nama_komoditas')
                ->addSelect('kontrak.*')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                ->whereIn('kontrak.status_kontrak_id', $status)
                ->orderBy('kontrak.kontrak_kode', 'asc')
                ->forPage($page, $size)
                ->get() : DB::Table('kontrak')
                ->select('komoditas.nama_komoditas')
                ->addSelect('kontrak.*')
                ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
                ->where('kontrak.informasi_akun_id', $user->informasi_akun_id)
                ->orderBy('kontrak.kontrak_kode', 'asc')
                ->forPage($page, $size)
                ->get();


            if ($total != 0 || $page_count != 0) {
                $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

                return response()->json([
                    'data' => $paginator,
                    'message' => 'data kontrak has been catched',
                    'status' => 'success',
                    'status' => $status
                ], 200);
            } else {
                return response()->json([
                    'data' => [],
                    'message' => 'data kontrak has been catched',
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
    public function api_show(Kontrak $kontrak)
    {
        return response()->json([
            'data' => $kontrak,
            'message' => 'kontrak has been catched',
            'status' => 'success'
        ], 200);
        exit;
    }
}
