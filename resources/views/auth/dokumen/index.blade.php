@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dokumen Anggota</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item">Dokumen Anggota</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Dokumen Member</h2>
    <p class="section-lead">
        Kelola Dokumen Anggota.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Dokumen Anggota') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('home.profil.dokumen.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dokumen-profil">
                            <thead>
                                <tr>
                                    <th>Jenis Dokumen</th>
                                    <th>Tanggal Unggah</th>
                                    <th>Nama Dokumen</th>
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
