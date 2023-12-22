@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail List Lelang Offline</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.list') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item">Detail Lelang Offline</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail List Lelang Offline</h2>
    <p class="section-lead">
        detail List Lelang Offline.
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
                        @if(!is_null(Auth::user()->informasi_akun()->first()->daftar_peserta_lelang()->where('event_lelang_id', $eventLelang->event_lelang_id)->first()))
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
                                <label for="event_kode" class="col-md-4 col-form-label text-md-end">{{ __('Kode Event') }}</label>

                                <div class="col-md-6">
                                    <input id="event_kode" type="text" readonly class="form-control" name="event_kode" value="{{ $eventLelang->event_kode }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lelang') }}</label>

                                <div class="col-md-6">
                                    <input id="nama_lelang" type="text" readonly class="form-control" name="nama_lelang" value="{{ $eventLelang->nama_lelang }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal') }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal" type="date" readonly class="form-control" name="tanggal" value="{{ $eventLelang->tanggal_lelang }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Mulai') }}</label>

                                <div class="col-md-6">
                                    <input id="jam_mulai" type="time" readonly class="form-control" name="jam_mulai" value="{{ $eventLelang->jam_mulai }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="jam_selesai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Selesai') }}</label>

                                <div class="col-md-6">
                                    <input id="jam_selesai" type="time" readonly class="form-control" name="jam_selesai" value="{{ $eventLelang->jam_selesai }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="ketua_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Ketua Lelang') }}</label>

                                <div class="col-md-6">
                                    <input id="ketua_lelang" type="text" readonly class="form-control" name="ketua_lelang" value="{{ $eventLelang->ketua_lelang }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan') }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan" readonly class="form-control" name="keterangan" cols="30" rows="10">{{ $eventLelang->keterangan }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi Lelang') }}</label>

                                <div class="col-md-6">
                                    <input id="lokasi" type="text" readonly class="form-control" name="lokasi" value="{{ $eventLelang->lokasi }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis" class="col-md-4 col-form-label text-md-end">{{ __('Jenis') }}</label>

                                <div class="col-md-6">
                                    <input id="jenis" type="text" readonly class="form-control" name="jenis" value="{{ $eventLelang->is_online ? 'Hybrid' : 'Offline' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Produk lelang') }}</h4>
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
                            Sudah Ada {{ $eventLelang->daftar_peserta_lelang()->count() }} Anggota yang ikut bergabung.
                            @if($eventLelang->daftar_peserta_lelang()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->count() > 0) <br>
                            Anda sudah bergabung ke sesi lelang ini dan Kode Anda adalah: <b> {{ $eventLelang->daftar_peserta_lelang()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->first()->kode_peserta_lelang }}</b>
                            @endif
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
                                        <a type="button" href="{{ route('offline.list') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <form action="{{ route('offline.list.join', $eventLelang->event_lelang_id) }}" method="POST">@csrf
                                            @if($eventLelang->daftar_peserta_lelang()->where('informasi_akun_id', Auth::user()->informasi_akun_id)->count() == 0)
                                            <button type="submit" onclick="return confirm('Anda Akan Gabung ke sesi lelang ini!\n Lanjutkan?')" title="Gabung Sesi lelang" class="btn btn-success"><i class="fas fa-users"></i> Gabung</button>
                                            @endif
                                        </form>
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
