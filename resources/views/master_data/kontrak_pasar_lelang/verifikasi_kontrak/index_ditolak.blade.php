@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Verifikasi Kontrak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.kontrak') }}">Kontrak</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.kontrak.verifikasi') }}">Verifikasi Kontrak</a></div>
        <div class="breadcrumb-item">Riwayat Verifikasi Kontrak</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Riwayat Verifikasi Kontrak</h2>
    <p class="section-lead">
        Riwayat Verifikasi Kontrak.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Riwayat Verifikasi Kontrak') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-pengaturan-kontrak">
                            <thead>
                                <tr>
                                    <th>Id Kontrak</th>
                                    <th>Komoditas</th>
                                    <th>Jenis Perdagangan</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Tanggal Verifikasi</th>
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
