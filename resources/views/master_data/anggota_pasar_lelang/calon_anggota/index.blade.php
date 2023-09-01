@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Calon Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item">Calon Anggota</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Calon Anggota</h2>
    <p class="section-lead">
        Kelola Calon Anggota.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Calon Anggota') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.anggota.calon.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-calon-anggota">
                            <thead>
                                <tr>
                                    <th>Id Calon</th>
                                    <th>Nama</th>
                                    <th>No. Kontak</th>
                                    <th>Email</th>
                                    <th>Jenis Anggota</th>
                                    <th>Tanggal Regist</th>
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
