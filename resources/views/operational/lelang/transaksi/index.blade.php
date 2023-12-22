@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Transaksi Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('operational') }}">Operational</a></div>
        <div class="breadcrumb-item">Transaksi Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Transaksi Lelang</h2>
    <p class="section-lead">
        Kelola Transaksi Lelang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Transaksi Lelang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-transaksi-lelang">
                            <thead>
                                <tr>
                                    <th>Jatuh Tempo</th>
                                    <th>Tanggal</th>
                                    <th>Kode Lelang</th>
                                    <th>Pembeli</th>
                                    <th>Penjual</th>
                                    <th>Harga</th>
                                    <th>Jenis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
