@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Verifikasi Jaminan Penerimaan Ditolak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.verifikasi.index') }}">Verifikasi</a></div>
        <div class="breadcrumb-item">Ditolak</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Verifikasi Jaminan Penerimaan Ditolak</h2>
    <p class="section-lead">
        Kelola Jaminan Penerimaan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Verifikasi Jaminan Penerimaan Ditolak') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-jaminan-verifikasi">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Nilai Jaminan</th>
                                    <th>Haircut</th>
                                    <th>Nilai Penyesuaian</th>
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
