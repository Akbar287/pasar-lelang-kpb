@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Jaminan Resi Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.index', $detailJaminan->detail_jaminan_id) }}">Resi Gudang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.show', [$detailJaminan->detail_jaminan_id, $resiGudang->resi_gudang_id]) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Jaminan Resi Gudang</h2>
    <p class="section-lead">
        Ubah data Jaminan Resi Gudang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('administrasi.jaminan.penerimaan.resi_gudang.update', [$detailJaminan->detail_jaminan_id, $resiGudang->resi_gudang_id]) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Jaminan Resi Gudang') }}</h4>
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
                                                <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                            </div>
                                            <input id="jenis" type="text"
                                                class="form-control @error('jenis') is-invalid @enderror" name="jenis"
                                                value="{{ $resiGudang->jenis }}" />

                                        </div>
                                            @error('jenis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="pemilik_barang" class="col-md-4 col-form-label text-md-end">{{ __('Pemilik Barang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>

                                            <input id="pemilik_barang" type="text"
                                                class="form-control @error('pemilik_barang') is-invalid @enderror" name="pemilik_barang"
                                                value="{{ $resiGudang->pemilik_barang }}" />

                                        </div>
                                            @error('pemilik_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="pemegang_resi_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Pemegang Resi Gudang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>

                                            <input id="pemegang_resi_gudang" type="text"
                                                class="form-control @error('pemegang_resi_gudang') is-invalid @enderror" name="pemegang_resi_gudang"
                                                value="{{ $resiGudang->pemegang_resi_gudang }}" />

                                        </div>
                                            @error('pemegang_resi_gudang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="no_penerbitan" class="col-md-4 col-form-label text-md-end">{{ __('No. Penerbitan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>

                                            <input id="no_penerbitan" type="text"
                                                class="form-control @error('no_penerbitan') is-invalid @enderror" name="no_penerbitan"
                                                value="{{ $resiGudang->no_penerbitan }}" />

                                        </div>
                                            @error('no_penerbitan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_resi_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Resi Gudang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>

                                            <input id="nama_resi_gudang" type="text"
                                                class="form-control @error('nama_resi_gudang') is-invalid @enderror" name="nama_resi_gudang"
                                                value="{{ $resiGudang->nama_resi_gudang }}" />

                                        </div>
                                            @error('nama_resi_gudang')
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
                                                value="{{ $resiGudang->tanggal_penerbitan }}" />

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
                                                value="{{ $resiGudang->tanggal_jatuh_tempo }}" />

                                        </div>
                                            @error('tanggal_jatuh_tempo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nilai_resi_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Resi Gudang (Nilai Jaminan)')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai_resi_gudang" type="text"
                                                class="form-control @error('nilai_resi_gudang') is-invalid @enderror thousand-style" name="nilai_resi_gudang"
                                                value="{{ $resiGudang->nilai_resi_gudang }}" />
                                        </div>

                                        @error('nilai_resi_gudang')
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
                                                value="{{ $resiGudang->haircut }}" />
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
                                                value="{{ $resiGudang->nilai_tersedia }}" />
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.show', [$detailJaminan->detail_jaminan_id, $resiGudang->resi_gudang_id]) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


