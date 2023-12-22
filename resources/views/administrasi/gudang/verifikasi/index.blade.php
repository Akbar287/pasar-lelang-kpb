@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item">Verifikasi</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Gudang</h2>
    <p class="section-lead">
        Kelola Gudang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">@if(session('msg')){!! session('msg') !!} @endif</div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Verifikasi Gudang') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('administrasi.gudang.verifikasi.index_ditolak') }}" class="btn btn-danger">
                            Verifikasi Ditolak
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-gudang-verifikasi">
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
