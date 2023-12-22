@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>List Lelang Online</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item">List Lelang Online</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">List Lelang Online</h2>
    <p class="section-lead">
        Lihat List Lelang Online
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Lihat Lelang Online') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sesi-lelang">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Sesi</th>
                                    <th>Produk</th>
                                    <th>Anggota</th>
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
