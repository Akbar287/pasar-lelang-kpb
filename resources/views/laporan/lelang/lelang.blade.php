@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Laporan Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('laporan') }}">Laporan</a></div>
        <div class="breadcrumb-item">Laporan Lelang</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Laporan Lelang</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('List Laporan Lelang ') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.lelang') }}" method="post"> @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar lelang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id" id="penyelenggara_pasar_lelang_id">
                                            @foreach($ppl as $p)
                                            <option value="{{ $p->penyelenggara_pasar_lelang_id }}">{{ $p->admin()->first()->member()->first()->ktp()->first()->nama }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('penyelenggara_pasar_lelang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input type="date" value="{{ is_null(old('tanggal')) ? date('Y-m-d') : old('tanggal') }}" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" />
                                        
                                        @error('tanggal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="sesi" class="col-md-4 col-form-label text-md-end">{{ __('Sesi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('sesi') is-invalid @enderror" name="sesi" id="sesi">
                                            <option value="semua">Semua</option>
                                            <option value="Satu">Satu</option>
                                            <option value="Dua">Dua</option>
                                            <option value="Tiga">Tiga</option>
                                        </select>
                                        
                                        @error('sesi')
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
