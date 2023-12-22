@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jaminan Saham</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.saham.index', $detailJaminan->detail_jaminan_id) }}">Saham</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.saham.show', [$detailJaminan->detail_jaminan_id, $saham->saham_id]) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Jaminan Saham</h2>
    <p class="section-lead">
        Ubah data Jaminan Saham anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('administrasi.jaminan.penerimaan.saham.update', [$detailJaminan->detail_jaminan_id, $saham->saham_id]) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Jaminan Saham') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_saham" class="col-md-4 col-form-label text-md-end">{{ __('Kode Saham')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input id="kode_saham" type="text"
                                                class="form-control @error('kode_saham') is-invalid @enderror" name="kode_saham"
                                                value="{{ $saham->kode_saham }}" />

                                        </div>
                                            @error('kode_saham')
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
                                                value="{{ $saham->penerbit }}" />

                                        </div>
                                            @error('penerbit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="harga_saham" class="col-md-4 col-form-label text-md-end">{{ __('Harga Saham')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="harga_saham" type="text"
                                                class="form-control @error('harga_saham') is-invalid @enderror thousand-style" name="harga_saham"
                                                value="{{ number_format($saham->harga_saham, 0, ".", ",") }}" />
                                        </div>

                                        @error('harga_saham')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="lot" class="col-md-4 col-form-label text-md-end">{{ __('Lot')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                            </div>
                                            <input id="lot" type="text"
                                                class="form-control @error('lot') is-invalid @enderror thousand-style" name="lot"
                                                value="{{ number_format($saham->lot, 0, ".", ",") }}" />
                                        </div>

                                        @error('lot')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nilai_saham" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Saham (Nilai Jaminan)')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai_saham" type="text"
                                                class="form-control @error('nilai_saham') is-invalid @enderror thousand-style" name="nilai_saham"
                                                value="{{ number_format($saham->nilai_saham, 0, ".", ",") }}" />
                                        </div>

                                        @error('nilai_saham')
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
                                                value="{{ number_format($saham->haircut, 0, ".", ",") }}" />
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
                                                value="{{ number_format($saham->nilai_tersedia, 0, ".", ",") }}" />
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
                                        <textarea id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" type="text" cols="30" rows="10">{{ $saham->lokasi }}</textarea>
    
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.saham.show', [$detailJaminan->detail_jaminan_id, $saham->saham_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


