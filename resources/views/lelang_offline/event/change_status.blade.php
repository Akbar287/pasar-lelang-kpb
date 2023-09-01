@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Ubah Status Event</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline') }}">Lelang Offline</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event') }}">Event</a></div>
        <div class="breadcrumb-item"><a href="{{ route('offline.event.show', $event->event_lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah Status</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Status Event</h2>
    <p class="section-lead">
        Ubah Status Event anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Informasi Status Event') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="activities">
                                    @foreach($status as $s)
                                    <div class="activity">
                                        <div class="activity-icon {{ $event->status_event_lelang()->first()->urutan == $s->urutan ? 'bg-success' : 'bg-primary' }} text-white shadow-primary">
                                            <i class="fas {{ $s->icon }}"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span class="text-job">{{ $s->nama_status }}</span>
                                            </div>
                                            <p>{{ $s->keterangan }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <form action="{{ route('offline.event.update_status', $event->event_lelang_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="status_event_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Status Event Lelang')
                                        }}</label>
                    
                                    <div class="col-md-6">
                                        <select id="status_event_lelang_id" {{ $status->count() > 0 ? '' : 'disabled' }} class="custom-select @error('status_event_lelang_id') is-invalid @enderror" name="status_event_lelang_id">
                                            @foreach($status as $op)
                                            <option {{ $event->status_event_lelang()->first()->status_event_lelang_id == $op->status_event_lelang_id ? 'selected' : '' }} value="{{ $op->status_event_lelang_id }}">{{ $op->nama_status }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('status_event_lelang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                    <a type="button" href="{{ route('offline.event.show', $event->event_lelang_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    
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
@endsection
