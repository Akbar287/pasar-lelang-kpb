@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan Komoditas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.komoditas.index', $detailJaminan->detail_jaminan_id) }}">Komoditas</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Penerimaan Jaminan Komoditas</h2>
    <p class="section-lead">
        Tambahkan data Penerimaan Jaminan Komoditas.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('administrasi.jaminan.penerimaan.komoditas.store', $detailJaminan->detail_jaminan_id) }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Penerimaan Jaminan Komoditas') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="komoditi" class="col-md-4 col-form-label text-md-end">{{ __('Komoditi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="komoditi" type="text"
                                                class="form-control @error('komoditi') is-invalid @enderror" name="komoditi"
                                                value="{{ old("komoditi") }}" autocomplete="name"
                                                autofocus>

                                        </div>
                                            @error('komoditi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Kadaluarsa')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="kadaluarsa" type="date"
                                                class="form-control @error('kadaluarsa') is-invalid @enderror" name="kadaluarsa"
                                                value="{{ is_null(old("kadaluarsa")) ? date('Y-m-d') : old("kadaluarsa") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                            @error('kadaluarsa')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kuantitas" class="col-md-4 col-form-label text-md-end">{{ __('Kuantitas')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="kuantitas" type="text"
                                                class="form-control thousand-style @error('kuantitas') is-invalid @enderror" name="kuantitas"
                                                value="{{ old("kuantitas") }}" autocomplete="name"
                                                autofocus>

                                        </div>
                                            @error('kuantitas')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="unit" class="col-md-4 col-form-label text-md-end">{{ __('Unit')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="unit" type="text"
                                                class="form-control @error('unit') is-invalid @enderror" name="unit"
                                                value="{{ old("unit") }}" autocomplete="name"
                                                autofocus>

                                        </div>
                                            @error('unit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nilai_perkiraan" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Perkiraan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai_perkiraan" type="text"
                                                class="form-control @error('nilai_perkiraan') is-invalid @enderror thousand-style" name="nilai_perkiraan"
                                                value="{{ old("nilai_perkiraan") }}" autocomplete="name"
                                                autofocus>
                                        </div>

                                        @error('nilai_perkiraan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="haircut" class="col-md-4 col-form-label text-md-end">{{ __('Haircut')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="haircut" type="text"
                                                class="form-control @error('haircut') is-invalid @enderror thousand-style" name="haircut"
                                                value="{{ old("haircut") }}" autocomplete="name"
                                                autofocus>
                                        </div>

                                        @error('haircut')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nilai_penyesuaian" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Penyesuaian')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai_penyesuaian" type="text"
                                                class="form-control @error('nilai_penyesuaian') is-invalid @enderror thousand-style" name="nilai_penyesuaian"
                                                value="{{ old("nilai_penyesuaian") }}" autocomplete="name"
                                                autofocus>
                                        </div>

                                        @error('nilai_penyesuaian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <textarea id="lokasi" class="form-control @error('lokasi') is-invalid @enderror"  name="lokasi" type="text" cols="30" rows="10">{{ old('lokasi') }}</textarea>

                                        @error('lokasi')
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.komoditas.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
