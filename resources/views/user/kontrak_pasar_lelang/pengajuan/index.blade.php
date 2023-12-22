@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Pengajuan Kontrak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('kontrak') }}">Kontrak</a></div>
        <div class="breadcrumb-item">Pengajuan Kontrak</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Pengajuan Kontrak</h2>
    <p class="section-lead">
        Kelola Pengajuan Kontrak.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Kontrak') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('kontrak.pengajuan.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-kontrak-user">
                            <thead>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <th>Komoditas</th>
                                    <th>Jenis Perdagangan</th>
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
