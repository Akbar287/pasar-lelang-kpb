@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>List Lelang Offline</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item">List Lelang Offline</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">List Lelang Offline</h2>
    <p class="section-lead">
        Lihat List Lelang Offline
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Lihat Lelang Offline') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-sesi-lelang">
                                    <thead>
                                        <tr>
                                            <th>Penyelenggara</th>
                                            <th>Kode Event</th>
                                            <th>Nama Event</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Jenis</th>
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
    </div>
</div>
@endsection
