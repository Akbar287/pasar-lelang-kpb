@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Event Lelang Online</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online') }}">Lelang Online</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online.event', $event->lelang_sesi_online_id) }}">Event</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Event Lelang Online</h2>
    <p class="section-lead">
        Detail Event Lelang Online anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Detail Event Lelang Online') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="penyelenggara" type="text"
                                                class="form-control" name="user_id" readonly
                                                value="{{ $event->master_sesi_lelang()->first()->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="sesi" class="col-md-4 col-form-label text-md-end">{{ __('Sesi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="sesi" type="text" readonly
                                                class="form-control" name="sesi"
                                                value="{{ $event->master_sesi_lelang()->first()->sesi }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="tanggal" type="date" readonly
                                                class="form-control" name="tanggal"
                                                value="{{ $event->tanggal }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Mulai')
                                        }}</label>
            
                                    <div class="col-md-6">
                                            <input id="jam_mulai" type="time" readonly
                                                class="form-control" name="jam_mulai"
                                                value="{{ $event->master_sesi_lelang()->first()->jam_mulai }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_berakhir" class="col-md-4 col-form-label text-md-end">{{ __('Jam Selesai')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="jam_berakhir" type="time" readonly
                                            class="form-control" name="jam_berakhir"
                                            value="{{ $event->master_sesi_lelang()->first()->jam_berakhir }}">
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
                                    <div class="col-md-8 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('online.event') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('online.event.produk', $event->lelang_sesi_online_id) }}" class="btn mr-2 btn-info"><i class="fas fa-box"></i> Produk Lelang</a>
                                        <a type="button" href="{{ route('online.event.anggota', $event->lelang_sesi_online_id) }}" class="btn mr-2 btn-success"><i class="fas fa-users"></i> Anggota Lelang</a>
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
