@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan Kas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.kas.index', $detailJaminan->detail_jaminan_id) }}">Kas</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Penerimaan Jaminan Kas</h2>
    <p class="section-lead">
        Tambahkan data Penerimaan Jaminan Kas.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-warning" style="color: black;font-weight: bold;">Nilai tidak boleh melebihi saldo.</div>
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('administrasi.jaminan.penerimaan.kas.store', $detailJaminan->detail_jaminan_id) }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Penerimaan Jaminan Kas') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="saldo_rekening" class="col-md-4 col-form-label text-md-end">{{ __('Saldo')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="saldo_rekening" type="text" readonly
                                                class="form-control thousand-style" name="saldo_rekening"
                                                value="{{ $saldo_available }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kurs_mata_uang_id" class="col-md-4 col-form-label text-md-end">{{ __('Kurs Mata Uang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('kurs_mata_uang_id') is-invalid @enderror" @if(count($kurs) == 0) disabled @endif  name="kurs_mata_uang_id" id="kurs_mata_uang_id">
                                            @foreach ($kurs as $jt)
                                            <option value="{{ $jt->kurs_mata_uang_id }}">{{ $jt->kode_mata_uang_asal . ' - '. $jt->kode_mata_uang_tujuan }}</option>
                                            @endforeach
                                        </select>

                                        @error('kurs_mata_uang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_mata_uang" class="col-md-4 col-form-label text-md-end">{{ __('Kode Mata Uang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="kode_mata_uang" type="text"
                                                class="form-control @error('kode_mata_uang') is-invalid @enderror" name="kode_mata_uang"
                                                value="{{ is_null(old("kode_mata_uang")) ? 'IDR' : old("kode_mata_uang") }}" autocomplete="name"
                                                autofocus>

                                        </div>
                                            @error('kode_mata_uang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nilai" class="col-md-4 col-form-label text-md-end">{{ __('Nilai')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai" type="text"
                                                class="form-control @error('nilai') is-invalid @enderror thousand-style" name="nilai"
                                                value="{{ old("nilai") }}" autocomplete="name"
                                                autofocus>
                                        </div>

                                        @error('nilai')
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
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"  name="keterangan" type="text" cols="30" rows="10">{{ old('keterangan') }}</textarea>

                                        @error('keterangan')
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.kas.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
