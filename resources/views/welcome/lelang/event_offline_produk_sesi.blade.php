@extends('layouts.app-welcome')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('welcome.event_offline', $event->event_lelang_id) }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-12 col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ __('Detail Produk') }}</h4>
                <div class="card-header-action">
                    {!! is_null($lelang->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-success">Online</div>' : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? '<div class="badge badge-info">Hybrid</div>' : '<div class="badge badge-warning">Offline</div>')) !!}
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-12 col-sm-12 col-md-4 text-center">
                        @if($lelang->dokumen_produk()->count() > 0)
                        <img class="img img-thumbnail" src="{{ asset('storage/produk/' . $lelang->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_file) }}" alt="{{ $lelang->dokumen_produk()->where('is_gambar_utama', true)->first()->nama_dokumen }}" width="120" />
                        @else
                        <p>Tidak Ada Gambar</p>
                        @endif
                    </div>
                    <div class="col-12 col-sm-12 col-md-8 text-center pl-8">
                        <h4 class="text-warning" id="time">00:00:00</h4>
                        @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Lelang' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi Ditolak'
                        )
                        <button class="btn btn-danger btn-block btn-lg" disabled id="closed_btn"><i class="fas fa-times"></i> Ditutup</button>
                        @else
                        <button class="btn btn-danger btn-block btn-lg d-none" disabled id="closed_btn"><i class="fas fa-times"></i> Ditutup</button>
                        <button class="btn btn-warning btn-block btn-lg d-none" id="bid_btn" disabled>Anda Perlu Login</button>
                        <button class="btn btn-warning btn-block btn-lg d-none" id="waiting_btn" disabled>Menunggu Sesi Produk Lelang</button>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-between mt-2">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <td>Pemilik</td>
                                        <th>{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->member()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama : $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga }}</th>
                                    </tr>
                                    <tr>
                                        <td>Lokasi Penyerahan</td>
                                        <th>{{ $lelang->lokasi_penyerahan }}</th>
                                    </tr>
                                    <tr>
                                        <td>Penawaran Mulai Dari</td>
                                        <th>Rp. <span id="harga_awal">{{ number_format($lelang->harga_awal, 0, ".", ",") }}</span></th>
                                    </tr>
                                    <tr>
                                        <td>Kelipatan Penawaran</td>
                                        <th>Rp. <span id="kelipatan_harga">{{ number_format($lelang->kelipatan_penawaran, 0, ".", ",") }}</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ __('Informasi Dokumen Pendukung') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div id="accordion">
                            @foreach($jenisDokumen as $jd)
                            <div class="card">
                                <div class="card-header" id="heading-{{ $loop->iteration }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link {{ $loop->iteration == 1 ? 'collapsed' : '' }}" data-toggle="collapse" data-target="#collapse-{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse-{{ $loop->iteration }}">
                                            {{ $jd->nama_jenis }}
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse-{{ $loop->iteration }}" class="collapse {{ $loop->iteration == 1 ? 'show' : '' }}" aria-labelledby="heading-{{ $loop->iteration }}" data-parent="#accordion">
                                    <div class="card-body">
                                        @if($lelang->dokumen_produk()->where('jenis_dokumen_produk_id', $jd->jenis_dokumen_produk_id)->count() > 0)
                                        <div class="row">
                                        @foreach($lelang->dokumen_produk()->where('jenis_dokumen_produk_id', $jd->jenis_dokumen_produk_id)->get() as $dp)
                                            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                                                <a href="{{ asset('storage/produk/' . $dp->nama_file) }}" target="_blank" class="btn btn-primary">{{ $jd->nama_jenis }} #{{ $loop->iteration }}</a>
                                            </div>
                                        @endforeach
                                        </div>
                                        @else
                                        <p>Tidak Ada Dokumen {{ $jd->nama_jenis }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ __('Penawar Tertinggi') }}</h4>
            </div>
            <div class="card-body text-center">
                <h5>Rp. <span id="show_price">{{ number_format(!is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan : $lelang->harga_awal, 0, ".", ",") }}</span></h5>
            </div>
        </div>
        <div class="card mb-4" style="height: 450px;">
            <div class="card-header">
                <h4>{{ __('Riwayat Penawaran') }}</h4>
            </div>
            <div class="card-body text-center riwayat_penawaran" style="overflow-y: scroll;">
                @if(is_null($lelang->jenis_platform_lelang()->first()))
                <div class="badge badge-danger">Belum Ada</div>
                @elseif($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline)
                @if($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->count() > 0)
                <ul class="list-group">
                    @foreach($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->get() as $dplb)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="badge badge-primary badge-pill">{{ $dplb->daftar_peserta_lelang()->first()->kode_peserta_lelang }}</span> <div>{{ str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT) . ':' . str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600) - (str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) * 60)), 2, '0', STR_PAD_LEFT); }}</div> Rp. {{ number_format($dplb->harga_ajuan, 0, '.', ',') }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">Belum ada penawaran</p>
                @endif
                @elseif($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                @if($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->count() > 0)
                <ul class="list-group">
                    @foreach($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->get() as $dplb)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="badge badge-primary badge-pill">{{ $dplb->daftar_peserta_lelang()->first()->kode_peserta_lelang }}</span> <div>{{ str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT) . ':' . str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600) - (str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) * 60)), 2, '0', STR_PAD_LEFT); }}</div> Rp. {{ number_format($dplb->harga_ajuan, 0, '.', ',') }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">Belum ada penawaran</p>
                @endif
                @elseif(!$lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                @if($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->count() > 0)
                <ul class="list-group">
                    @foreach($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->get() as $dplb)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="badge badge-primary badge-pill">{{ $dplb->daftar_peserta_lelang()->first()->kode_peserta_lelang }}</span> <div>{{ str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT) . ':' . str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600) - (str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) * 60)), 2, '0', STR_PAD_LEFT); }}</div> Rp. {{ number_format($dplb->harga_ajuan, 0, '.', ',') }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">Belum ada penawaran</p>
                @endif
                @else
                <p class="text-muted">Belum ada penawaran</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
