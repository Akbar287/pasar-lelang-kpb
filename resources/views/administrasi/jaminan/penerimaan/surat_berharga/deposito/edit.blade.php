@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jaminan Kas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.deposito.index', $detailJaminan->detail_jaminan_id) }}">Kas</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.deposito.show', [$detailJaminan->detail_jaminan_id, $deposito->deposito_id]) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Jaminan Kas</h2>
    <p class="section-lead">
        Ubah data Jaminan Kas anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('administrasi.jaminan.penerimaan.deposito.update', [$detailJaminan->detail_jaminan_id, $deposito->deposito_id]) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Jaminan Kas') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_sertifikat" class="col-md-4 col-form-label text-md-end">{{ __('No. Sertifikat')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input id="no_sertifikat" type="text"
                                                class="form-control @error('no_sertifikat') is-invalid @enderror" name="no_sertifikat"
                                                value="{{ $deposito->no_sertifikat }}" />

                                        </div>
                                            @error('no_sertifikat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_rekening" class="col-md-4 col-form-label text-md-end">{{ __('No. Rekening')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                            </div>

                                            <input id="no_rekening" type="text"
                                                class="form-control @error('no_rekening') is-invalid @enderror" name="no_rekening"
                                                value="{{ $deposito->no_rekening }}" />

                                        </div>
                                            @error('no_rekening')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_terbit" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Terbit')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input id="tanggal_terbit" type="date"
                                                class="form-control @error('tanggal_terbit') is-invalid @enderror" name="tanggal_terbit"
                                                value="{{ $deposito->tanggal_terbit }}" />

                                        </div>
                                            @error('tanggal_terbit')
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
                                                value="{{ $deposito->tanggal_jatuh_tempo }}" />

                                        </div>
                                            @error('tanggal_jatuh_tempo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_valuta" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Valuta')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>

                                            <input id="tanggal_valuta" type="date"
                                                class="form-control @error('tanggal_valuta') is-invalid @enderror" name="tanggal_valuta"
                                                value="{{ $deposito->tanggal_valuta }}" />

                                        </div>
                                            @error('tanggal_valuta')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="bank_penerbit" class="col-md-4 col-form-label text-md-end">{{ __('Bank Penerbit')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>

                                            <input id="bank_penerbit" type="text"
                                                class="form-control @error('bank_penerbit') is-invalid @enderror" name="bank_penerbit"
                                                value="{{ $deposito->bank_penerbit }}" />

                                        </div>
                                            @error('bank_penerbit')
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
                                                value="{{ $deposito->nilai_nominal }}" />
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
                                                value="{{ $deposito->haircut }}" />
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
                                                value="{{ $deposito->nilai_tersedia }}" />
                                        </div>

                                        @error('nilai_tersedia')
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.deposito.show', [$detailJaminan->detail_jaminan_id, $deposito->deposito_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


