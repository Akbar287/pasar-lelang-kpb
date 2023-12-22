@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Status Member</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi') }}">Konfigurasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('konfigurasi.status') }}">Status</a></div>
        <div class="breadcrumb-item">Status Member</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Status Member</h2>
    <p class="section-lead">
        Kelola Status Member.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Status Member') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('konfigurasi.status.member.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-status-member">
                            <thead>
                                <tr>
                                    <th>Id Status Member</th>
                                    <th>Nama Status Member</th>
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
