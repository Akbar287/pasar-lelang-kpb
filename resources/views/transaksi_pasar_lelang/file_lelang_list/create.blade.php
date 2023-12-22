@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi') }}">Transaksi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list') }}">Lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list.show', $lelang->lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list.file', $lelang->lelang_id) }}">File</a></div>
        <div class="breadcrumb-item">Tambah File</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah File Lelang</h2>
    <p class="section-lead">
        Tambahkan File Lelang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('transaksi.lelang_list.file.store', $lelang->lelang_id) }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Tambah Lelang') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_dokumen_produk_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Dokumen Produk')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_dokumen_produk_id') is-invalid @enderror" name="jenis_dokumen_produk_id" id="jenis_dokumen_produk_id">
                                            @if(count($jenisDokumen) > 0)
                                            @foreach($jenisDokumen as $jd)
                                            <option {{ old('jenis_dokumen_produk_id') == $jd->jenis_dokumen_produk_id ? 'selected' : '' }} value="{{ $jd->jenis_dokumen_produk_id }}">{{ $jd->nama_jenis }}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                        @error('jenis_dokumen_produk_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="gambar" class="col-md-4 col-form-label text-md-end">{{
                                        __('File')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" name="gambar" class="custom-file-input" id="gambar">
                                            <label class="custom-file-label" for="gambar">Pilih File</label>
                                        </div>

                                        @error('gambar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <img src="" alt="{{ old("gambar") }}" class="img img-thumbnail img-temporary d-none" style="width: 800px; height: auto">
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="is_gambar_utama" class="col-md-4 col-form-label text-md-end">{{ __('Gambar Utama')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('is_gambar_utama') is-invalid @enderror" name="is_gambar_utama" id="is_gambar_utama">
                                            <option {{ old('is_gambar_utama') == 'true' ? 'selected' : '' }} value="{{ 'true' }}">Ya</option>
                                            <option {{ old('is_gambar_utama') == 'false' ? 'selected' : '' }} value="{{ 'false' }}">Tidak</option>
                                        </select>

                                        @error('is_gambar_utama')
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
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" cols="30" rows="10">{{ old("keterangan") }}</textarea>

                                        @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('transaksi.lelang_list.file', $lelang->lelang_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
