@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Pengajuan Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('lelang') }}">Lelang</a></div>
        <div class="breadcrumb-item">Pengajuan Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Pengajuan Lelang</h2>
    <p class="section-lead">
        Kelola Pengajuan Lelang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Pengajuan Lelang') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('lelang.pengajuan.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-user">
                            <thead>
                                <tr>
                                    <th>Kontrak</th>
                                    <th>Nomor Lelang</th>
                                    <th>Judul</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Awal</th>
                                    <th>Kelipatan</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
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
