@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Area</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item">Area</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Area Member</h2>
    <p class="section-lead">
        Kelola Area.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Area') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('home.profil.area.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-area-profile">
                            <thead>
                                <tr>
                                    <th>Id Area Member</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>Alamat</th>
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
