@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Alamat</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list') }}">List</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.anggota.list.show', $anggota->informasi_akun_id) }}">Detail Anggota</a></div>
        <div class="breadcrumb-item">Alamat</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Alamat {{ is_null($anggota->lembaga()->first()) ? ($anggota->member()->first()->ktp()->first()->nama) : $anggota->lembaga()->first()->nama_lembaga }}</h2>
    <p class="section-lead">
        Kelola Alamat {{ is_null($anggota->lembaga()->first()) ? ($anggota->member()->first()->ktp()->first()->nama) : $anggota->lembaga()->first()->nama_lembaga }}
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Alamat ')  }} {{ is_null($anggota->lembaga()->first()) ? ($anggota->member()->first()->ktp()->first()->nama) : $anggota->lembaga()->first()->nama_lembaga }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.anggota.list.area.create', $anggota->informasi_akun_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-area-member">
                            <thead>
                                <tr>
                                    <th>Id Alamat</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>Alamat</th>
                                    <th>Kode Pos</th>
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
