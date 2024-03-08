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
                    <h4>Total Event Lelang</h4>
                </div>
                <div class="card-body">
                    {{ $event['total_event_lelang'] }}
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
                    <h4>Total Event Lelang Online</h4>
                </div>
                <div class="card-body">
                    {{ $event['total_event_lelang_hybrid'] }}
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
                    <h4>Total Event Lelang Offline</h4>
                </div>
                <div class="card-body">
                    {{ $event['total_event_lelang_offline'] }}
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
                    <h4>Total Event Lelang Bulan Ini</h4>
                </div>
                <div class="card-body">
                    {{ $event['total_event_bulan'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-12 col-md-12">
        <select class="custom-select @error('event_lelang_id') is-invalid @enderror" name="event_lelang_id" id="event_lelang_id">
        </select>
    </div>
</div>

<div class="row mb-2 display-all event_lelang-view">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Deskripsi Event Lelang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-border">
                        <tbody>
                            <tr>
                                <th>Event Kode</th>
                                <td id="event_kode"></td>
                                <th>Jam Mulai</th>
                                <td id="jam_mulai"></td>
                            </tr>
                            <tr>
                                <th>Nama Lelang</th>
                                <td id="nama_lelang"></td>
                                <th>Jam Selesai</th>
                                <td id="jam_selesai"></td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td id="tanggal"></td>
                                <th>Total Peserta</th>
                                <td id="total_peserta"></td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td id="lokasi"></td>
                                <th>Total Produk Lelang</th>
                                <td id="total_produk"></td>
                            </tr>
                            <tr>
                                <th>Ketua Lelang</th>
                                <td id="ketua_lelang"></td>
                                <th>Status</th>
                                <td id="status"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2 display-all event_lelang-view">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h4>Peserta Event Lelang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-hover table table-border">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody id="peserta_event"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2 display-all event_lelang-view">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h4>Penjual Event Lelang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Penjual</th>
                                <th>Komoditas</th>
                            </tr>
                        </thead>
                        <tbody id="penjual_event"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2 display-all event_lelang-view">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Daftar Produk Lelang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-produk">
                        <thead>
                            <th>Nomor Lelang</th>
                            <th>Komoditas</th>
                            <th>Judul</th>
                            <th>Harga Awal</th>
                            <th>Kelipatan</th>
                            <th>Harga Pemenang</th>
                            <th>Status</th>
                        </thead>
                        <tbody id="produk_lelang">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2 display-all event_lelang-view">
    <div class="col-sm-12 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Total Terjual</h4>
            </div>
            <div class="card-body">
                <h4 id="total_penjualan_lelang"></h4>
            </div>
        </div>
    </div>
</div>
@endsection
