@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail List Lelang Online</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.list') }}">Lelang Online</a></div>
        <div class="breadcrumb-item">Detail Lelang Online</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail List Lelang Online</h2>
    <p class="section-lead">
        detail List Lelang Online.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail List Lelang') }}</h4>
                    <div class="card-header-action">
                        @if(!is_null(Auth::user()->informasi_akun()->first()->peserta_lelang()->where('master_sesi_lelang_id', $masterSesiLelang->master_sesi_lelang_id)->where('tanggal', $lelangSesiOnline->tanggal)->first()))
                        <div class="badge badge-success">Tergabung</div>
                        @else
                        <div class="badge badge-primary">Belum gabung</div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="master_sesi_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Master Sesi Lelang Id')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="master_sesi_lelang_id" type="text" readonly
                                        class="form-control" name="master_sesi_lelang_id"
                                        value="{{ $masterSesiLelang->master_sesi_lelang_id }}">
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal') }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal" type="text" readonly class="form-control" name="tanggal" value="{{ $lelangSesiOnline->tanggal }}">
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="sesi" class="col-md-4 col-form-label text-md-end">{{ __('Sesi') }}</label>

                                <div class="col-md-6">
                                    <input id="sesi" type="text" readonly class="form-control" name="sesi" value="{{ $masterSesiLelang->sesi }}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Produk Sesi Lelang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-sesi-lelang">
                                    <thead>
                                        <tr>
                                            <th>Penjual</th>
                                            <th>Gambar</th>
                                            <th>Nama Produk</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Awal</th>
                                            <th>Kelipatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Anggota Sesi Lelang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Terdapat {{ $masterSesiLelang->peserta_lelang()->where('tanggal', $lelangSesiOnline->tanggal)->count() }} Anggota yang mengikuti Sesi Lelang ini</p>
                            <p>Kode Anggota anda adalah: <b>{{ is_null(Auth::user()->informasi_akun()->first()->peserta_lelang()->where('master_sesi_lelang_id', $masterSesiLelang->master_sesi_lelang_id)->where('tanggal', $lelangSesiOnline->tanggal)->first()) ? 'Anda Belum Terdaftar' : Auth::user()->informasi_akun()->first()->peserta_lelang()->where('master_sesi_lelang_id', $masterSesiLelang->master_sesi_lelang_id)->where('tanggal', $lelangSesiOnline->tanggal)->first()->kode_peserta_lelang }}</b></p>
                        </div>
                    </div>
                </div>
            </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('online.list') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if(is_null(Auth::user()->informasi_akun()->first()->peserta_lelang()->where('master_sesi_lelang_id', $masterSesiLelang->master_sesi_lelang_id)->where('tanggal', $lelangSesiOnline->tanggal)->first()))
                                        <form action="{{ route('online.list.join', [$masterSesiLelang->master_sesi_lelang_id, $lelangSesiOnline->lelang_sesi_online_id]) }}" method="POST">@csrf
                                            <button type="submit" onclick="return confirm('Anda Akan Gabung ke sesi lelang ini!\n Lanjutkan?')" title="Gabung Sesi lelang" class="btn btn-success"><i class="fas fa-users"></i> Gabung</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
