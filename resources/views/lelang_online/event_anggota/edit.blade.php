@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Ubah Anggota Event</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online') }}">Lelang Online</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event.show', $event->lelang_sesi_online_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event.anggota', $event->lelang_sesi_online_id) }}">Anggota Event Lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event.anggota.show', [$event->lelang_sesi_online_id, $anggota->peserta_lelang_id]) }}">Detail Anggota</a></div>
        <div class="breadcrumb-item">Ubah Anggota</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Anggota Event</h2>
    <p class="section-lead">
        Ubah Anggota Event anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('online.event.anggota.update', [$event->lelang_sesi_online_id, $anggota->peserta_lelang_id]) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Anggota Event') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                        }}</label>

                                    <div class="col-md-6">
                                            <select id="informasi_akun_id" {{ $members->count() > 0 ? '' : 'disabled' }} class="custom-select @error('informasi_akun_id') is-invalid @enderror" name="informasi_akun_id">
                                                @foreach($members as $op)
                                                <option {{ $anggota->informasi_akun_id == $op->informasi_akun()->first()->informasi_akun_id ? 'selected' : '' }} value="{{ $op->informasi_akun()->first()->informasi_akun_id }}">{{ $op->ktp()->first()->nama . ' ('. $op->ktp()->first()->nik .')' }}</option>
                                                @endforeach
                                            </select>
                                        
                                        @error('informasi_akun_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_peserta_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Kode Event')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="kode_peserta_lelang" type="text"
                                                class="form-control @error('kode_peserta_lelang') is-invalid @enderror" name="kode_peserta_lelang"
                                                value="{{ $anggota->kode_peserta_lelang }}">
                                        
                                        @error('kode_peserta_lelang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                        <a type="button" href="{{ route('online.event.anggota.show', [$event->lelang_sesi_online_id, $anggota->peserta_lelang_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
