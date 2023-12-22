@extends('layouts.app')

@section('content')

@if(is_null(Auth::user()->operator_pasar_lelang()->first()))
    @if(!is_null(Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()))
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Anggota</h4>
                        </div>
                        <div class="card-body">
                            {{$data['anggota']}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Produk</h4>
                        </div>
                        <div class="card-body">
                            {{$data['produk']}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Transaksi</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ number_format($data['transaksi'], 0, ".", ",") }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-warning">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Komoditas</h4>
                        </div>
                        <div class="card-body">
                            {{$data['komoditas']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(is_null(Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()))
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Kontrak</h4>
                        </div>
                        <div class="card-body">
                            {{$data['kontrak']}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Produk Lelang</h4>
                        </div>
                        <div class="card-body">
                            {{$data['produk']}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jaminan</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ $data['jaminan'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-warning">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Saldo</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ $data['saldo'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(is_null(Auth::user()->informasi_akun()->first()->member()->first()->informasi_keuangan()->first()) || is_null(Auth::user()->informasi_akun()->first()->area_member()->first()) || is_null(Auth::user()->informasi_akun()->first()->dokumen_member()->first()) || is_null(Auth::user()->informasi_akun()->first()->rekening_bank()->first()))
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="alert alert-danger">Akun anda belum diverifikasi. Segera Lengkapi Informasi yang dibutuhkan di menu <a href="{{route('home.profil')}}">Profil</a></div>
            </div>
        </div>
        @endif
    @endif
@endif

@if(!is_null(Auth::user()->operator_pasar_lelang()->first()))
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Event Offline</h4>
                        </div>
                        <div class="card-body">
                            {{$data['anggota']}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Event Hybrid</h4>
                        </div>
                        <div class="card-body">
                            {{$data['produk']}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Transaksi</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ number_format($data['transaksi'], 0, ".", ",") }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-warning">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Anggota</h4>
                        </div>
                        <div class="card-body">
                            {{$data['komoditas']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif





@if(is_null(Auth::user()->operator_pasar_lelang()->first()))
    @if(is_null(Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()))
    @endif

    @if(!is_null(Auth::user()->informasi_akun()->first()->member()->first()->admin()->first()))
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Transaksi</h4>
                </div>
                <div class="card-body">
                    <canvas id="chart_primary" height="250" style="display: block; width: 461px; height: 279px;" width="461" class="chartjs-render-monitor"></canvas>
                    <div class="statistic-details mt-sm-4">
                        <div class="statistic-details-item">
                            <div class="detail-value">Rp. {{ number_format($data['lelang']['online'], 0, ".", ",") }}</div>
                            <div class="detail-name">Online</div>
                        </div>
                        <div class="statistic-details-item">
                            <div class="detail-value">Rp. {{ number_format($data['lelang']['offline'], 0, ".", ",") }}</div>
                            <div class="detail-name">Offline</div>
                        </div>
                        <div class="statistic-details-item">
                            <div class="detail-value">Rp. {{ number_format($data['lelang']['hybrid'], 0, ".", ",") }}</div>
                            <div class="detail-name">Hybrid</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Produk Di Lelang</h4>
                </div>
                <div class="card-body">
                    <canvas id="chart_secondary" height="250" style="display: block; width: 461px; height: 279px;" width="461" class="chartjs-render-monitor"></canvas>
                    <div class="statistic-details mt-sm-4">
                        <div class="statistic-details-item">
                            <div class="detail-value">{{ $data['produkData']['online'] }}</div>
                            <div class="detail-name">Online</div>
                        </div>
                        <div class="statistic-details-item">
                            <div class="detail-value">{{ $data['produkData']['offline'] }}</div>
                            <div class="detail-name">Offline</div>
                        </div>
                        <div class="statistic-details-item">
                            <div class="detail-value">{{ $data['produkData']['hybrid'] }}</div>
                            <div class="detail-name">Hybrid</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Verifikasi Calon Anggota</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.anggota.verifikasi') }}" class="btn btn-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ca as $c)
                                <tr>
                                    <td>
                                        <p>{{ $c->created_at->format('d F Y') }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $c->nama }}</p>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Verifikasi" href="{{ route('master.anggota.verifikasi.show', [$c->informasi_akun_id]) }}" data-original-title="Verifikasi"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Verifikasi Kontrak</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.kontrak.verifikasi') }}" class="btn btn-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Perdagangan</th>
                                    <th>Nama Komoditas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kontrak as $c)
                                <tr>
                                    <td>
                                        <p>{{ $c->created_at->format('d F Y') }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $c->nama_perdagangan }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $c->nama_komoditas }}</p>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Verifikasi" href="{{ route('master.kontrak.verifikasi.show', [$c->kontrak_id]) }}" data-original-title="Verifikasi"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endif

@endsection
