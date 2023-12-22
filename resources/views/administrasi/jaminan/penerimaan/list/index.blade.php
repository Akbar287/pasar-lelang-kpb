@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>List Jaminan Penerimaan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item">List</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">List Jaminan Penerimaan</h2>
    <p class="section-lead">
        Kelola List Jaminan Penerimaan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List List Jaminan Penerimaan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-jaminan-penerimaan-list">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Nilai Jaminan</th>
                                    <th>Nilai Penyesuaian</th>
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
