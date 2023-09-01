@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Operator Pasar Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item">Operator Pasar Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Operator Pasar Lelang</h2>
    <p class="section-lead">
        Kelola Operator Pasar Lelang 
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Operator Pasar Lelang ') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('offline.operator.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-operator">
                            <thead>
                                <tr>
                                    <th>User Id</th>
                                    <th>Nama</th>
                                    <th>Aktif</th>
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
