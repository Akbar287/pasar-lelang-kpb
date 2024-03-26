@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Lelang Transaksi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('lelang') }}">Lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('lelang.transaksi') }}">Transaksi</a></div>
        <div class="breadcrumb-item">Detail Produk</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Lelang Transaksi</h2>
    <p class="section-lead">
        detail data Detail Produk Event anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail Produk Event') }}</h4>
                    <div class="card-header-action">
                        <div class="badge badge-success">{{ $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status }}</div> {!! $lelang->kontrak()->first()->informasi_akun_id == Auth::user()->informasi_akun_id ? '<div class="badge badge-primary">Penjual</div>' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? ($lelang->approval_lelang()->first()->peserta_lelang_berlangsung()->first()->peserta_lelang()->first()->informasi_akun_id == Auth::user()->informasi_akun_id ? '<div class="badge badge-success">Pembeli</div>' : '') : ($lelang->approval_lelang()->first()->daftar_peserta_lelang_berlangsung()->first()->daftar_peserta_lelang()->first()->informasi_akun_id == Auth::user()->informasi_akun_id ? '<div class="badge badge-success">Pembeli</div>' : '')) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                            @if($lelang->dokumen_produk()->count() > 0)
                            <ul id="imageGallery">
                                @foreach($lelang->dokumen_produk()->get() as $dp)
                                <li data-thumb="{{ asset('storage/produk/' . $dp->nama_file) }}" data-src="{{ asset('storage/produk/' . $dp->nama_file) }}">
                                    <img src="{{ asset('storage/produk/' . $dp->nama_file) }}" alt="{{ $dp->nama_dokumen }}" width="270" />
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p>Tidak Ada Gambar</p>
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-6">
                            @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Lelang' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi Ditolak')
                            <div class="section-title mt-0">Dokumen Lelang</div>
                            <div class="row">
                                <div class="col-12">
                                    @if(!is_null($lelang->approval_lelang()->first()))
                                        @if(!is_null($lelang->approval_lelang()->first()->nomor_surat()->first()))
                                        <form action="{{ route('online.event.produk.sesi_doc', [$lelang->lelang_id, 'pdf']) }}" method="post"> @csrf
                                            <input type="hidden" required id="no_surat" name="no_surat" class="form-control" value="{{ !is_null($lelang->approval_lelang()->first()) ? (!is_null($lelang->approval_lelang()->first()->nomor_surat()->first()) ? $lelang->approval_lelang()->first()->nomor_surat()->first()->no_surat : '') : '' }}" placeholder="No Surat Anda" />
                                            <input type="hidden" name="tipe_format" value="pdf" />
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-print"></i> Surat Perjanjian</button>
                                        </form>
                                        @else
                                        <p>Admin belum memasukan nomor surat</p>
                                        @endif
                                    @else
                                    <p>Lelang Belum Selesai</p>
                                    @endif
                                </div>
                                <div class="col-12">
                                    {{-- <a href="{{ route('online.event.produk.sesi_doc', [$event->lelang_sesi_online_id, $lelang->lelang_id, 'doc']) }}"><i class="fas fa-print"></i> Surat Perjanjian (DOC)</a> --}}
                                </div>
                            </div>
                            @endif
                            <div class="section-title @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai') mt-8 @endif">Lelang</div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Paket Lelang</th>
                                            <td>{{ $lelang->nomor_lelang }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Lelang</th>
                                            <td>{{ $lelang->jenis_inisiasi()->first()->nama_inisiasi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hari Lelang</th>
                                            <td>{{ is_null($lelang->jenis_platform_lelang()->first()) ? 'Belum Ada' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->lelang_sesi_online()->first()->tanggal . ' ' . $lelang->lelang_sesi_online()->first()->master_sesi_online()->first()->jam_mulai . ' ' . $lelang->lelang_sesi_online()->first()->master_sesi_online()->first()->jam_berakhir : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? $lelang->event_lelang()->first()->tanggal_lelang . ' ' . $lelang->event_lelang()->first()->jam_mulai . '-' . $lelang->event_lelang()->first()->jam_selesai : $lelang->event_lelang()->first()->tanggal_lelang . ' ' . $lelang->event_lelang()->first()->jam_mulai . '-' . $lelang->event_lelang()->first()->jam_selesai)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penjual</th>
                                            <td>{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->member()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama : $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="section-title mt-2">Spesifikasi</div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Kode Produk</th>
                                            <td>{{ $lelang->kontrak()->first()->kontrak_kode }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Perdagangan</th>
                                            <td>{{ $lelang->kontrak()->first()->jenis_perdagangan()->first()->nama_perdagangan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Komoditas</th>
                                            <td>{{$lelang->kontrak()->first()->komoditas()->first()->nama_komoditas}}</td>
                                        </tr>
                                        <tr>
                                            <th>Asal komoditas</th>
                                            <td>{{ $lelang->asal_komoditas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kuantitas</th>
                                            <td>{{ number_format($lelang->kuantitas, 0, ".", ",") . ' ' . $lelang->kontrak()->first()->komoditas()->first()->satuan_ukuran }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kemasan</th>
                                            <td>{{ $lelang->kemasan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Judul</th>
                                            <td>{{ $lelang->judul }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td>{{ $lelang->spesifikasi_produk }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="section-title mt-2">Penyelesaian</div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Lokasi Serah</th>
                                            <td>{{ $lelang->lokasi_penyerahan }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="section-title mt-2">Ketentuan Lelang</div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Penawaran Mulai</th>
                                            <td>{{ 'Rp. ' . number_format($lelang->harga_awal, 2, ".", ",") }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kelipatan Penawaran</th>
                                            <td>{{ 'Rp. ' . number_format($lelang->kelipatan_penawaran, 2, ".", ",") }}</td>
                                        </tr>
                                        @if(!is_null($lelang->harga_beli_sekarang))
                                        <tr>
                                            <th>Harga Beli Sekarang</th>
                                            <td>{{ 'Rp. ' . number_format($lelang->harga_beli_sekarang, 2, ".", ",") }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Penawaran</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-12">Penawaran Mulai dari</div>
                                                <div class="col-12"><h5>Rp. {{ number_format($lelang->harga_awal, 0, ".", ",") }}</h5></div>
                                            </div>
                                        </li>
                                        @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Lelang' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi Ditolak')
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-12">Penawaran Terbaik</div>
                                                @if(is_null($lelang->jenis_platform_lelang()->first()))
                                                <div class="badge badge-danger">Belum Diatur</div>
                                                @elseif($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline)
                                                <div class="col-12"><h5>Rp. {{ number_format((is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? 0 : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan), 0, ".", ",") }}</h5></div>
                                                @elseif($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                                                <div class="col-12"><h5>Rp. {{ number_format(($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan), 0, ".", ",") }}</h5></div>
                                                @else
                                                <div class="col-12"><h5>Rp. {{ number_format(($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan), 0, ".", ",") }}</h5></div>
                                                @endif
                                            </div>
                                        </li>
                                        @elseif($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Aktif')
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-12">Kelipatan Penawaran</div>
                                                <div class="col-12"><h5>Rp. {{ number_format($lelang->kelipatan_penawaran, 0, ".", ",") }}</h5></div>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    @if($lelang->status_lelang_pivot()->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang.nama_status', 'Selesai')->count() > 0)
                                    <a href="{{ route('online.event.sesi', $lelang->lelang_id) }}" class="btn btn-danger btn-block disabled"><i class="fas fa-times"></i> Ditutup</a>
                                    @elseif($lelang->status_lelang_pivot()->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang.nama_status', 'Aktif')->count() > 0)
                                    <p class="text-center">{{ $lelang->lelang_sesi_online()->first()->tanggal . ', ('. $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_mulai . '-'. $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_berakhir .')' }}</p>
                                    <a href="{{ route('online.event.sesi', $lelang->lelang_id) }}" class="btn btn-primary btn-block disabled"><i class="fas fa-clock"></i> Menunggu Sesi Lelang</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Transaksi Keuangan') }}</h4>
                    <div class="card-header-action">
                    </div>
                </div>
                <div class="card-body">
                    @if(!is_null($approval_lelang))
                    @if($lelang->kontrak()->first()->informasi_akun_id == Auth::user()->informasi_akun_id)
                    @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title mt-0">Informasi Pembayaran Yang Diterima</div>
                            @if(is_null($lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()))

                            <div class="row mb-3 justify-content-center">
                                <label for="nama_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama_penjual" type="text" readonly
                                        class="form-control" name="nama_penjual"
                                        value="{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" />
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_opsi_pembayaran_lelang_id_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Opsi Pembayaran')
                                    }}</label>

                                <div class="col-md-6">
                                    @if(!is_null($approval_lelang))
                                    <input id="jenis_opsi_pembayaran_lelang_id_penjual" type="text" readonly
                                        class="form-control" name="jenis_opsi_pembayaran_lelang_id_penjual"
                                        value="{{ $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->jenis_opsi_pembayaran_lelang()->first()->nama_jenis }}" />
                                    @else
                                    <select class="custom-select @error('jenis_opsi_pembayaran_lelang_id_penjual') is-invalid @enderror" @if(count($jenisOpsiPembayaran) == 0) disabled @endif name="jenis_opsi_pembayaran_lelang_id_penjual" id="jenis_opsi_pembayaran_lelang_id_penjual">
                                        @foreach($jenisOpsiPembayaran as $ppl)
                                        <option {{ old('jenis_opsi_pembayaran_lelang_id') == $ppl->jenis_opsi_pembayaran_lelang_id ? 'selected' : '' }} value="{{ $ppl->jenis_opsi_pembayaran_lelang_id }}">{{ $ppl->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                    @endif

                                    @error('jenis_opsi_pembayaran_lelang_id_penjual')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tagihan_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Tagihan Penjual')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="tagihan_penjual" type="text" readonly
                                            class="form-control thousand-style  @error('tagihan_penjual') is-invalid @enderror" name="harga_deal"
                                            value="{{ number_format(($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal, 0, ".", ",") }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="biaya_lain_lain_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Biaya Lain Lain Penjual')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="biaya_lain_lain_penjual" type="text" @if(!is_null($approval_lelang)) readonly @endif
                                            class="form-control thousand-style  @error('biaya_lain_lain_penjual') is-invalid @enderror" name="biaya_lain_lain_penjual"
                                            value="{{!is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->biaya_lain_lain : '0' }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="penyelesaian_komoditas_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Penyelesaian Komoditas Penjual')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="penyelesaian_komoditas_penjual" type="text" readonly
                                            class="form-control thousand-style  @error('penyelesaian_komoditas_penjual') is-invalid @enderror" name="penyelesaian_komoditas_penjual"
                                            value="{{ !is_null($approval_lelang) ? number_format((($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->biaya_lain_lain, 0, ".", ",") : number_format(($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal, 0, ".", ",") }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="total_dibayar_ke_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Total Uang Yang Anda Terima')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="total_dibayar_ke_penjual" type="text" readonly
                                            class="form-control thousand-style  @error('total_dibayar_ke_penjual') is-invalid @enderror" name="total_dibayar_ke_penjual"
                                            value="{{ !is_null($approval_lelang) ? number_format(($hargaDeal + (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain) - ((($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->biaya_lain_lain), 0, ".", ",") : number_format($hargaDeal + (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal), 0, ".", ",") }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-12">
                                    <div class="section-title mt-0">Penerimaan Pembayaran</div>

                                    <div class="row mb-3 justify-content-center">
                                        <label for="rekening_bank_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Rekening Bank')
                                            }}</label>

                                        <div class="col-md-6">
                                            <input type="text" readonly value="{{ $rekeningBank->first()->nomor_rekening . ' ( Rp. '. number_format($rekeningBank->first()->saldo, 0, ",", ".") .')' }}" class="form-control">
                                            <span class="text-muted">Penerimaan Pembayaran akan di kreditkan ke akun rekening yang terpilih. membutuhkan bebertapa hari untuk menerima dana</span>

                                            @error('rekening_bank_pembeli')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="status_pembayaran_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Status Pemilihan Rekening')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa fa-info"></i></span>
                                            </div>
                                            <input id="status_pembayaran_penjual" type="text" readonly
                                                class="form-control  @error('status_pembayaran_penjual') is-invalid @enderror" name="status_pembayaran_penjual" value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->status : 'Belum Selesai' }}" />
                                            <span class="text-muted">Status akan berubah menjadi selesai ketika saldo pembayaran sudah masuk ke rekening penjual</span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    @else
                    <p>Penyelenggara atau admin perlu memverifikasi Penyelesaian Lelang Sebelum Anda Menerima Pembayaran dari Pembeli</p>
                    @endif
                    @else
                    @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title mt-0">Informasi Pembayaran Yang Perlu diselesaikan</div>
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nama_pembeli" type="text" readonly
                                        class="form-control" name="nama_pembeli"
                                        value="{{ is_null($lelang->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? ((!is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama) : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? ((!is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama) : ((!is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama))) }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_opsi_pembayaran_lelang_id_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Opsi Pembayaran')
                                    }}</label>

                                <div class="col-md-6">
                                    @if(!is_null($approval_lelang))
                                    <input id="jenis_opsi_pembayaran_lelang_id_pembeli" type="text" readonly
                                        class="form-control" name="jenis_opsi_pembayaran_lelang_id_pembeli"
                                        value="{{ $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->jenis_opsi_pembayaran_lelang()->first()->nama_jenis }}" />
                                    @else
                                    <select class="custom-select @error('jenis_opsi_pembayaran_lelang_id_pembeli') is-invalid @enderror" @if(count($jenisOpsiPembayaran) == 0) disabled @endif name="jenis_opsi_pembayaran_lelang_id_pembeli" id="jenis_opsi_pembayaran_lelang_id_pembeli">
                                        @foreach($jenisOpsiPembayaran as $ppl)
                                        <option {{ old('jenis_opsi_pembayaran_lelang_id') == $ppl->jenis_opsi_pembayaran_lelang_id ? 'selected' : '' }} value="{{ $ppl->jenis_opsi_pembayaran_lelang_id }}">{{ $ppl->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                    @endif

                                    @error('jenis_opsi_pembayaran_lelang_id_pembeli')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tagihan_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Tagihan Pembeli')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="tagihan_pembeli" type="text" readonly
                                            class="form-control thousand-style @error('tagihan_pembeli') is-invalid @enderror" name="harga_deal"
                                            value="{{ number_format($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal), 0, ".", ",") }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="biaya_lain_lain_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Biaya Lain Lain Pembeli')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="biaya_lain_lain_pembeli" type="text" @if(!is_null($approval_lelang)) readonly @endif
                                            class="form-control thousand-style @error('biaya_lain_lain_pembeli') is-invalid @enderror" name="biaya_lain_lain_pembeli"
                                            value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain : '0' }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="penyelesaian_komoditas_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Penyelesaian Komoditas Pembeli')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="penyelesaian_komoditas_pembeli" type="text" readonly
                                            class="form-control thousand-style  @error('penyelesaian_komoditas_pembeli') is-invalid @enderror" name="penyelesaian_komoditas_pembeli"
                                            value="{{ !is_null($approval_lelang) ? number_format(($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain), 0, ".", ",") : number_format($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal), 0, ".", ",") }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="total_yang_harus_dibayar" class="col-md-4 col-form-label text-md-end">{{ __('Total Uang Yang Harus Dibayar')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="total_yang_harus_dibayar" type="text" readonly
                                            class="form-control thousand-style  @error('total_yang_harus_dibayar') is-invalid @enderror" name="total_yang_harus_dibayar" value="{{ !is_null($approval_lelang) ? number_format(($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain), 0, ".", ",") : number_format($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal), 0, ".", ",") }}" />
                                    </div>
                                </div>
                            </div>


                        <form action="{{ route('lelang.transaksi.keuangan.masuk.update', [$lelang->lelang_id, $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->keuangan_masuk_id]) }}" method="post"> @csrf @method('put')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-title mt-0">Pembayaran</div>

                                    <div class="row mb-3 justify-content-center">
                                        <label for="rekening_bank_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Rekening Bank')
                                            }}</label>

                                        <div class="col-md-6">

                                            @if($approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->status == 'Belum Selesai')
                                            <select class="custom-select rekening_bank_pembeli @error('rekening_bank_pembeli') is-invalid @enderror" @if(count($rekeningBank) == 0) disabled @endif name="rekening_bank_pembeli" id="rekening_bank_pembeli">
                                                @foreach($rekeningBank as $rb)
                                                <option {{ old('rekening_bank_pembeli') == $rb->rekening_bank_id ? 'selected' : '' }} value="{{ $rb->rekening_bank_id }}">{{ $rb->nomor_rekening . ' (Rp. '. number_format($rb->saldo, 0, "," , ".") .')' }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-muted informasi-saldo">Saldo Anda: <span class="text-success">Rp. {{ number_format($rekeningBank->first()->saldo, 0, ",", ".") }}</span>; @if(($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain) - $rekeningBank->first()->saldo >= 0) Terdapat Kekurangan dana sebesar: <span class="text-danger">{{ 'Rp. '. number_format(($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain) - $rekeningBank->first()->saldo, 0, ",", ".") }} </span>@else Masih Ada Sisa Dana Sebesar <span class="text-primary">{{ 'Rp. '. number_format($rekeningBank->first()->saldo - ($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain), 0, ",", ".") }}</span> @endif</span>
                                            @else

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <input id="rekening_bank_pembeli" type="text" readonly
                                                    class="form-control  @error('rekening_bank_pembeli') is-invalid @enderror" name="rekening_bank_pembeli" value="{{ is_null($approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first()) ? '-' : $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first()->rekening_bank()->first()->nomor_rekening . '(Rp. '. number_format($approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first()->rekening_bank()->first()->saldo, 0, ",", ".") .')' }}" />
                                            </div>
                                            @endif
                                            @error('rekening_bank_pembeli')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3 justify-content-center">
                                        <label for="status_pembayaran_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Status Pembayaran')
                                            }}</label>

                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa fa-info"></i></span>
                                                </div>
                                                <input id="status_pembayaran_pembeli" type="text" readonly
                                                    class="form-control  @error('status_pembayaran_pembeli') is-invalid @enderror" name="status_pembayaran_pembeli" value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->status : 'Belum Selesai' }}" />
                                            </div>
                                        </div>
                                    </div>

                                    @if($approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->status == 'Belum Selesai')
                                    <div class="row mb-3 justify-content-center">
                                        <div class="col-md-4 col-form-label text-md-end"></div>

                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success btn-block">Bayar Sekarang</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                    @else
                    <p>Penyelenggara atau admin perlu memverifikasi Penyelesaian Lelang Sebelum Anda Melakukan Pembayaran ke Penjual</p>
                    @endif
                    @endif
                    @else
                    <p>Tidak Ada Pembeli</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Transaksi Komoditas') }}</h4>
                    <div class="card-header-action">
                    </div>
                </div>
                <div class="card-body">
                    @if(!is_null($approval_lelang))
                    @if($lelang->kontrak()->first()->informasi_akun_id == Auth::user()->informasi_akun_id)
                    @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title mt-0">Settlement</div>
                            <div class="row mb-3 justify-content-center">
                                <label for="kode_penyelesaian" class="col-md-4 col-form-label text-md-end">{{ __('Nomor ID Penyelesaian')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="kode_penyelesaian" type="text" readonly
                                        class="form-control" name="kode_penyelesaian"
                                        value="{{ !is_null($approval_lelang) ? $lelang->approval_lelang()->first()->pembayaran_lelang()->first()->nomor_penyelesaian : $kodePenyelesaian }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal" type="text" readonly
                                        class="form-control" name="tanggal"
                                        value="{{ $tanggal }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jatuh_tempo" class="col-md-4 col-form-label text-md-end">{{ __('Jatuh Tempo')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jatuh_tempo" type="text" readonly
                                        class="form-control" name="jatuh_tempo"
                                        value="{{ $jatuhTempo }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="section-title mt-0">Komoditas Keluar</div>
                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_instruksi_komoditas_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nomor_instruksi_komoditas_keluar" type="text" @if(!is_null($approval_lelang)) readonly @endif
                                        class="form-control" name="nomor_instruksi_komoditas_keluar"
                                        value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->no_instruksi : (is_null(old('nomor_instruksi_komoditas_keluar')) ? $instruksi['komoditas_keluar'] : old('nomor_instruksi_komoditas_keluar')) }}" />

                                    @error('nomor_instruksi_komoditas_keluar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_komoditas_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal_komoditas_keluar" type="text" readonly
                                        class="form-control" name="tanggal_komoditas_keluar"
                                        value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->tanggal_instruksi : (is_null(old('tanggal_komoditas_keluar')) ? date('Y-m-d') : old('tanggal_komoditas_keluar')) }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="status_komoditas_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="status_komoditas_keluar" type="text" readonly
                                        class="form-control" name="status_komoditas_keluar"
                                        value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status : 'Belum Selesai' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <p>Penyelenggara atau admin perlu memverifikasi Penyelesaian Lelang Sebelum Anda Menerima Pembayaran dari Pembeli</p>
                    @endif
                    @else
                    @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title mt-0">Settlement</div>
                            <div class="row mb-3 justify-content-center">
                                <label for="kode_penyelesaian" class="col-md-4 col-form-label text-md-end">{{ __('Nomor ID Penyelesaian')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="kode_penyelesaian" type="text" readonly
                                        class="form-control" name="kode_penyelesaian"
                                        value="{{ !is_null($approval_lelang) ? $lelang->approval_lelang()->first()->pembayaran_lelang()->first()->nomor_penyelesaian : $kodePenyelesaian }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal" type="text" readonly
                                        class="form-control" name="tanggal"
                                        value="{{ $tanggal }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jatuh_tempo" class="col-md-4 col-form-label text-md-end">{{ __('Jatuh Tempo')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jatuh_tempo" type="text" readonly
                                        class="form-control" name="jatuh_tempo"
                                        value="{{ $jatuhTempo }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="section-title mt-0">Komoditas Masuk</div>
                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_instruksi_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nomor_instruksi_komoditas_masuk" type="text" @if(!is_null($approval_lelang)) readonly @endif
                                        class="form-control" name="nomor_instruksi_komoditas_masuk"
                                        value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->no_instruksi : (is_null(old('nomor_instruksi_komoditas_masuk')) ? $instruksi['komoditas_masuk'] : old('nomor_instruksi_komoditas_masuk')) }}" />

                                        @error('nomor_instruksi_komoditas_masuk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_faktur_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Faktur')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nomor_faktur_komoditas_masuk" type="text" readonly
                                        class="form-control" name="nomor_faktur_komoditas_masuk"
                                        value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->no_faktur : $faktur['komoditas_masuk'] }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal_komoditas_masuk" type="text" readonly
                                        class="form-control" name="tanggal_komoditas_masuk"
                                        value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->tanggal_instruksi : (is_null(old('tanggal_komoditas_masuk')) ? date('Y-m-d') : old('tanggal_komoditas_masuk')) }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="status_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="status_komoditas_masuk" type="text" readonly
                                        class="form-control" name="status_komoditas_masuk"
                                        value="{{ !is_null($approval_lelang) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status : 'Belum Selesai' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <p>Penyelenggara atau admin perlu memverifikasi Penyelesaian Lelang Sebelum Anda Melakukan Pembayaran ke Penjual</p>
                    @endif
                    @endif
                    @else
                    <p>Tidak Ada Pembeli</p>
                    @endif
                </div>
            </div>

            @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Selesai')
            @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
            @if($lelang->kontrak()->first()->informasi_akun_id != Auth::user()->informasi_akun_id)
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Beri Rating Penjual') }}</h4>
                    <div class="card-header-action">
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('lelang.transaksi.rating.update', $lelang->lelang_id) }}" method="post"> @csrf @method('put')
                        <div class="row mb-3 justify-content-center">
                            <label for="rating" class="col-md-4 col-form-label text-md-end">{{ __('Beri Bintang')
                                }}</label>

                                @if(is_null($lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()))
                                <div class="rating">
                                    <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                                    <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                                    <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                                    <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                                    <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                                </div>
                                @else
                                <div class="rating-x" style="display: flex;flex-direction: row-reverse;justify-content: center;">
                                    @for($i=0; $i < $lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->star; $i++ )
                                    <input style="display:none;" type="radio" name="rating"><label style="position: relative;opacity: 1;width: 1em;font-size: 6vw;color: #95ff00;cursor: pointer;">☆</label>
                                    @endfor
                                </div>
                                @endif
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label for="rating_ulasan" class="col-md-4 col-form-label text-md-end">{{ __('Beri Ulasan')
                                }}</label>

                            <div class="col-md-6">
                                <textarea @if(!is_null($lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first())) readonly @endif id="rating_ulasan" type="text" class="form-control" name="rating_ulasan" cols="30" rows="10">{{ is_null($lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()) ? old('rating_ulasan') : (!is_null($lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->rating_ulasan()->first()) ? $lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->rating_ulasan()->first()->keterangan : '-') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label for="rating_ulasan" class="col-md-4 col-form-label text-md-end">{{ __('Tampilkan ')
                                }}</label>

                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" {{ is_null($lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()) ? '' : ($lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->secret ? 'checked' : '') }} name="secret" id="secret">
                                    <label class="custom-control-label" for="secret">Tampilkan Username Anonim ({{ str_split(Auth::user()->username, 3)['0'] . '***' }})</label>
                                </div>
                            </div>
                        </div>
                        @if(is_null($lelang->rating_detail()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()))
                        <div class="row mb-3 justify-content-center">
                            <div for="rating_ulasan" class="col-md-4 col-form-label text-md-end"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success"><i class="fas fa-pen"></i> Kirim Ulasan</button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            @endif
            @endif
            @endif

            @if(is_null($approval_lelang))
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Progress Status') }}</h4>
                </div>
                <div class="card-body">
                    <p>Tunggu Admin Lelang Mengonfirmasi transaksi lelang</p>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Progress Status') }}</h4>
                </div>
                <div class="card-body">
                    <div class="activities">
                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                        <div class="activity">
                            <div class="activity-icon @if($approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->status == 'Selesai') bg-primary @else bg-secondary @endif text-white shadow-primary">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">Selesai</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">27 Januari 2023</a>
                                </div>
                                <p>Saldo Pembayaran Lelang sudah dikirim ke Penjual.</p>
                            </div>
                        </div>
                        <div class="activity">
                            <div class="activity-icon @if($approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status == 'Selesai') bg-primary @else bg-secondary @endif text-white shadow-primary">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">Komoditas Diterima Pembeli</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">26 Januari 2023</a>
                                </div>
                                <p>Komoditas sudah diterima oleh penjual.</p>
                            </div>
                        </div>
                        <div class="activity">
                            <div class="activity-icon @if($approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status == 'Selesai') bg-primary @else bg-secondary @endif text-white shadow-primary">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">Komoditas Dikirim oleh Penjual</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">23 Januari 2023</a>
                                </div>
                                <p>Penjual Sudah mengirim Komoditas ke Penjual</p>
                            </div>
                        </div>
                        <div class="activity">
                            <div class="activity-icon @if($approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->status == 'Selesai') bg-primary @else bg-secondary @endif text-white shadow-primary">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">Pembayaran di terima dari Pembeli</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">22 Januari 2023</a>
                                </div>
                                <p>Pembayaran telah diterima dari Pembli melalui Saldo Penyelenggara</p>
                            </div>
                        </div>
                        @else
                        <div class="activity">
                            <div class="activity-icon bg-secondary text-white shadow-primary">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">Menunggu Penyelenggara memverifikasi lelang</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">27 Januari 2023</a>
                                </div>
                                <p>Tunggu hingga penyelenggara memverifikasi lelang.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Pilihan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if(!is_null($approval_lelang))
                                @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                    @if($lelang->kontrak()->first()->informasi_akun_id == Auth::user()->informasi_akun_id)
                                    {{-- Penjual  --}}
                                        @if($approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->status == 'Selesai' && $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status == 'Belum Selesai')
                                            @if(!is_null($approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()))
                                                @if($approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status == 'Belum Selesai')
                                                <div class="alert alert-danger">Anda perlu mengirim Komoditas ke pembeli sesuai besaran yang disepakati. Setelah itu, silahkan konfirmasi dengan memnekan tombol Komoditas sudah dikirim.</div>
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        {{-- Pembeli  --}}
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()))
                                            @if($approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status == 'Selesai' && $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status == 'Belum Selesai')
                                                @if($approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status == 'Belum Selesai')
                                                <div class="alert alert-danger">Anda perlu menekan tombol konfirmasi Komoditas Sudah diterima. Jika sudah menerima komoditas sesuai dengan deskripsi lelang.</div>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                    <a type="button" href="{{ route('lelang.transaksi') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>

                                    @if(!is_null($approval_lelang))
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                            @if($lelang->kontrak()->first()->informasi_akun_id == Auth::user()->informasi_akun_id)
                                            {{-- Penjual  --}}
                                                @if($approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->status == 'Selesai' && $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status == 'Belum Selesai')
                                                    @if(!is_null($approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()))
                                                        @if($approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status == 'Belum Selesai')
                                                        <form action="{{ route('lelang.transaksi.komoditas.keluar.update', [$lelang->lelang_id, $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->komoditas_keluar_id]) }}" method="POST">@csrf @method('put')
                                                            <button type="submit" onclick="return confirm('Komoditas dikonfirmasi sudah dikirim?')" title="Hapus Data" class="btn btn-success"><i class="fas fa-box"></i> Komoditas Sudah Dikirim</button>
                                                        </form>
                                                        @endif
                                                    @endif
                                                @endif
                                            @else
                                                {{-- Pembeli  --}}
                                                @if(!is_null($approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()))
                                                    @if($approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status == 'Selesai' && $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status == 'Belum Selesai')
                                                        @if($approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status == 'Belum Selesai')
                                                        <form action="{{ route('lelang.transaksi.komoditas.masuk.update', [$lelang->lelang_id, $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->komoditas_masuk_id]) }}" method="POST">@csrf @method('put')
                                                            <button type="submit" onclick="return confirm('Komoditas terkonfirmasi sudah diterima?')" title="Hapus Data" class="btn btn-success"><i class="fas fa-box"></i> Komoditas Sudah Diterima</button>
                                                        </form>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
