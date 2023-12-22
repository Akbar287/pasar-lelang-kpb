@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>File Kas Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank') }}">Kas Bank</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank.penerimaan.show', $keuangan->keuangan_id) }}">Detail</a></div>
        <div class="breadcrumb-item">File</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">File Kas Bank</h2>
    <p class="section-lead">
        Kelola File Kas Bank.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List File Kas Bank') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('administrasi.kas_bank.penerimaan.file.create', $keuangan->keuangan_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-kas_bank-penerimaan-file">
                            <thead>
                                <tr>
                                    <th>Id File Keuangan</th>
                                    <th>Tanggal</th>
                                    <th>Nama Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('administrasi.kas_bank.penerimaan.show', $keuangan->keuangan_id) }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
