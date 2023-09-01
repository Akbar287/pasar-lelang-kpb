@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Produk Event</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event.show', $event->event_lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event.produk', $event->event_lelang_id) }}">Produk Event Lelang</a></div>
        <div class="breadcrumb-item">Detail Produk</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Produk Event</h2>
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
                        <div class="badge badge-success">{{ $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status }}</div>
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
                            @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai')
                            <div class="section-title mt-0">Dokumen Lelang</div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('offline.event.produk.sesi_doc', [$event->event_lelang_id, $lelang->lelang_id, 'pdf']) }}"><i class="fas fa-print"></i> Surat Perjanjian (PDF)</a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('offline.event.produk.sesi_doc', [$event->event_lelang_id, $lelang->lelang_id, 'doc']) }}"><i class="fas fa-print"></i> Surat Perjanjian (DOC)</a>
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
                                        @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai')
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-12">Penawaran Terbaik</div>
                                                @if(is_null($lelang->jenis_platform_lelang()->first())) 
                                                <div class="badge badge-danger">Belum Diatur</div>
                                                @elseif($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline)
                                                <div class="col-12"><h5>Rp. {{ number_format(($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan), 0, ".", ",") }}</h5></div>
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
                                    <a href="{{ route('offline.event.produk.sesi', [$event->event_lelang_id, $lelang->lelang_id]) }}" class="btn btn-danger btn-block"><i class="fas fa-times"></i> Ditutup</a>
                                    @elseif($lelang->status_lelang_pivot()->join('status_lelang', 'status_lelang.status_lelang_id', 'status_lelang_pivot.status_lelang_id')->where('status_lelang.nama_status', 'Aktif')->count() > 0)
                                    <a href="{{ route('offline.event.produk.sesi', [$event->event_lelang_id, $lelang->lelang_id]) }}" class="btn btn-primary btn-block"><i class="fas fa-clock"></i> Menunggu Sesi Lelang</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('offline.event.produk', $event->event_lelang_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
