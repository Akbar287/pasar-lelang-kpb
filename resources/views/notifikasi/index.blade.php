@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Notifikasi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Notifikasi</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Notifikasi</h2>
    <p class="section-lead">
        Kelola Notifikasi.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Notifikasi') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-notifikasi">
                            <thead>
                                <tr>
                                    <th>Id Notifikasi</th>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Status</th>
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
