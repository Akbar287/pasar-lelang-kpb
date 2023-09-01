@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Profile</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item">Profile</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Profile</h2>
    <p class="section-lead">
        Kelola Profile 
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Profile ') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('offline.profile.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-profile">
                            <thead>
                                <tr>
                                    <th>Registrasi Id</th>
                                    <th>Nama</th>
                                    <th>Aktif</th>
                                    <th>Tanggal Registrasi</th>
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
