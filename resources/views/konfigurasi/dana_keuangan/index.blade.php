@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dana Keuangan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item">Dana Keuangan</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Dana Keuangan</h2>
    <p class="section-lead">
        Lihat Dana Keuangan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Dana Keuangan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dana-keuangan">
                            <thead>
                                <tr>
                                    <th>Id Dana</th>
                                    <th>Jenis</th>
                                    <th>Jumlah Dana</th>
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
