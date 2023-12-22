@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Detail Event Lelang</h2>
    <p class="section-lead">
        detail data Detail Event Lelang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Status event Lelang</h4>
                    </div>
                    <div class="card-body">
                        <div class="wizard-steps">
                            @foreach($statusEvent as $se)
                            <div class="wizard-step {{ ($se->urutan <= $event->status_event_lelang()->first()->urutan) ? 'wizard-step-active' : 'wizard-step-info' }} ">
                                <div class="wizard-step-icon">
                                    <i class="{{ $se->icon }}"></i>
                                </div>
                                <div class="wizard-step-label">
                                    {{$se->nama_status}}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Detail Event Lelang') }}</h4>
                        <div class="card-header-action">
                            @if ($event->status_event_lelang()->first()->nama_status == 'Lelang Baru')
                                <div class="badge badge-primary">Lelang Baru</div>
                            @elseif($event->status_event_lelang()->first()->nama_status == 'Sinkronisasi Inisiasi Jual')
                                <div class="badge badge-info">Sinkronisasi Inisiasi Jual</div>
                            @elseif($event->status_event_lelang()->first()->nama_status == 'Sinkronisasi Anggota Lelang')
                                <div class="badge badge-warning">Sinkronisasi Anggota Lelang</div>
                            @elseif($event->status_event_lelang()->first()->nama_status == 'Lelang Berlangsung')
                                <div class="badge badge-success">Lelang Berlangsung</div>
                            @elseif($event->status_event_lelang()->first()->nama_status == 'Selesai')
                                <div class="badge badge-secondary">Selesai</div>
                            @else
                                <div class="badge badge-danger">No Status</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="offline_profile_id" class="col-md-4 col-form-label text-md-end">{{ __('Offline Profile')
                                        }}</label>

                                    <div class="col-md-6">
                                            <input id="offline_profile_id" type="text"
                                                class="form-control" name="user_id" readonly
                                                value="{{ $event->offline_profile()->first()->nama_profile }}">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="event_kode" class="col-md-4 col-form-label text-md-end">{{ __('Kode Event')
                                        }}</label>

                                    <div class="col-md-6">
                                            <input id="event_kode" type="text" readonly
                                                class="form-control" name="event_kode"
                                                value="{{ $event->event_kode }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lelang')
                                        }}</label>

                                    <div class="col-md-6">
                                            <input id="nama_lelang" type="text" readonly
                                                class="form-control" name="nama_lelang"
                                                value="{{ $event->nama_lelang }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Lelang')
                                        }}</label>

                                    <div class="col-md-6">
                                            <input id="tanggal_lelang" type="date" readonly
                                                class="form-control" name="tanggal_lelang"
                                                value="{{ $event->tanggal_lelang }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Mulai')
                                        }}</label>

                                    <div class="col-md-6">
                                            <input id="jam_mulai" type="time" readonly
                                                class="form-control" name="jam_mulai"
                                                value="{{ $event->jam_mulai }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_selesai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Selesai')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="jam_selesai" type="time" readonly
                                            class="form-control" name="jam_selesai"
                                            value="{{ $event->jam_selesai }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea id="lokasi" readonly class="form-control" name="lokasi" cols="30" rows="10">{{ $event->lokasi }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="ketua_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Ketua Lelang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="ketua_lelang" type="text" readonly
                                            class="form-control" name="ketua_lelang"
                                            value="{{ $event->ketua_lelang }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>

                                    <div class="col-md-6">
                                            <textarea id="keterangan" readonly class="form-control" name="keterangan" cols="30" rows="10">{{ $event->keterangan }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="is_open" class="col-md-4 col-form-label text-md-end">{{ __('Terbuka Untuk Penjual')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="is_open" type="text" readonly
                                            class="form-control" name="is_open"
                                            value="{{ $event->is_open ? 'Aktif' : 'Tidak Aktif' }}">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="is_online" class="col-md-4 col-form-label text-md-end">{{ __('Hybrid')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="is_online" type="text" readonly
                                            class="form-control" name="is_online"
                                            value="{{ $event->is_online ? 'Online - Offline' : 'Offline' }}">
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
                                        <a type="button" href="{{ route('offline.event.history') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('offline.event.edit_status', $event->event_lelang_id) }}" class="btn mr-2 btn-warning"><i class="fas fa-list"></i> Status</a>
                                        <a type="button" href="{{ route('offline.event.anggota.show_komoditi', $event->event_lelang_id) }}" class="btn mr-2 btn-success"><i class="fas fa-users"></i> Peserta lelang</a>
                                        <a type="button" href="{{ route('offline.event.produk', $event->event_lelang_id) }}" class="btn mr-2 btn-primary"><i class="fas fa-box"></i> Produk Lelang</a>
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
