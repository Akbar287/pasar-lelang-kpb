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
                    <h4>Total Kontrak</h4>
                </div>
                <div class="card-body">
                    {{ $kontrak['total_kontrak'] }}
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
                    <h4>Total Kontrak Aktif</h4>
                </div>
                <div class="card-body">
                    {{ $kontrak['total_kontrak_aktif'] }}
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
                    <h4>Total Kontrak Perlu Verifikasi</h4>
                </div>
                <div class="card-body">
                    {{ $kontrak['total_kontrak_verifikasi'] }}
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
                    <h4>Total Kontrak Tidak Aktif</h4>
                </div>
                <div class="card-body">
                    {{ $kontrak['total_kontrak_tidak_aktif'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Kontrak Berdasarkan Komoditas</h4>
            </div>
            <div class="card-body">
                <canvas id="chart_komoditas_jaminan" height="250" style="display: block; width: 461px; height: 279px;" width="461" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Kontrak Berdasarkan Jenis Perdagangan</h4>
            </div>
            <div class="card-body">
                <canvas id="chart_perdagangan_jaminan" height="250" style="display: block; width: 461px; height: 279px;" width="461" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Anggota Berdasarkan Kontrak</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No. Kontrak</th>
                            <th>Komoditas</th>
                            <th>Tanggal Berakhir</th>
                        </thead>
                        <tbody>
                            @foreach($kontrak['list_anggota'] as $la)
                            @if($la->informasi_akun()->first()->kontrak()->count() > 0)
                            @php $temp = $la->informasi_akun()->first()->kontrak()->select('kontrak.kontrak_kode')->addSelect('kontrak.tanggal_berakhir')->addSelect('komoditas.nama_komoditas')->join('komoditas', 'komoditas.komoditas_id', 'kontrak.komoditas_id')->get()->toArray(); @endphp
                            <tr>
                                <td rowspan="{{ count($temp) == 0 ? 1 : count($temp) }}">{{ $la->ktp()->first()->nik }}</td>
                                <td rowspan="{{ count($temp) == 0 ? 1 : count($temp) }}">{{ $la->ktp()->first()->nama }}</td>
                                @if(count($temp) > 0)
                                <td>{{ $temp['0']['kontrak_kode'] }}</td>
                                <td>{{ $temp['0']['nama_komoditas'] }}</td>
                                <td>{{ $temp['0']['tanggal_berakhir'] }}</td>
                                @else
                                <td colspan="3">Tidak Ada</td>
                                @endif
                            </tr>
                            @if(count($temp) > 1)
                                @for($i = 1; $i < count($temp); $i++)
                                <tr>
                                    <td>{{ $temp[$i]['kontrak_kode'] }}</td>
                                    <td>{{ $temp[$i]['nama_komoditas'] }}</td>
                                    <td>{{ $temp[$i]['tanggal_berakhir'] }}</td>
                                </tr>
                                @endfor
                            @endif
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
