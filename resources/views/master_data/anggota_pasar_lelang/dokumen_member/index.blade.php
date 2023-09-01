@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dokumen Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list') }}">List</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.show', $anggota->informasi_akun_id) }}">Detail Anggota</a></div>
        <div class="breadcrumb-item">Dokumen Anggota</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Dokumen Anggota {{ is_null($anggota->lembaga()->first()) ? ($anggota->member()->first()->ktp()->first()->nama) : $anggota->lembaga()->first()->nama_lembaga }}</h2>
    <p class="section-lead">
        Kelola Dokumen Anggota {{ is_null($anggota->lembaga()->first()) ? ($anggota->member()->first()->ktp()->first()->nama) : $anggota->lembaga()->first()->nama_lembaga }}
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Dokumen Anggota ')  }} {{ is_null($anggota->lembaga()->first()) ? ($anggota->member()->first()->ktp()->first()->nama) : $anggota->lembaga()->first()->nama_lembaga }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.anggota.list.dokumen.create', $anggota->informasi_akun_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dokumen">
                            <thead>
                                <tr>
                                    <th>Id Dokumen</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Nama File</th>
                                    <th>Tanggal Upload</th>
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
