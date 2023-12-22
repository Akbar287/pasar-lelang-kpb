@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Sesi lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online') }}">Lelang Online</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event.show', $lelang->lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Sesi lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Sesi Lelang {{ $lelang->nomor_lelang }}</h2>
    <p class="section-lead">
        Sesi Lelang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8">
                    <div class="card">
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
                                    @if($lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Lelang' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Transaksi Selesai' || $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status == 'Verifikasi Transaksi Ditolak')
                                    <button class="btn btn-danger btn-block btn-lg closed_btn" disabled><i class="fas fa-times"></i> Ditutup</button>
                                    @else
                                    <button class="btn btn-danger btn-block btn-lg d-none closed_btn" disabled><i class="fas fa-times"></i> Ditutup</button>
                                    <button class="btn btn-info btn-block btn-lg d-none waiting_btn" disabled><i class="fas fa-clock"></i> Belum Dimulai</button>
                                    <button class="btn btn-success btn-block btn-lg d-none bid_btn" disabled><i class="fas fa-gavel"></i> Online</button>
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
                                                    <th>{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->member()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama : $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga }}  (<i class="fas fa fa-star"></i> {{ is_null($lelang->kontrak()->first()->informasi_akun()->first()->rating()->first()) ? '0.0' : $lelang->kontrak()->first()->informasi_akun()->first()->rating()->first()->avg_stars }})</th>
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
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Peserta Lelang') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->count() > 0)
                                @foreach($lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->peserta_lelang()->where('tanggal', $lelang->lelang_sesi_online()->first()->tanggal)->orderBy('kode_peserta_lelang', 'asc')->get() as $dpl)
                                <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                                    <button type="button" data-kode="{{ $dpl->kode_peserta_lelang }}" disabled class="btn btn-primary btn-block btn-rounded btn-peserta-lelang">{{ $dpl->kode_peserta_lelang }}</button>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12">
                                    <p class="text-muted">Belum Ada Peserta Lelang</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Penawar Tertinggi') }}</h4>
                        </div>
                        <div class="card-body text-center">
                            <h5>Rp. <span id="show_price">{{ number_format(!is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()) ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->harga_ajuan : $lelang->harga_awal, 0, ".", ",") }}</span></h5>
                        </div>
                    </div>
                    <div class="card" style="height: 450px;">
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
                                    <span class="badge badge-primary badge-pill">{{ $dplb->peserta_lelang()->first()->kode_peserta_lelang }}</span> <div>{{ str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT) . ':' . str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600) - (str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) * 60)), 2, '0', STR_PAD_LEFT); }}</div> Rp. {{ number_format($dplb->harga_ajuan, 0, '.', ',') }}
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">Belum ada penawaran</p>
                            @endif
                            @elseif($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                            @if($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->count() > 0)
                            <ul class="list-group">
                                @foreach($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->get() as $dplb)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="badge badge-primary badge-pill">{{ $dplb->master_sesi_lelang()->first()->peserta_lelang()->first()->kode_peserta_lelang }}</span> <div>{{ str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT) . ':' . str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600) - (str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) * 60)), 2, '0', STR_PAD_LEFT); }}</div> Rp. {{ number_format($dplb->harga_ajuan, 0, '.', ',') }}
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">Belum ada penawaran</p>
                            @endif
                            @elseif(!$lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline)
                            @if($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->count() > 0)
                            <ul class="list-group">
                                @foreach($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->get() as $dplb)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="badge badge-primary badge-pill">{{ $dplb->master_sesi_lelang()->first()->peserta_lelang()->first()->kode_peserta_lelang }}</span> <div>{{ str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT) . ':' . str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600) - (str_pad(floor(($dplb->waktu - ((str_pad(floor($dplb->waktu / 3600), 2, '0', STR_PAD_LEFT)) * 3600)) / 60), 2, '0', STR_PAD_LEFT) * 60)), 2, '0', STR_PAD_LEFT); }}</div> Rp. {{ number_format($dplb->harga_ajuan, 0, '.', ',') }}
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
        </div>
    </div>
</div>
@endsection
