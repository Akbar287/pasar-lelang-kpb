@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Admin</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item">Admin</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Admin</h2>
    <p class="section-lead">
        Kelola Admin.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Admin') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.admin.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-admin">
                            <thead>
                                <tr>
                                    <th>Id Admin</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Status</th>
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
