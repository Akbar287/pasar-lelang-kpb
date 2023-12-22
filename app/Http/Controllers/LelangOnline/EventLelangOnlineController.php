<?php

namespace App\Http\Controllers\LelangOnline;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\JenisDokumenProduk;
use App\Models\Lelang;
use App\Models\LelangSesiOnline;
use App\Models\MasterSesiLelang;
use App\Models\PesertaLelang;
use App\Models\StatusLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EventLelangOnlineController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LelangSesiOnline::join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->whereBetween('lelang_sesi_online.tanggal', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(7)->format('Y-m-d')])->orderBy('tanggal', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penyelenggara', function ($row) {
                    return $row->master_sesi_lelang()->first()->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                })
                ->addColumn('sesi', function ($row) {
                    return $row->master_sesi_lelang()->first()->sesi . ' (' . $row->jam_mulai . '-' . $row->jam_berakhir . ')';
                })
                ->addColumn('total', function ($row) {
                    return $row->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $row->tanggal)->count();
                })
                ->addColumn('judul', function ($row) {
                    return $row->judul ?? "-";
                })
                ->addColumn('harga_awal', function ($row) {
                    return 'Rp. ' . number_format($row->harga_awal ?: 0, 0, ".", ",");
                })
                ->addColumn('kelipatan_harga', function ($row) {
                    return 'Rp. ' . number_format($row->kelipatan_penawaran ?: 0, 0, ".", ",");
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('online.event.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('lelang_online/event/index');
    }

    public function index_history(Request $request)
    {
        $form = [
            'date' =>  $request->has('tanggal') ? $request->tanggal : date('Y-m-d'),
            'sesi' =>  $request->has('sesi') ? $request->sesi : 'semua'
        ];
        if ($request->ajax()) {
            $data = LelangSesiOnline::join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->where('lelang_sesi_online.tanggal', $form['date'])->get();

            if ($request->has('sesi')) {
                if ($request->sesi != 'semua') {
                    $data = LelangSesiOnline::join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')->where('lelang_sesi_online.tanggal', $form['date'])->where('lelang_sesi_online.master_sesi_lelang_id', $request->sesi)->get();
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('penyelenggara', function ($row) {
                    return $row->master_sesi_lelang()->first()->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama;
                })
                ->addColumn('sesi', function ($row) {
                    return $row->master_sesi_lelang()->first()->sesi . ' (' . $row->jam_mulai . '-' . $row->jam_berakhir . ')';
                })
                ->addColumn('total', function ($row) {
                    return $row->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $row->tanggal)->count();
                })
                ->addColumn('judul', function ($row) {
                    return $row->judul ?? "-";
                })
                ->addColumn('harga_awal', function ($row) {
                    return 'Rp. ' . number_format(!is_null($row->harga_awal) ? $row->harga_awal : 0.0, 0, ".", ",");
                })
                ->addColumn('kelipatan_harga', function ($row) {
                    return 'Rp. ' . number_format(!is_null($row->kelipatan_penawaran) ? $row->kelipatan_penawaran : 0.0, 0, ".", ",");
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('online.event.history.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $sesi = MasterSesiLelang::select('sesi')->addSelect('master_sesi_lelang_id')->orderBy('sesi', 'asc')->get();
        return view('lelang_online/event/index_history', compact('sesi', 'form'));
    }

    public function show_history(Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('lelang_online/event/show_history', compact('lelang', 'jenisDokumen'));
    }

    public function sesi_doc(Request $request, Lelang $lelang, $file)
    {
        $request->validate([
            'no_surat' => ['required'],
            'tipe_format' => ['required']
        ]);

        $tempPembeli = ($lelang->jenis_platform_lelang()->first()->online == true && $lelang->jenis_platform_lelang()->first()->offline == false) ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first() : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first();

        $kode = '00';
        if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            $kode = !is_null($lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $tempPembeli->informasi_akun_id)->first()) ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('informasi_akun_id', $tempPembeli->informasi_akun_id)->first()->kode_peserta_lelang : '-';
        } else {
            $kode = !is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()->daftar_peserta_lelang()->first()->kode_peserta_lelang : '-';
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

            if (is_null($approval_lelang)) {
                if ($lelang->jenis_platform_lelang()->first()->online == true && $lelang->jenis_platform_lelang()->first()->offline == false) {
                    return redirect('/online/event/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Tidak Ada Pembeli di Produk Lelang ini.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    exit;
                } else if ($lelang->jenis_platform_lelang()->first()->online == true && $lelang->jenis_platform_lelang()->first()->offline == true) {
                    redirect('/offline/event/' . $lelang->event_lelang()->first()->event_lelang_id . '/produk/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Tidak Ada Pembeli di Produk Lelang ini.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                } else {
                    redirect('/offline/event/' . $lelang->event_lelang()->first()->event_lelang_id . '/produk/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Tidak Ada Pembeli di Produk Lelang ini.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            }
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
        //     $section->addText(
        //         '"Learn from yesterday, live for today, hope for tomorrow. '
        //             . 'The important thing is not to stop questioning." '
        //             . '(Albert Einstein)'
        //     );

        //     $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        //     $fontStyle->setBold(true);
        //     $fontStyle->setName('Tahoma');
        //     $fontStyle->setSize(13);
        //     $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        //     $myTextElement->setFontStyle($fontStyle);

        //     $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        //     $objWriter->save('storage/print_odt/spjb.odt');

        //     return Storage::download('public/print_odt/spjb_' . $lelang->nomor_lelang . '.odt');
        // }
    }

    public function produk_show(Lelang $lelang)
    {
        $jenisDokumen = JenisDokumenProduk::get();
        return view('lelang_online/event/produk_show', compact('lelang', 'jenisDokumen'));
    }

    public function produk_sesi(Lelang $lelang)
    {
        return view('lelang_online/event/produk_sesi', compact('lelang'));
    }

    public function online_list_lelang_sesi_api_list(Request $request, MasterSesiLelang $masterSesiLelang, LelangSesiOnline $lelangSesiOnline, Lelang $lelang)
    {
        return $this->online_list_lelang_sesi_api($request, $lelang);
    }

    public function online_list_lelang_sesi_api(Request $request, Lelang $lelang)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
            exit;
        } else {
            if ($request->code == 'getAnyRequest') {
                $waktuMulai = strtotime($lelang->lelang_sesi_online()->first()->tanggal . ' ' . $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_mulai);
                $waktuSelesai = strtotime($lelang->lelang_sesi_online()->first()->tanggal . ' ' . $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_berakhir);

                if (time() > $waktuMulai && time() < $waktuSelesai) {
                    // aktif
                    if ($lelang->peserta_lelang_aktif()->count() == 0) {
                        $lelang->peserta_lelang_aktif()->create([
                            'master_sesi_lelang_id' => $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id,
                            'lelang_sesi_online_id' => $lelang->lelang_sesi_online()->first()->lelang_sesi_online_id,
                            'aktif' => true,
                            'waktu_mulai' => $waktuMulai,
                            'waktu_selesai' => null
                        ]);
                    }

                    return response()->json([
                        'data' => [
                            'riwayat' => PesertaLelang::where('master_sesi_lelang_id', $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id)->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->where('peserta_lelang_berlangsung.lelang_id', $lelang->lelang_id)->join('peserta_lelang_berlangsung', 'peserta_lelang_berlangsung.peserta_lelang_id', 'peserta_lelang.peserta_lelang_id')->orderBy('waktu', 'asc')->get(),
                            'aktif' => true,
                            'done' => false,
                            'harga' => is_null($lelang->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()) ? $lelang->harga_awal : $lelang->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()->harga_ajuan, // Cek
                            'count' => time() - $waktuMulai,
                        ],
                        'message' => 'data has been collected',
                        'status' => 'success'
                    ], 200);
                } else {
                    if (time() > $waktuMulai) {
                        // Selesai
                        if ($lelang->peserta_lelang_aktif()->count() == 0) {
                            $lelang->peserta_lelang_aktif()->create([
                                'master_sesi_lelang_id' => $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id,
                                'lelang_sesi_online_id' => $lelang->lelang_sesi_online()->first()->lelang_sesi_online_id,
                                'lelang_id' => $lelang->lelang_id,
                                'aktif' => false,
                                'waktu_mulai' => $waktuMulai,
                                'waktu_selesai' => $waktuSelesai
                            ]);
                        } else {
                            $lelang->peserta_lelang_aktif()->first()->update([
                                'aktif' => false,
                                'waktu_selesai' => $waktuSelesai
                            ]);
                        }

                        $status = StatusLelang::where('nama_status', 'Selesai')->first();
                        if ($lelang->status_lelang_pivot()->where('status_lelang_id', $status->status_lelang_id)->where('is_aktif', true)->count() == 0) {
                            foreach ($lelang->status_lelang_pivot()->get() as $l) {
                                $l->update([
                                    'is_aktif' => false
                                ]);
                            }

                            $lelang->status_lelang_pivot()->create([
                                'status_lelang_id' => $status->status_lelang_id,
                                'lelang_id' => $lelang->lelang_id,
                                'created_at' => date('Y-m-d'),
                                'is_aktif' => true
                            ]);
                        }

                        if (!is_null($lelang->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first())) {
                            if (is_null($lelang->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()->approval_lelang()->first())) {
                                if (is_null($lelang->approval_lelang()->first())) {
                                    $this->createApprovalLelang($lelang);
                                }
                            }
                        }

                        return response()->json([
                            'data' => [
                                'riwayat' => PesertaLelang::where('master_sesi_lelang_id', $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id)->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->join('peserta_lelang_berlangsung', 'peserta_lelang_berlangsung.peserta_lelang_id', 'peserta_lelang.peserta_lelang_id')->orderBy('waktu', 'asc')->get(),
                                'aktif' => false,
                                'done' => true,
                                'harga' => is_null($lelang->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()) ? 0 : $lelang->peserta_lelang_berlangsung()->orderBy('waktu', 'desc')->first()->harga_ajuan, // Cek
                                'count' => 0,
                            ],
                            'message' => 'data has been collected',
                            'status' => 'success'
                        ], 200);
                    } else {
                        // Belum Mulai

                        return response()->json([
                            'data' => [
                                'riwayat' => [],
                                'aktif' => false,
                                'done' => false,
                                'harga' => $lelang->harga_awal,
                                'count' => $waktuMulai - time(),
                            ],
                            'message' => 'data has been collected',
                            'status' => 'success'
                        ], 200);
                    }
                }
            } else if ($request->code == 'penawaran') {
                $waktuMulai = strtotime($lelang->lelang_sesi_online()->first()->tanggal . ' ' . $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_mulai);

                if ($lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id != Auth::user()->informasi_akun_id) {
                    $lastPrice = PesertaLelang::where('master_sesi_lelang_id', $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id)->join('peserta_lelang_berlangsung', 'peserta_lelang.peserta_lelang_id', 'peserta_lelang_berlangsung.peserta_lelang_id')->where('peserta_lelang_berlangsung.lelang_id', $lelang->lelang_id)->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->orderBy('peserta_lelang_berlangsung.waktu', 'desc')->first();

                    if (is_null($lastPrice)) {
                        Auth::user()->informasi_akun()->first()->peserta_lelang()->where('master_sesi_lelang_id', $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id)->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->first()->peserta_lelang_berlangsung()->create([
                            'lelang_id' => $lelang->lelang_id,
                            'harga_ajuan' => is_null($lastPrice) ? $lelang->harga_awal : $lastPrice->harga_ajuan + $lelang->kelipatan_penawaran,
                            'waktu' => time() - $waktuMulai
                        ]);

                        return response()->json([
                            'data' => [
                                'riwayat' => 0,
                                'aktif' => false,
                                'done' => false,
                                'harga' => $lelang->harga_awal, // Cek
                                'countdown_aktif' => 0,
                                'countdown' => 0,
                                'success' => true
                            ],
                            'message' => 'data has been collected',
                            'status' => 'success'
                        ], 200);
                        exit;
                    } else {
                        if ($lastPrice->kode_peserta_lelang == intval($request->peserta)) {
                            return response()->json([
                                'data' => null,
                                'message' => 'Kamu tidak bisa Bidding setelah kamu bidding sebelumnya',
                                'status' => 'failed',
                            ], 200);
                            exit;
                        } else {
                            Auth::user()->informasi_akun()->first()->peserta_lelang()->where('master_sesi_lelang_id', $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->master_sesi_lelang_id)->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->first()->peserta_lelang_berlangsung()->create([
                                'lelang_id' => $lelang->lelang_id,
                                'harga_ajuan' => is_null($lastPrice) ? $lelang->harga_awal : $lastPrice->harga_ajuan + $lelang->kelipatan_penawaran,
                                'waktu' => time() - $waktuMulai
                            ]);

                            return response()->json([
                                'data' => [
                                    'riwayat' => 0,
                                    'aktif' => false,
                                    'done' => false,
                                    'harga' => $lelang->harga_awal, // Cek
                                    'countdown_aktif' => 0,
                                    'countdown' => 0,
                                    'success' => true
                                ],
                                'message' => 'data has been collected',
                                'status' => 'success'
                            ], 200);
                            exit;
                        }
                    }
                } else {
                    return response()->json([
                        'data' => null,
                        'message' => 'penjual tidak dapat bid di produk lelangnya',
                        'status' => 'failed'
                    ], 200);
                }
            } else {
                return response()->json([
                    'data' => null,
                    'message' => 'data not collected',
                    'status' => 'failed'
                ], 200);
            }
        }
    }

    public function api_lelang_online(Request $request)
    {
        $page = $request->get('page') ?? 0;
        $size = $request->get('size') ?? 5;
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = Carbon::createFromFormat('Y-m-d', $request->tanggal_awal, 'Asia/Jakarta');
            $tanggal_akhir = Carbon::createFromFormat('Y-m-d', $request->tanggal_akhir, 'Asia/Jakarta');

            if ($tanggal_akhir->diffInMicroseconds($tanggal_awal) < 0) {
                $temp = $tanggal_awal;
                $tanggal_awal = $tanggal_akhir;
                $tanggal_akhir = $temp;
            }
        }

        $total = ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) ?
            LelangSesiOnline::select('lelang_sesi_online.*')
            ->addSelect('master_sesi_lelang.*')
            ->addSelect('ktp.nama')
            ->addSelect('lelang.*')
            ->addSelect('dokumen_produk.*')
            ->addSelect('komoditas.nama_komoditas')
            ->join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')
            ->join('dokumen_produk', 'dokumen_produk.lelang_id', 'lelang.lelang_id')
            ->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')
            ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'master_sesi_lelang.penyelenggara_pasar_lelang_id')
            ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
            ->join('member', 'member.member_id', 'admin.member_id')
            ->join('ktp', 'ktp.member_id', 'member.member_id')
            ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
            ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
            ->where('dokumen_produk.is_gambar_utama', 'true')
            ->whereBetween('lelang_sesi_online.tanggal', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('lelang_sesi_online.tanggal', 'desc')
            ->orderBy('master_sesi_lelang.sesi', 'desc')
            ->count() :

            LelangSesiOnline::select('lelang_sesi_online.*')
            ->addSelect('master_sesi_lelang.*')
            ->addSelect('ktp.nama')
            ->addSelect('lelang.*')
            ->addSelect('dokumen_produk.*')
            ->addSelect('komoditas.nama_komoditas')
            ->join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')
            ->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')
            ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'master_sesi_lelang.penyelenggara_pasar_lelang_id')
            ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
            ->join('dokumen_produk', 'dokumen_produk.lelang_id', 'lelang.lelang_id')
            ->join('member', 'member.member_id', 'admin.member_id')
            ->join('ktp', 'ktp.member_id', 'member.member_id')
            ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
            ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
            ->where('dokumen_produk.is_gambar_utama', 'true')
            ->orderBy('lelang_sesi_online.tanggal', 'desc')
            ->orderBy('master_sesi_lelang.sesi', 'desc')
            ->count();

        $page_count = ceil($total / $size);

        $data = ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) ?
            DB::Table('lelang_sesi_online')
            ->select('lelang_sesi_online.*')
            ->addSelect('master_sesi_lelang.*')
            ->addSelect('ktp.nama')
            ->addSelect('lelang.*')
            ->addSelect('dokumen_produk.*')
            ->addSelect('komoditas.nama_komoditas')
            ->join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')
            ->join('dokumen_produk', 'dokumen_produk.lelang_id', 'lelang.lelang_id')
            ->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')
            ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'master_sesi_lelang.penyelenggara_pasar_lelang_id')
            ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
            ->join('member', 'member.member_id', 'admin.member_id')
            ->join('ktp', 'ktp.member_id', 'member.member_id')
            ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
            ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
            ->orderBy('lelang_sesi_online.tanggal', 'desc')
            ->orderBy('master_sesi_lelang.sesi', 'desc')
            ->where('dokumen_produk.is_gambar_utama', 'true')
            ->whereBetween('lelang_sesi_online.tanggal', [$tanggal_awal, $tanggal_akhir])
            ->forPage($page, $size)
            ->get() :
            DB::Table('lelang_sesi_online')
            ->select('lelang_sesi_online.*')
            ->addSelect('master_sesi_lelang.*')
            ->addSelect('ktp.nama')
            ->addSelect('lelang.*')

            ->addSelect('dokumen_produk.*')
            ->addSelect('komoditas.nama_komoditas')
            ->join('lelang', 'lelang.lelang_id', 'lelang_sesi_online.lelang_id')
            ->join('dokumen_produk', 'dokumen_produk.lelang_id', 'lelang.lelang_id')
            ->join('master_sesi_lelang', 'master_sesi_lelang.master_sesi_lelang_id', 'lelang_sesi_online.master_sesi_lelang_id')
            ->join('penyelenggara_pasar_lelang', 'penyelenggara_pasar_lelang.penyelenggara_pasar_lelang_id', 'master_sesi_lelang.penyelenggara_pasar_lelang_id')
            ->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')
            ->join('member', 'member.member_id', 'admin.member_id')
            ->join('ktp', 'ktp.member_id', 'member.member_id')
            ->join('kontrak', 'kontrak.kontrak_id', 'lelang.kontrak_id')
            ->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')
            ->where('dokumen_produk.is_gambar_utama', 'true')
            ->orderBy('lelang_sesi_online.tanggal', 'desc')
            ->orderBy('master_sesi_lelang.sesi', 'desc')
            ->forPage($page, $size)
            ->get();

        if ($total != 0 || $page_count != 0) {
            $paginator = new LengthAwarePaginator($data, $total, $page_count, $page);

            return response()->json([
                'data' => $paginator,
                'message' => 'Sesi Lelang online has been catched',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'Sesi Lelang online has been catched',
                'status' => 'success'
            ], 200);
        }
    }

    public function api_lelang_online_detail(Lelang $lelang)
    {
        $lelang_sesi_online = $lelang->lelang_sesi_online()->first();

        return response()->json([
            'data' => [
                'peserta' => PesertaLelang::where('tanggal', $lelang_sesi_online->tanggal)->where('master_sesi_lelang_id', $lelang_sesi_online->master_sesi_lelang_id)->first(),
                'bidder' => $lelang->peserta_lelang_berlangsung()->get()
            ],
            'status' => 'success',
            'message' => 'data lelang online detail'
        ], 200);
        exit;
    }

    public function createApprovalLelang($lelang)
    {
        if (is_null($lelang->jenis_platform_lelang()->first())) {
            // Tidak Ada
            return 'Tidak Ada';
        } else if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            //Online
            $peserta_lelang_berlangsung = $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            if (!is_null($peserta_lelang_berlangsung)) {
                $informasiAkunIdPembeli = $peserta_lelang_berlangsung->peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
                if (is_null($peserta_lelang_berlangsung->approval_lelang()->first())) {
                    $approval_lelang = $this->createApprovalLelangOnline($lelang, $peserta_lelang_berlangsung);
                } else {
                    $approval_lelang = $peserta_lelang_berlangsung->approval_lelang()->first();
                }
            } else {
                return null;
                exit;
            }
        } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            // Hybrid
            $daftar_peserta_lelang_berlangsung = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            if (!is_null($daftar_peserta_lelang_berlangsung)) {
                $informasiAkunIdPembeli = $daftar_peserta_lelang_berlangsung->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
                if (is_null($daftar_peserta_lelang_berlangsung->approval_lelang()->first())) {
                    $approval_lelang = $this->createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung);
                } else {
                    $approval_lelang = $daftar_peserta_lelang_berlangsung->approval_lelang()->first();
                }
            } else {
                return null;
                exit;
            }
        } else {
            // Offline
            $daftar_peserta_lelang_berlangsung = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            if (!is_null($daftar_peserta_lelang_berlangsung)) {
                $informasiAkunIdPembeli = $daftar_peserta_lelang_berlangsung->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
                if (is_null($daftar_peserta_lelang_berlangsung->approval_lelang()->first())) {
                    $approval_lelang = $this->createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung);
                } else {
                    $approval_lelang = $daftar_peserta_lelang_berlangsung->approval_lelang()->first();
                }
            } else {
                return null;
                exit;
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
