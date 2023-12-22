@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi') }}">Transaksi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list') }}">Lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list.show', $lelang->lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list.file', $lelang->lelang_id) }}">File</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Lelang</h2>
    <p class="section-lead">
        Detail data gudang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail Lelang') }}</h4>
                    <div class="card-header-action">
                        <div class="badge badge-primary">
                            Status: {{ $lelang->status_lelang_pivot()->where('is_aktif', true)->first()->status_lelang()->first()->nama_status }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_dokumen_produk_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Dokumen Produk')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jenis_dokumen_produk_id" type="text" readonly
                                        class="form-control" name="jenis_dokumen_produk_id"
                                        value="{{ $file->jenis_dokumen_produk()->first()->nama_jenis }}">
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="gambar" class="col-md-4 col-form-label text-md-end">{{
                                    __('File')
                                    }}</label>

                                <div class="col-md-6">
                                    <img src="{{ asset('storage/produk/' . $file->nama_file) }}" alt="{{ $file->nama_dokumen }}" class="img img-thumbnail img-temporary " style="width: 800px; height: auto">
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_upload" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Upload')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="tanggal_upload" type="text" readonly
                                        class="form-control" name="tanggal_upload"
                                        value="{{ $file->tanggal_upload }}">
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="is_gambar_utama" class="col-md-4 col-form-label text-md-end">{{ __('Gambar Utama')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="is_gambar_utama" type="text" readonly
                                        class="form-control" name="tanggal_upload"
                                        value="{{ $file->is_gambar_utama ? 'Ya' : 'Tidak' }}">

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
                                    <textarea readonly class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" cols="30" rows="10">{{ $file->keterangan }}</textarea>

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
                                    <a type="button" href="{{ route('transaksi.lelang_list.file.edit', [$lelang->lelang_id, $file->dokumen_produk_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('transaksi.lelang_list.file.destroy', [$lelang->lelang_id, $file->dokumen_produk_id]) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('File Lelang akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

