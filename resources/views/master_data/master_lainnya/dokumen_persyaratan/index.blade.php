@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jenis Dokumen</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item">Jenis Dokumen</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Jenis Dokumen</h2>
    <p class="section-lead">
        Kelola Jenis Dokumen.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Jenis Dokumen') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.lain.dokumen_persyaratan.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dokumen_persyaratan">
                            <thead>
                                <tr>
                                    <th>Id Jenis Dokumen</th>
                                    <th>Nama Jenis</th>
                                    <th>Keterangan</th>
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
