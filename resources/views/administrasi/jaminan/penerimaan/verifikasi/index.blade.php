@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Verifikasi Penerimaan Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item">Verifikasi</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Verifikasi Penerimaan Jaminan</h2>
    <p class="section-lead">
        Kelola Verifikasi Penerimaan Jaminan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Verifikasi Penerimaan Jaminan') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('administrasi.jaminan.penerimaan.verifikasi.index_ditolak') }}" class="btn btn-danger">
                            Verifikasi Ditolak
                        </a>
                    </div>
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
