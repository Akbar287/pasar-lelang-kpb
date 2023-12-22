@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jaminan Obligasi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.obligasi.index', $detailJaminan->detail_jaminan_id) }}">Obligasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.obligasi.show', [$detailJaminan->detail_jaminan_id, $obligasi->obligasi_id]) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Jaminan Obligasi</h2>
    <p class="section-lead">
        Ubah data Jaminan Obligasi anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('administrasi.jaminan.penerimaan.obligasi.update', [$detailJaminan->detail_jaminan_id, $obligasi->obligasi_id]) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Jaminan Obligasi') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis" class="col-md-4 col-form-label text-md-end">{{ __('Jenis')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input id="jenis" type="text"
                                                class="form-control @error('jenis') is-invalid @enderror" name="jenis"
                                                value="{{ $obligasi->jenis }}" />
                                        </div>
                                            @error('jenis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="penerbit" class="col-md-4 col-form-label text-md-end">{{ __('Penerbit')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>

                                            <input id="penerbit" type="text"
                                                class="form-control @error('penerbit') is-invalid @enderror" name="penerbit"
                                                value="{{ $obligasi->penerbit }}" />
                                        </div>
                                            @error('penerbit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kupon" class="col-md-4 col-form-label text-md-end">{{ __('kupon')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            </div>

                                            <input id="kupon" type="text"
                                                class="form-control @error('kupon') is-invalid @enderror" name="kupon"
                                                value="{{ $obligasi->kupon }}" />

                                        </div>
                                            @error('kupon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tipe_kupon" class="col-md-4 col-form-label text-md-end">{{ __('Tipe Kupon')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                            </div>

                                            <input id="tipe_kupon" type="text"
                                                class="form-control @error('tipe_kupon') is-invalid @enderror" name="tipe_kupon"
                                                value="{{ $obligasi->tipe_kupon }}" />

                                        </div>
                                            @error('tipe_kupon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_penerbitan" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Terbit')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input id="tanggal_penerbitan" type="date"
                                                class="form-control @error('tanggal_penerbitan') is-invalid @enderror" name="tanggal_penerbitan"
                                                value="{{ $obligasi->tanggal_penerbitan }}" />

                                        </div>
                                            @error('tanggal_penerbitan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_jatuh_tempo" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Jatuh Tempo')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input id="tanggal_jatuh_tempo" type="date"
                                                class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" name="tanggal_jatuh_tempo"
                                                value="{{ $obligasi->tanggal_jatuh_tempo }}" />

                                        </div>
                                            @error('tanggal_jatuh_tempo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nilai_nominal" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Nominal (Nilai Jaminan)')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai_nominal" type="text"
                                                class="form-control @error('nilai_nominal') is-invalid @enderror thousand-style" name="nilai_nominal"
                                                value="{{ $obligasi->nilai_nominal }}" />
                                        </div>

                                        @error('nilai_nominal')
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
                                                value="{{ $obligasi->haircut }}" />
                                        </div>

                                        @error('haircut')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nilai_tersedia" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Tersedia (Nilai Penyesuaian)')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai_tersedia" type="text"
                                                class="form-control @error('nilai_tersedia') is-invalid @enderror thousand-style" name="nilai_tersedia"
                                                value="{{ $obligasi->nilai_tersedia }}" />
                                        </div>

                                        @error('nilai_tersedia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('lokasi')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <textarea id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" type="text" cols="30" rows="10">{{ $obligasi->lokasi }}</textarea>
    
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.obligasi.show', [$detailJaminan->detail_jaminan_id, $obligasi->obligasi_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


