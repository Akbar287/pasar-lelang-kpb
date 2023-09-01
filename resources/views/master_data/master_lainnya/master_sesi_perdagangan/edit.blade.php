@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Sesi Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain') }}">Lainnya</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.sesi') }}">Sesi Lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.lain.sesi.show', $sesi->master_sesi_lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Sesi Lelang</h2>
    <p class="section-lead">
        Ubah data Sesi Lelang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.lain.sesi.update', $sesi->master_sesi_lelang_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Sesi lelang') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id" id="penyelenggara_pasar_lelang_id">
                                            @foreach($penyelenggaraPasarLelang as $ppl)
                                            <option {{ $sesi->penyelenggara_pasar_lelang()->first()->penyelenggara_pasar_lelang_id == $ppl->penyelenggara_pasar_lelang_id ? 'selected' : '' }} value="{{ $ppl->penyelenggara_pasar_lelang_id }}">{{ $ppl->admin()->first()->member()->first()->ktp()->first()->nama }}</option>
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
                                    <label for="sesi" class="col-md-4 col-form-label text-md-end">{{ __('Sesi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="sesi" type="text"
                                            class="form-control @error('sesi') is-invalid @enderror" name="sesi"
                                            value="{{ $sesi->sesi }}" autocomplete="name"
                                            autofocus>
            
                                        @error('sesi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Jam Mulai')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="jam_mulai" type="time"
                                            class="form-control @error('jam_mulai') is-invalid @enderror" name="jam_mulai"
                                            value="{{ $sesi->jam_mulai }}" autocomplete="name"
                                            autofocus>
            
                                        @error('jam_mulai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3 justify-content-center">
                                    <label for="jam_berakhir" class="col-md-4 col-form-label text-md-end">{{ __('Jam Berakhir')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="jam_berakhir" type="time"
                                            class="form-control @error('jam_berakhir') is-invalid @enderror" name="jam_berakhir"
                                            value="{{ $sesi->jam_berakhir }}" autocomplete="name"
                                            autofocus>
            
                                        @error('jam_berakhir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3 justify-content-center">
                                    <label for="is_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Aktif')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('is_aktif') is-invalid @enderror" name="is_aktif" id="is_aktif">
                                            <option {{ $sesi->is_aktif == true ? 'selected' : '' }} value="{{ 'true' }}">{{ "Aktif" }}</option>
                                            <option {{ $sesi->is_aktif == false ? 'selected' : '' }} value="{{ 'false' }}">{{ "Tidak Aktif" }}</option>
                                        </select>
            
                                        @error('is_aktif')
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
                                        <a type="button" href="{{ route('master.lain.sesi.show', $sesi->master_sesi_lelang_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


