@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Anggota Dibekukan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item">Anggota Dibekukan</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Anggota Dibekukan</h2>
    <p class="section-lead">
        Kelola Anggota Dibekukan 
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Anggota Dibekukan ') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dibekukan">
                            <thead>
                                <tr>
                                    <th>Id Anggota</th>
                                    <th>Suspend Kode</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Jenis Anggota</th>
                                    <th>Tanggal</th>
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
