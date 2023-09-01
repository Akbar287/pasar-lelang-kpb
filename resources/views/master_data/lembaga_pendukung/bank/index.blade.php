@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lembaga') }}">Lembaga</a></div>
        <div class="breadcrumb-item">Bank</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Bank</h2>
    <p class="section-lead">
        Kelola Bank.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Bank') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.lembaga.bank.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lembaga-bank">
                            <thead>
                                <tr>
                                    <th>Id Bank</th>
                                    <th>Kode Bank</th>
                                    <th>Nama Bank</th>
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
