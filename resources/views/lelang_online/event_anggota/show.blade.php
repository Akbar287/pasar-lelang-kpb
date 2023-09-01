@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Anggota Event</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online') }}">Lelang Online</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event.show', $event->lelang_sesi_online_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event.anggota', $event->lelang_sesi_online_id) }}">Anggota Event Lelang</a></div>
        <div class="breadcrumb-item">Detail Anggota</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Anggota Event</h2>
    <p class="section-lead">
        detail data Detail Anggota Event anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail Anggota Event') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="informasi_akun_id" type="text" readonly
                                        class="form-control" name="informasi_akun_id"
                                        value="{{ $anggota->informasi_akun()->first()->member()->first()->ktp()->first()->nama . ' ('. $anggota->informasi_akun()->first()->member()->first()->ktp()->first()->nik .')' }}">
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kode_peserta_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Kode Event')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="kode_peserta_lelang" type="text" readonly
                                            class="form-control" name="kode_peserta_lelang"
                                            value="{{ $anggota->kode_peserta_lelang }}">
                                </div>
                            </div>
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
                                        <a type="button" href="{{ route('online.event.anggota', $event->lelang_sesi_online_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('online.event.anggota.edit', [$event->lelang_sesi_online_id, $anggota->peserta_lelang_id]) }}" class="btn mr-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('online.event.anggota.destroy', [$event->lelang_sesi_online_id, $anggota->peserta_lelang_id]) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Anggota Lelang akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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
