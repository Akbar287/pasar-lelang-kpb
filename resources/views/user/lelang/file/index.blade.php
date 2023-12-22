@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dokumen Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('lelang') }}">Lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('lelang.pengajuan') }}">Pengajuan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('lelang.pengajuan.show', $lelang->lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Dokumen Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Dokumen Lelang</h2>
    <p class="section-lead">
        Kelola Dokumen Lelang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Dokumen Lelang') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('lelang.pengajuan.file.create', $lelang->lelang_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-dokumen-user">
                            <thead>
                                <tr>
                                    <th>Id File</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Gambar</th>
                                    <th>Nama Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('lelang.pengajuan.show', $lelang->lelang_id) }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
