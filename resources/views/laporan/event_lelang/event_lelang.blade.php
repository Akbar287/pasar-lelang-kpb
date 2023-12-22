@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Laporan Event Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('laporan') }}">Laporan</a></div>
        <div class="breadcrumb-item">Laporan Event Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Laporan Event Lelang</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Laporan Event Lelang ') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.event_lelang') }}" method="post"> @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center choose-perorangan">
                                    <label for="event_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Event Lelang Offline')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('event_lelang_id') is-invalid @enderror" name="event_lelang_id" id="event_lelang_id">
                                        </select>
                                        
                                        @error('event_lelang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <div class="col-12 text-center">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-download"></i> Unduh</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
