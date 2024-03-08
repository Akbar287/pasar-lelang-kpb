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
                    <h4>Total Saldo Jaminan</h4>
                </div>
                <div class="card-body">
                    {{ 'Rp.' .number_format($jaminan['total_saldo_jaminan'], 2, ".", ",") }}
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
                    <h4>Total Saldo Teralokasi</h4>
                </div>
                <div class="card-body">
                    {{ 'Rp.' .number_format($jaminan['total_saldo_teralokasi'], 2, ".", ",") }}
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
                    <h4>Total Saldo Bebas</h4>
                </div>
                <div class="card-body">
                    {{ 'Rp.' .number_format($jaminan['total_saldo_bebas'], 2, ".", ",") }}
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
                    <h4>Total Saldo Rekening Pusat</h4>
                </div>
                <div class="card-body">
                    {{ 'Rp.' .number_format($jaminan['total_saldo_rekening_pusat'], 2, ".", ",") }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-12 col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Grafik Sebaran Saldo Jaminan</h4>
            </div>
            <div class="card-body">
                <canvas id="chart_summary_jaminan" height="250" style="display: block; width: 461px; height: 279px;" width="461" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Summary Sebaran</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-anggota">
                        <thead>
                            <th>Nama</th>
                            <th>Jumlah Saldo</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Saldo Teralokasi</th>
                                <td id="saldo_teralokasi"></td>
                            </tr>
                            <tr>
                                <th>Saldo Tersedia (Bebas)</th>
                                <td id="saldo_tersedia"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-sm-12 col-12">
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
                            <th>Saldo Tersedia</th>
                            <th>Saldo Teralokasi</th>
                        </thead>
                        <tbody>
                            @foreach($jaminan['member'] as $la)
                            <tr>
                                <td>{{ $la->nik }}</td>
                                <td>{{ $la->nama }}</td>
                                <td>{{ 'Rp. '. number_format($la->saldo_tersedia ?? 0, 0, ".", ",") }}</td>
                                <td>{{ 'Rp. '. number_format($la->saldo_teralokasi ?? 0, 0, ".", ",") }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-sm-12 col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Rekening Pusat</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-anggota">
                        <thead>
                            <th>Nama Bank</th>
                            <th>Cabang</th>
                            <th>No. Rekening</th>
                            <th>Mata Uang</th>
                            <th>Status</th>
                            <th>Saldo</th>
                        </thead>
                        <tbody>
                            @foreach($jaminan['rekening_pusat'] as $la)
                            <tr>
                                <td>{{ $la->nama_bank }}</td>
                                <td>{{ $la->cabang }}</td>
                                <td>{{ $la->nomor_rekening }}</td>
                                <td>{{ $la->mata_uang }}</td>
                                <td>{{ $la->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td>{{ 'Rp. '. number_format($la->saldo ?? 0, 0, ".", ",") }}</td>
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
