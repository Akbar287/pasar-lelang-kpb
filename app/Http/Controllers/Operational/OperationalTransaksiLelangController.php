<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiLelangRequest;
use App\Models\JenisOpsiPembayaranLelang;
use App\Models\JenisVerifikasi;
use App\Models\KeuanganKeluar;
use App\Models\KeuanganMasuk;
use App\Models\KomoditasKeluar;
use App\Models\KomoditasMasuk;
use App\Models\Lelang;
use App\Models\PembayaranLelang;
use App\Models\PenyelenggaraPasarLelang;
use App\Models\RekeningBank;
use App\Models\StatusLelang;
use App\Models\StatusPenyelesaian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class OperationalTransaksiLelangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $statusSelesai = StatusLelang::where('nama_status', 'Selesai')->first();
            $data = Lelang::join('status_lelang_pivot', 'status_lelang_pivot.lelang_id', 'lelang.lelang_id')->where('status_lelang_pivot.status_lelang_id', $statusSelesai->status_lelang_id)->where('status_lelang_pivot.is_aktif', true)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jatuh_tempo', function ($row) {
                    $actionBtn = new Carbon($row->created_at);
                    $actionBtn->addDays($row->kontrak()->first()->jatuh_tempo_t_plus);
                    return $actionBtn->translatedFormat('d F Y');
                })
                ->addColumn('tanggal', function ($row) {
                    $actionBtn = new Carbon($row->created_at);
                    return $actionBtn->translatedFormat('d F Y');
                })
                ->addColumn('penjual', function ($row) {
                    if (!is_null($row->kontrak()->first()->informasi_akun()->first()->lembaga()->first())) {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                    } else {
                        $actionBtn = $row->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                    }
                    return $actionBtn;
                })
                ->addColumn('pembeli', function ($row) {
                    if (is_null($row->jenis_platform_lelang()->first())) {
                        // Tidak Ada
                        return 'Tidak Ada';
                    } else if ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline) {
                        //Online
                        if (!is_null($row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first())) {
                            if (!is_null($row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) {
                                return $row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                            } else {
                                return $row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                            }
                        } else {
                        }
                    } else if ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline) {
                        // Hybrid
                        if (!is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first())) {
                            if (!is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) {
                                return $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                            } else {
                                return $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                            }
                        } else {
                        }
                    } else {
                        // Offline
                        if (!is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first())) {
                            if (!is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) {
                                return $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga;
                            } else {
                                return $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama;
                            }
                        }
                    }
                })
                ->addColumn('harga', function ($row) {
                    if (is_null($row->jenis_platform_lelang()->first())) {
                        // Tidak Ada
                        return 'Tidak Ada';
                    } else if ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline) {
                        //Online
                        return 'Rp. ' . number_format(is_null($row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $row->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan, 0, ".", ",");
                    } else if ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline) {
                        // Hybrid
                        return 'Rp. ' . number_format(is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan, 0, ".", ",");
                    } else {
                        // Offline
                        return 'Rp. ' . number_format(is_null($row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $row->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan, 0, ".", ",");
                    }
                })
                ->addColumn('jenis', function ($row) {
                    $actionBtn = is_null($row->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($row->jenis_platform_lelang()->first()->online && !$row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-success">Online</div>' : ($row->jenis_platform_lelang()->first()->online && $row->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-primary">Offline</div>'));
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('operational.lelang.transaksi.show', $row->lelang_id) . '" class="edit btn btn-success btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'jenis'])
                ->make(true);
        }
        return view('operational/lelang/transaksi/index');
    }

    public function show(Lelang $lelang)
    {
        // Tanggal dan Jatuh Tempo
        $tanggal = new Carbon($lelang->created_at);
        $tanggal = $tanggal->translatedFormat('d F Y');
        $jatuhTempo = new Carbon($lelang->created_at);
        $jatuhTempo = $jatuhTempo->addDays($lelang->kontrak()->first()->jatuh_tempo_t_plus);

        // Waktu Sekarang dan Cek Jatuh Tempo
        $now = Carbon::now();
        $isJatuhTempo = $jatuhTempo->isBefore($now);
        $now = $now->translatedFormat('Y-m-d H:i:s');

        // Harga Deal
        $hargaDeal = $lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? (is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan) : (is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan);

        // Generate Kode Penyelesaian
        $kodePenyelesaian = $this->generateKodePenyelesaian();

        // Rekening dan Opsi Pembayaran
        $rekening = [
            'penyelenggara' => PenyelenggaraPasarLelang::select('informasi_akun.informasi_akun_id')->addSelect('rekening_bank.rekening_bank_id')->addSelect('rekening_bank.nomor_rekening')->addSelect('rekening_bank.nama_pemilik')->addSelect('rekening_bank.mata_uang')->addSelect('rekening_bank.saldo')->join('admin', 'admin.admin_id', 'penyelenggara_pasar_lelang.admin_id')->join('member', 'member.member_id', 'admin.member_id')->join('informasi_akun', 'informasi_akun.informasi_akun_id', 'member.informasi_akun_id')->join('rekening_bank', 'rekening_bank.informasi_akun_id', 'informasi_akun.informasi_akun_id')->get(),
            'penjual' => $lelang->kontrak()->first()->informasi_akun()->first()->rekening_bank()->get()
        ];
        $jenisOpsiPembayaran = JenisOpsiPembayaranLelang::select('jenis_opsi_pembayaran_lelang_id')->addSelect('nama_jenis')->get();

        // Status Penyelesaian
        $jatuhTempo = $jatuhTempo->addDays($lelang->kontrak()->first()->jatuh_tempo_t_plus)->translatedFormat('d F Y');

        $statusPenyelesaian = StatusPenyelesaian::where('nama_jenis', '!=', 'Transaksi Pending')->get();


        // Generate Faktur
        $faktur = [
            'keuangan_masuk' => $this->generateKodeFakturKeuangan('IN'),
            'komoditas_masuk' => $this->generateKodeFakturKeuangan('OUT')
        ];

        // Generate Instruksi
        $instruksi = [
            'keuangan_masuk' => $this->generateKodeInstruktsiKeuangan("FIN", "IN"),
            'keuangan_keluar' => $this->generateKodeInstruktsiKeuangan("FIN", "OUT"),
            'komoditas_masuk' => $this->generateKodeInstruktsiKeuangan("COMM", "IN"),
            'komoditas_keluar' => $this->generateKodeInstruktsiKeuangan("COMM", "OUT"),
        ];

        // Get Approval Lelang if exist
        if (is_null($lelang->jenis_platform_lelang()->first())) {
            $approvalLelang = null;
        } else if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            //Online
            $approval_lelang = is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? null : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            // Hybrid
            $approval_lelang = is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? null : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        } else {
            // Offline
            $approval_lelang = is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? null : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first();
        }

        return view('operational/lelang/transaksi/show', compact('faktur', 'rekening', 'instruksi', 'lelang', 'jenisOpsiPembayaran', 'hargaDeal', 'kodePenyelesaian', 'tanggal', 'jatuhTempo', 'isJatuhTempo', 'statusPenyelesaian', 'approval_lelang'));
    }

    public function update(TransaksiLelangRequest $transaksiLelangRequest, Lelang $lelang)
    {
        $jatuhTempo = new Carbon($lelang->created_at);
        $jatuhTempo = $jatuhTempo->addDays($lelang->kontrak()->first()->jatuh_tempo_t_plus);
        $approval_lelang = null;
        $informasiAkunIdPembeli = null;

        if (is_null($lelang->jenis_platform_lelang()->first())) {
            // Tidak Ada
            return 'Tidak Ada';
        } else if ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline) {
            //Online
            $peserta_lelang_berlangsung = $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            $$informasiAkunIdPembeli = $peserta_lelang_berlangsung->peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
            if (is_null($peserta_lelang_berlangsung->approval_lelang()->first())) {
                $approval_lelang = $this->createApprovalLelangOnline($lelang, $peserta_lelang_berlangsung);
            } else {
                $approval_lelang = $peserta_lelang_berlangsung->approval_lelang()->first();
            }
        } else if ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline) {
            // Hybrid
            $daftar_peserta_lelang_berlangsung = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            $$informasiAkunIdPembeli = $daftar_peserta_lelang_berlangsung->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
            if (is_null($daftar_peserta_lelang_berlangsung->approval_lelang()->first())) {
                $approval_lelang = $this->createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung);
            } else {
                $approval_lelang = $daftar_peserta_lelang_berlangsung->approval_lelang()->first();
            }
        } else {
            // Offline
            $daftar_peserta_lelang_berlangsung = $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first();
            $$informasiAkunIdPembeli = $daftar_peserta_lelang_berlangsung->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id;
            if (is_null($daftar_peserta_lelang_berlangsung->approval_lelang()->first())) {
                $approval_lelang = $this->createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung);
            } else {
                $approval_lelang = $daftar_peserta_lelang_berlangsung->approval_lelang()->first();
            }
        }

        // Status lelang
        foreach ($lelang->status_lelang_pivot()->get() as $na) {
            $na->update(['is_aktif' => false]);
        }
        $statusTransaksiLelang = StatusLelang::where('nama_status', 'Transaksi Lelang')->first();
        $statusVerifikasiTransaksi = StatusLelang::where('nama_status', 'Verifikasi Transaksi')->first();
        $lelang->status_lelang_pivot()->create([
            'status_lelang_id' => $statusTransaksiLelang->status_lelang_id,
            'is_aktif' => false
        ]);
        $lelang->status_lelang_pivot()->create([
            'status_lelang_id' => $statusVerifikasiTransaksi->status_lelang_id,
            'is_aktif' => true
        ]);

        // Pembayaran Lelang
        $statusPenyelesaian = StatusPenyelesaian::where('status_penyelesaian_id', request('status_penyelesaian_id'))->first();
        $pembayaran_lelang =  $approval_lelang->pembayaran_lelang()->create($this->pembayaran_lelang($statusPenyelesaian->status_penyelesaian_id, request('kode_penyelesaian'), date('Y-m-d'), $jatuhTempo, request('keterangan')));

        // Opsi Pembayaran Lelang
        $opsi_pembayaran_lelang = $this->opsi_pembayaran_lelang($pembayaran_lelang, $lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id, ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->informasi_akun_id)), $lelang);

        // Rekening Bank Cek
        $rekeningBankPenyelenggaraKM = RekeningBank::where('rekening_bank_id', request('nomor_rekening_penyelenggara_keuangan_masuk'))->first();
        $rekeningBankPenyelenggaraKK = RekeningBank::where('rekening_bank_id', request('nomor_rekening_penyelenggara_keuangan_keluar'))->first();
        $rekeningBankPenjualKK = RekeningBank::where('rekening_bank_id', request('nomor_rekening_penjual_keuangan_keluar'))->first();

        // Keuangan Masuk
        $keuanganMasuk = $pembayaran_lelang->keuangan_masuk()->create($this->keuangan_masuk($pembayaran_lelang->pembayaran_lelang_id, $rekeningBankPenyelenggaraKM->rekening_bank_id, request('tanggal_keuangan_masuk'), request('nomor_instruksi_keuangan_masuk'), request('nomor_faktur_keuangan_masuk'), request('status_keuangan_masuk')));

        // Keuangan Keluar
        $keuanganKeluar = $pembayaran_lelang->keuangan_keluar()->create($this->keuangan_keluar($pembayaran_lelang->pembayaran_lelang_id, request('nomor_instruksi_keuangan_keluar'), request('tanggal_keuangan_keluar'), request('status_keuangan_keluar')));
        $keuanganKeluar->rekening_keuangan_asal()->create([
            'rekening_bank_id' => $rekeningBankPenyelenggaraKK->rekening_bank_id,
            'jenis_rekening' => 'asal'
        ]);
        $keuanganKeluar->rekening_keuangan_asal()->create([
            'rekening_bank_id' => $rekeningBankPenjualKK->rekening_bank_id,
            'jenis_rekening' => 'tujuan'
        ]);

        // Komoditas
        $komoditasMasuk = $pembayaran_lelang->komoditas_masuk()->create($this->komoditas_masuk($pembayaran_lelang->pembayaran_lelang_id, request('tanggal_komoditas_masuk'), request('nomor_instruksi_komoditas_masuk'), request('nomor_faktur_komoditas_masuk'), request('status_komoditas_masuk')));
        $komoditasKeluar = $pembayaran_lelang->komoditas_keluar()->create($this->komoditas_keluar($pembayaran_lelang->pembayaran_lelang_id, request('tanggal_komoditas_keluar'), request('nomor_instruksi_komoditas_keluar'), request('status_komoditas_keluar')));

        return redirect('/operational/lelang/transaksi/' . $lelang->lelang_id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Data Transaksi Lelang telah di simpan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function opsi_pembayaran_lelang($pembayaran_lelang, $informasiAkunPenjual, $informasiAkunPembeli, $lelang)
    {
        if (is_null($pembayaran_lelang->opsi_pembayaran_lelang()->first())) {
            // Harga Deal
            $hargaDeal = $lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan;

            $pembayaran_lelang->opsi_pembayaran_lelang()->create([
                'informasi_akun_id' => $informasiAkunPenjual,
                'jenis_opsi_pembayaran_lelang_id' => request('jenis_opsi_pembayaran_lelang_id_penjual'),
                'jenis_informasi_akun' => 'seller',
                'tagihan' => ($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal,
                'biaya_lain_lain' => str_replace(',', '', request('biaya_lain_lain_penjual')),
                'penyelesaian' => ($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal + str_replace(',', '', request('biaya_lain_lain_penjual')),
            ]);
            $pembayaran_lelang->opsi_pembayaran_lelang()->create([
                'informasi_akun_id' => $informasiAkunPembeli,
                'jenis_opsi_pembayaran_lelang_id' => request('jenis_opsi_pembayaran_lelang_id_pembeli'),
                'jenis_informasi_akun' => 'buyer',
                'tagihan' => $hargaDeal + (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal),
                'biaya_lain_lain' => str_replace(',', '', request('biaya_lain_lain_pembeli')),
                'penyelesaian' => (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + str_replace(',', '', request('biaya_lain_lain_pembeli')),
            ]);
        }
        return $pembayaran_lelang->opsi_pembayaran_lelang()->get();
    }

    public function createVerifiedLog($lelang)
    {
        $jenisVerifikasi = JenisVerifikasi::where('nama_verifikasi', 'Verifikasi Transaksi Lelang')->first();
        return Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()->verified_log()->create($this->verified_log($lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id, $jenisVerifikasi->jenis_verifikasi_id, true, date('Y-m-d'), ''));
    }

    public function createApprovalLelangOffline($lelang, $daftar_peserta_lelang_berlangsung)
    {
        return $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->create($this->approval_lelang($lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id, $lelang->lelang_id, $lelang->jenis_harga()->first()->jenis_harga_id, $daftar_peserta_lelang_berlangsung->harga_ajuan));
    }

    public function createApprovalLelangOnline($lelang, $peserta_lelang_berlangsung)
    {
        return $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->create($this->approval_lelang($lelang->kontrak()->first()->informasi_akun()->first()->informasi_akun_id, $lelang->lelang_id, $lelang->jenis_harga()->first()->jenis_harga_id, $peserta_lelang_berlangsung->harga_ajuan));
    }

    public function generateKodePenyelesaian()
    {
        $loop = true;
        $i = 1;
        do {
            $temp = 'SEETLE-KPB-' . date('Y/m/d') . '-' . $i;
            $re = PembayaranLelang::where('nomor_penyelesaian', $temp)->count();

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
    }

    public function generateKodeFakturKeuangan($type)
    {
        $loop = true;
        $i = 1;
        do {

            if ($type == 'IN') {
                $temp = 'PLK-FIN-KPB-' . $type . '-' . date('Y/m/d') . '-' . $i;
            } else {
                $temp = 'PLK-COMM-KPB-' . $type . '-' . date('Y/m/d') . '-' . $i;
            }

            if ($type == 'IN') {
                $re = KeuanganMasuk::where('no_faktur', $temp)->count();
            } else {
                $re = KomoditasMasuk::where('no_faktur', $temp)->count();
            }

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
    }

    public function generateKodeInstruktsiKeuangan($type, $in)
    {
        $loop = true;
        $i = 1;
        do {

            if ($type == 'FIN') {
                if ($in == 'IN') {
                    $temp = 'INS-FIN-IN-KPB-' . $type . '-' . date('Y/m/d') . '-' . $i;
                } else {
                    $temp = 'INS-FIN-OUT-KPB-' . $type . '-' . date('Y/m/d') . '-' . $i;
                }
            } else {
                if ($in == 'IN') {
                    $temp = 'INS-COMM-IN-KPB-' . $type . '-' . date('Y/m/d') . '-' . $i;
                } else {
                    $temp = 'INS-COMM-OUT-KPB-' . $type . '-' . date('Y/m/d') . '-' . $i;
                }
            }


            if ($type == 'FIN') {
                if ($in == 'IN') {
                    $re = KeuanganMasuk::where('no_instruksi', $temp)->count();
                } else {
                    $re = KeuanganKeluar::where('no_instruksi', $temp)->count();
                }
            } else {
                if ($in == 'IN') {
                    $re = KomoditasMasuk::where('no_instruksi', $temp)->count();
                } else {
                    $re = KomoditasKeluar::where('no_instruksi', $temp)->count();
                }
            }

            if ($re == 0) {
                $loop = false;
            } else {
                $i++;
            }
        } while ($loop);

        return $temp;
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

    public function pembayaran_lelang($statusPenyelesaianId, $nomorPenyelesaian, $tanggal, $jatuhTempo, $ket)
    {
        return [
            'status_penyelesaian_id' => $statusPenyelesaianId,
            'nomor_penyelesaian' => $nomorPenyelesaian,
            'tanggal_pembayaran' => $tanggal,
            'tanggal_jatuh_tempo' => $jatuhTempo,
            'keterangan' => $ket
        ];
    }

    public function keuangan_masuk($pembayaranLelangId, $rekeningBankId, $tanggal, $nomorInstruksi, $nomorFaktur, $status)
    {
        return [
            'pembayaran_lelang_id' => $pembayaranLelangId,
            'rekening_bank_id' => $rekeningBankId,
            'tanggal_instruksi' => $tanggal,
            'no_instruksi' => $nomorInstruksi,
            'no_faktur' => $nomorFaktur,
            'status' => $status
        ];
    }

    public function keuangan_keluar($pembayaranLelangId, $nomorInstruksi, $tanggal, $status)
    {
        return [
            'pembayaran_lelang_id' => $pembayaranLelangId,
            'no_instruksi' => $nomorInstruksi,
            'tanggal_instruksi' => $tanggal,
            'status' => $status
        ];
    }

    public function komoditas_masuk($pembayaranLelangId, $tanggal, $nomorInstruksi, $nomorFaktur, $status)
    {
        return [
            'pembayaran_lelang_id' => $pembayaranLelangId,
            'tanggal_instruksi' => $tanggal,
            'no_instruksi' => $nomorInstruksi,
            'no_faktur' => $nomorFaktur,
            'status' => $status
        ];
    }

    public function komoditas_keluar($pembayaranLelangId, $tanggal, $nomorInstruksi, $status)
    {
        return [
            'pembayaran_lelang_id' => $pembayaranLelangId,
            'tanggal_instruksi' => $tanggal,
            'no_instruksi' => $nomorInstruksi,
            'status' => $status
        ];
    }
}
