@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Saldo</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.saldo.jaminan') }}">Saldo Jaminan</a></div>
        <div class="breadcrumb-item">Riwayat Saldo</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Riwayat Saldo</h2>
    <p class="section-lead">
        Lihat Riwayat Saldo anda.
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
                    <h4>{{ __('Riwayat Saldo') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped table-riwayat-jaminan">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
