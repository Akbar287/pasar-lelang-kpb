<?php

namespace App\Http\Controllers\LelangOffline;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Admin;
use App\Models\DaftarPesertaLelang;
use App\Models\EventLelang;
use App\Models\InformasiAkun;
use App\Models\StatusMember;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\DataTables;

class EventLelangAnggotaController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, EventLelang $event)
    {
        if ($request->ajax()) {
            $data = $event->daftar_peserta_lelang()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    if (isset($row->lembaga_id)) {
                        $actionBtn = $row->nama_lembaga;
                    } else {
                        $actionBtn = $row->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('username', function ($row) {
                    $actionBtn = $row->informasi_akun()->first()->userlogin()->first()->username;
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('offline.event.anggota.show', [$row->event_lelang()->first()->event_lelang_id, $row->daftar_peserta_lelang_id]) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_offline/event_anggota/index', compact('event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, EventLelang $event)
    {
        $members = StatusMember::where('nama_status', 'Aktif')->first()->member()->whereNotIn('member_id', Admin::select('member.member_id')->join('member', 'member.member_id', 'admin.member_id')->get()->toArray())->whereNotIn('member_id', $event->daftar_peserta_lelang()->select('member.member_id')->join('informasi_akun', 'daftar_peserta_lelang.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->get()->toArray())->get();
        $rekomendasiNomor = $this->rekomendasiKodeAnggota($event);
        return view('lelang_offline/event_anggota/create', compact('event', 'members', 'rekomendasiNomor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, EventLelang $event)
    {
        if ($event->daftar_peserta_lelang()->where('kode_peserta_lelang', $request->kode_peserta_lelang)->count() == 0) {
            $anggota = $event->daftar_peserta_lelang()->where('informasi_akun_id', request('informasi_akun_id'))->first();

            if (!is_null($anggota)) {
                $anggota->update($this->daftarPesertaLelang());
            } else {
                $anggota = $event->daftar_peserta_lelang()->create($this->daftarPesertaLelang());
            }

            return redirect('/offline/event/' . $event->event_lelang_id . '/anggota/' . $anggota->daftar_peserta_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota Lelang telah di tambah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/offline/event/' . $event->event_lelang_id . '/anggota/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Kode Event: ' . $request->kode_peserta_lelang . ' telah ada sebelumnya.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventLelang $event, DaftarPesertaLelang $anggota)
    {
        return view('lelang_offline/event_anggota/show', compact('event', 'anggota'));
    }

    public function show_komoditi(EventLelang $event)
    {
        $penjual = [];
        $tempNama = [];
        foreach ($event->lelang()->get() as $l) {
            $tempNama[] = $l->kontrak()->first()->informasi_akun_id;
        }
        $tempNama = array_values(array_unique($tempNama));

        $informasiAkunAll = InformasiAkun::whereIn('informasi_akun_id', $tempNama)->get();


        for ($i = 0; $i < count($tempNama); $i++) {
            $temp = [];
            foreach ($event->lelang()->get() as $l) {
                if (!is_null($l->kontrak()->where('informasi_akun_id', $tempNama[$i])->first())) {
                    $temp[] = $l->kontrak()->first()->komoditas()->first()->nama_komoditas;
                }
            }
            $penjual[] = [
                'nama' => $informasiAkunAll->where('informasi_akun_id', $tempNama[$i])->first()->member()->first()->ktp()->first()->nama,
                'komoditas' => array_unique($temp)
            ];
        }
        unset($tempNama);

        return view('lelang_offline/event_anggota/show_komoditi', compact('event', 'penjual'));
    }

    public function show_komoditi_cetak(EventLelang $event)
    {
        $penjual = [];
        $tempNama = [];
        foreach ($event->lelang()->get() as $l) {
            $tempNama[] = $l->kontrak()->first()->informasi_akun_id;
        }
        $tempNama = array_values(array_unique($tempNama));

        $informasiAkunAll = InformasiAkun::whereIn('informasi_akun_id', $tempNama)->get();

        for ($i = 0; $i < count($tempNama); $i++) {
            $temp = [];
            foreach ($event->lelang()->get() as $l) {
                if (!is_null($l->kontrak()->where('informasi_akun_id', $tempNama[$i])->first())) {
                    $temp[] = $l->kontrak()->first()->komoditas()->first()->nama_komoditas;
                }
            }
            $penjual[] = [
                'nama' => $informasiAkunAll->where('informasi_akun_id', $tempNama[$i])->first()->member()->first()->ktp()->first()->nama,
                'komoditas' => array_unique($temp)
            ];
        }
        unset($tempNama);

        return Helper::show_komoditi_member_sesi($event, $penjual);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventLelang $event, DaftarPesertaLelang $anggota)
    {
        $members = StatusMember::where('nama_status', 'Aktif')->first()->member()->whereNotIn('member_id', Admin::select('member.member_id')->join('member', 'member.member_id', 'admin.member_id')->get()->toArray())->whereNotIn('member_id', $event->daftar_peserta_lelang()->select('member.member_id')->join('informasi_akun', 'daftar_peserta_lelang.informasi_akun_id', 'informasi_akun.informasi_akun_id')->join('member', 'member.informasi_akun_id', 'informasi_akun.informasi_akun_id')->whereNot('member_id', $anggota->informasi_akun()->first()->member()->first()->member_id)->get()->toArray())->get();
        return view('lelang_offline/event_anggota/edit', compact('event', 'anggota', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventLelang $event, DaftarPesertaLelang $anggota)
    {
        $anggota->update($this->daftarPesertaLelang());

        return redirect('/offline/event/' . $event->event_lelang_id . '/anggota/' . $anggota->daftar_peserta_lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota Lelang telah di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventLelang $event, DaftarPesertaLelang $anggota)
    {
        $anggota->delete();

        return redirect('/offline/event/' . $event->event_lelang_id . '/anggota')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Anggota Lelang telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function daftarPesertaLelang()
    {
        return [
            'informasi_akun_id' => request('informasi_akun_id'),
            'kode_peserta_lelang' => request('kode_peserta_lelang'),
        ];
    }

    public function rekomendasiKodeAnggota($event)
    {
        $temp = $event->daftar_peserta_lelang()->count();
        return is_null($temp) ? 1 : intval($temp) + 1;
    }

    public function joinEventLelangOffline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_lelang_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        } else {
            $el = EventLelang::where('event_lelang_id', $request->event_lelang_id)->first();

            if (is_null($el)) {
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => 'UUID event lelang wrong'
                ], 400);
                exit;
            }
            try {
                $token = JWTAuth::getToken();
                $apy = JWTAuth::getPayload($token)->toArray();

                $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
                $data = $el->daftar_peserta_lelang()->where('informasi_akun_id', $user->informasi_akun_id)->first();

                if (is_null($data)) {
                    $data =  $el->daftar_peserta_lelang()->create([
                        'informasi_akun_id' => $user->informasi_akun_id,
                        'kode_peserta_lelang' => $this->rekomendasiKodeAnggota($el)
                    ]);
                }

                return response()->json([
                    'data' => $data,
                    'message' => 'kode anggota sesi lelang sudah digenerate',
                    'status' => 'success'
                ], 200);
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
}
