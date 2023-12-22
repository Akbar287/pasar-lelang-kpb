@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Saldo Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Saldo Jaminan</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Saldo Jaminan</h2>
    <p class="section-lead">
        Lihat Saldo Jaminan anda.
    </p>
    <div class="row">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Total Saldo Jaminan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="title">Rp. {{ number_format(is_null(Auth::user()->informasi_akun()->first()->jaminan()->first()) ? 0 : Auth::user()->informasi_akun()->first()->jaminan()->first()->total_saldo_jaminan, 0, ".", ",") }}</h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <a href="{{ route('home.saldo.jaminan.deposit') }}" class="btn btn-primary btn-block">Deposit</a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <a href="{{ route('home.saldo.jaminan.withdraw') }}" class="btn btn-info btn-block">Withdraw</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Saldo Teralokasi') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="title">Rp. {{ number_format(is_null(Auth::user()->informasi_akun()->first()->jaminan()->first()) ? 0 : Auth::user()->informasi_akun()->first()->jaminan()->first()->saldo_teralokasi, 0, ".", ",") }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Saldo Tersedia') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="title">Rp. {{ number_format(is_null(Auth::user()->informasi_akun()->first()->jaminan()->first()) ? 0 : Auth::user()->informasi_akun()->first()->jaminan()->first()->saldo_tersedia, 0, ".", ",") }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Riwayat Transaksi') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('home.saldo.jaminan.riwayat') }}" class="btn btn-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 ">
                            <div class="table-responsive">
                                <table class="table-hover table-stripped table table-jaminan">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->informasi_akun()->first()->jaminan()->leftJoin('detail_jaminan','detail_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('pengeluaran_jaminan', 'pengeluaran_jaminan.jaminan_id', 'jaminan.jaminan_id')->limit(10)->get() as $j)
                                        <tr>
                                            <td>{{ is_null($j->detail_jaminan_id) ? $j->tanggal : $j->tanggal_transaksi }}</td>
                                            <td>{{ !is_null($j->detail_jaminan_id) ? 'Deposit' : 'Withdraw' }}</td>
                                            <td>{{ 'Rp. '. number_format(is_null($j->nilai_jaminan) ? $j->jumlah : $j->nilai_jaminan, 0, ".", ",") }}</td>
                                            <td>
                                                @if(is_null($j->detail_jaminan_id))
                                                    {{ is_null($j->join('pengeluaran_jaminan', 'pengeluaran_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan.pengeluaran_jaminan_id', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'pengeluaran_jaminan_verified_log.verified_log_id')->first()) ? 'Belum' : ($j->join('pengeluaran_jaminan', 'pengeluaran_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan.pengeluaran_jaminan_id', 'pengeluaran_jaminan_verified_log.pengeluaran_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'pengeluaran_jaminan_verified_log.verified_log_id')->first()->is_agree ? 'Disetujui' : 'Tidak Disetujui') }}
                                                @endif
                                                @if(!is_null($j->detail_jaminan_id))
                                                    {{ is_null($j->join('detail_jaminan', 'detail_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('detail_jaminan_verified_log', 'detail_jaminan.detail_jaminan_id', 'detail_jaminan_verified_log.detail_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'detail_jaminan_verified_log.verified_log_id')->first()) ? 'Belum' : ($j->join('detail_jaminan', 'detail_jaminan.jaminan_id', 'jaminan.jaminan_id')->leftJoin('detail_jaminan_verified_log', 'detail_jaminan.detail_jaminan_id', 'detail_jaminan_verified_log.detail_jaminan_id')->join('verified_log', 'verified_log.verified_log_id', 'detail_jaminan_verified_log.verified_log_id')->first()->is_agree ? 'Disetujui' : 'Tidak Disetujui') }}
                                                @endif
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
        </div>
    </div>
</div>
@endsection


