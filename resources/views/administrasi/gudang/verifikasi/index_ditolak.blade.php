@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Verifikasi Gudang Ditolak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang.verifikasi.index') }}">Verifikasi</a></div>
        <div class="breadcrumb-item">Ditolak</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Verifikasi Gudang Ditolak</h2>
    <p class="section-lead">
        Kelola Gudang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">@if(session('msg')){!! session('msg') !!} @endif</div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Verifikasi Gudang Ditolak') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-gudang-verifikasi-tolak">
                            <thead>
                                <tr>
                                    <th>Transaksi Id</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Registrasi</th>
                                    <th>Gudang</th>
                                    <th>Anggota</th>
                                    <th>Komoditas</th>
                                    <th>Nilai</th>
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
