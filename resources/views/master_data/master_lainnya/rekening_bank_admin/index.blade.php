@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Rekening Bank Admin</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item">Rekening Bank Admin</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Rekening Bank Admin</h2>
    <p class="section-lead">
        Kelola Rekening Bank Admin.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Rekening Bank Admin') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.lain.rekening.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-rekening-admin">
                            <thead>
                                <tr>
                                    <th>Id Rekening</th>
                                    <th>Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Nama Pemilik</th>
                                    <th>Cabang</th>
                                    <th>Mata Uang</th>
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
