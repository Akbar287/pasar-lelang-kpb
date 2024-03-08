@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Produk Lelang</h4>
                </div>
                <div class="card-body">
                    {{ $produk['total_produk'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-box"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Produk lelang Terjual</h4>
                </div>
                <div class="card-body">
                    {{ $produk['total_produk_terjual'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-danger">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Produk Lelang Tidak Terjual</h4>
                </div>
                <div class="card-body">
                    {{ $produk['total_produk_tidak_jual'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-warning">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Produk Lelang Proses Konfirmasi</h4>
                </div>
                <div class="card-body">
                    {{ $produk['total_produk_konfirmasi'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-12 col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Persentase Pelelangan Produk</h4>
            </div>
            <div class="card-body">
                <canvas id="chart_pelelangan_produk" height="250" style="display: block; width: 461px; height: 279px;" width="461" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Persentase Platform Lelang</h4>
            </div>
            <div class="card-body">
                <canvas id="chart_platform_produk" height="250" style="display: block; width: 461px; height: 279px;" width="461" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Anggota Berdasarkan Kontrak</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-anggota">
                        <thead>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No. Kontrak</th>
                            <th>Komoditas</th>
                            <th>Harga Awal</th>
                            <th>Platform</th>
                            <th>Terjual</th>
                        </thead>
                        <tbody>
                            @foreach($produk['produk_lelang'] as $l)
                            <tr>
                                <td>{{ $l->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nik }}</td>
                                <td>{{ $l->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}</td>
                                <td>{{ $l->kontrak()->first()->kontrak_kode }}</td>
                                <td>{{ $l->kontrak()->first()->komoditas()->first()->nama_komoditas }}</td>
                                <td>{{ 'Rp. '. number_format($l->harga_awal, 0, ".", ",") }}</td>
                                <td>{{ is_null($l->jenis_platform_lelang()->first()) ? '-' : ($l->jenis_platform_lelang()->first()->online && $l->jenis_platform_lelang()->first()->offline ? 'Hybrid' : ($l->jenis_platform_lelang()->first()->online && !$l->jenis_platform_lelang()->first()->offline ? 'Online' : 'Offline')) }}</td>
                                <td>{!! !is_null($l->approval_lelang()->first()) ? '<div class="badge badge-success">Terjual</div>' : '<div class="badge badge-danger">Belum</div>' !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
