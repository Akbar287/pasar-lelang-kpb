@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Anggota Aktif</h4>
                </div>
                <div class="card-body">
                    {{ $anggota['anggota_aktif'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-box"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Anggota Memiliki Kontrak</h4>
                </div>
                <div class="card-body">
                    {{ $anggota['anggota_kontrak'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-danger">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Anggota Tidak Login < 60 Hari</h4>
                </div>
                <div class="card-body">
                    {{ $anggota['tidak_login'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
            <div class="card-icon shadow-primary bg-warning">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Anggota Tidak Aktif</h4>
                </div>
                <div class="card-body">
                    {{ $anggota['anggota_tidak_aktif'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2 display-all anggota-view">
    <div class="col-sm-12 col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Ringkasan Berdasarkan Status Member</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-anggota">
                        <thead>
                            <th>Nama Status</th>
                            <th>Jumlah Member</th>
                        </thead>
                        <tbody>
                            @foreach($statusMember as $ra)
                            <tr>
                                <td>{{ $ra->nama_status }}</td>
                                <td>{{ $ra->member()->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Ringkasan Berdasarkan Role</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-anggota">
                        <thead>
                            <th>Nama Role</th>
                            <th>Jumlah Member</th>
                        </thead>
                        <tbody>
                            @foreach($role as $ra)
                            <tr>
                                <td>{{ (str_replace('ROLE_', ' ', $ra->nama_role)) }}</td>
                                <td>{{ $ra->member()->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2 display-all anggota-view">
    <div class="col-sm-12 ">
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Anggota</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-anggota">
                        <thead>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No. HP</th>
                            <th>Status</th>
                            <th>Role</th>
                        </thead>
                        <tbody>
                            @foreach($member as $la)
                            <tr>
                                <td>{{ $la->ktp()->first()->nik }}</td>
                                <td>{{ $la->ktp()->first()->nama }}</td>
                                <td>{{ $la->informasi_akun()->first()->no_hp }}</td>
                                <td>{{ $la->status_member()->first()->nama_status }}</td>
                                <td>{{ $la->role()->get()->first()->nama_role ?? 'ROLE_PEMBELI' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
