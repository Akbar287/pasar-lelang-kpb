@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Verifikasi Ditolak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi') }}">Transaksi Pasar lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.verifikasi_lelang') }}">Verifikasi Lelang</a></div>
        <div class="breadcrumb-item">Verifikasi Ditolak</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Verifikasi Ditolak</h2>
    <p class="section-lead">
        Kelola Verifikasi Ditolak.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Verifikasi Ditolak') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-verifikasi-lelang">
                            <thead>
                                <tr>
                                    <th>Id Lelang</th>
                                    <th>Nama</th>
                                    <th>Kontrak</th>
                                    <th>Nomor lelang</th>
                                    <th>Judul</th>
                                    <th>Harga Awal</th>
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
