@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi') }}">Transaksi Pasar lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list') }}">Verifikasi Lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_list.show', $lelang->lelang_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Lelang</h2>
    <p class="section-lead">
        Ubah data Lelang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('transaksi.lelang_list.update', $lelang->lelang_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Lelang') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_perdagangan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Perdagangan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_perdagangan_id') is-invalid @enderror" name="jenis_perdagangan_id" id="jenis_perdagangan_id">
                                            @foreach($jenisPerdagangan as $ppl)
                                            <option {{ $lelang->jenis_perdagangan()->first()->jenis_perdagangan_id == $ppl->jenis_perdagangan_id ? 'selected' : '' }} value="{{ $ppl->jenis_perdagangan_id }}">{{ $ppl->nama_perdagangan }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('jenis_perdagangan_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_inisiasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Inisiasi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_inisiasi_id') is-invalid @enderror" name="jenis_inisiasi_id" id="jenis_inisiasi_id">
                                            @foreach($jenisInisiasi as $ppl)
                                            <option {{ $lelang->jenis_inisiasi()->first()->jenis_inisiasi_id == $ppl->jenis_inisiasi_id ? 'selected' : '' }} value="{{ $ppl->jenis_inisiasi_id }}">{{ $ppl->nama_inisiasi }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('jenis_inisiasi_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="informasi_akun_id" type="text" readonly
                                            class="form-control @error('informasi_akun_id') is-invalid @enderror" name="informasi_akun_id"
                                            value="{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" autocomplete="name"
                                            autofocus>

                                        @error('informasi_akun_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center kontrak">
                                    <label for="kontrak_id" class="col-md-4 col-form-label text-md-end">{{ __('Kontrak')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('kontrak_id') is-invalid @enderror" name="kontrak_id" id="kontrak_id">
                                            @if($kontrak->count() > 0)
                                            @foreach($kontrak as $k)
                                            <option data-satuan_ukur="{{ $k->komoditas()->first()->satuan_ukuran }}" {{ $lelang->kontrak()->first()->kontrak_id == $k->kontrak_id ? 'selected' : '' }} value="{{ $k->kontrak_id }}">{{ $k->kontrak_kode }}</option>
                                            @endforeach
                                            @else 
                                            <option value="">Tidak ada Kontrak</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <div class="col-md-10">
                                        <div class="table-responsive table-rincian-kontrak">
                                            <table class="table table-bordered table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Kode Komoditas</td>
                                                        <td colspan="3" id="kode_komoditas">{{ $lelang->kontrak()->first()->kontrak_kode }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><p>Komoditas</p></td>
                                                        <td><p id="isi_komoditas">{{ $lelang->kontrak()->first()->komoditas()->first()->nama_komoditas }}</p></td>
                                                        <td><p>Min. Transaksi</p></td>
                                                        <td><p id="isi_satuan_transaksi">{{ $lelang->kontrak()->first()->minimum_transaksi }}</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td><p>Jenis Perdagangan</p></td>
                                                        <td><p id="isi_jenis_perdagangan">{{ $lelang->kontrak()->first()->jenis_perdagangan()->first()->nama_perdagangan }}</p></td>
                                                        <td><p>Maks. Transaksi</p></td>
                                                        <td><p id="isi_max_transaksi">{{ $lelang->kontrak()->first()->maksimum_transaksi }}</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td><p>Mutu</p></td>
                                                        <td><p id="isi_mutu">{{ $lelang->kontrak()->first()->mutu()->first()->nama_mutu }}</p></td>
                                                        <td><p>UOM</p></td>
                                                        <td><p id="isi_uom">{{ $lelang->kontrak()->first()->komoditas()->first()->satuan_ukuran }}</p></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-none no-kontrak text-center my-2">Tidak ada kontrak yang tertaut ke akun ini</div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Lelang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_lelang" type="text"
                                            class="form-control @error('nomor_lelang') is-invalid @enderror" name="nomor_lelang"
                                            value="{{ $lelang->nomor_lelang }}" autocomplete="name"
                                            autofocus>

                                        @error('nomor_lelang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="asal_komoditas" class="col-md-4 col-form-label text-md-end">{{ __('Asal Komoditas')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="asal_komoditas" type="text"
                                            class="form-control @error('asal_komoditas') is-invalid @enderror" name="asal_komoditas"
                                            value="{{ $lelang->asal_komoditas }}" autocomplete="name"
                                            autofocus>
            
                                        @error('asal_komoditas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="judul" class="col-md-4 col-form-label text-md-end">{{ __('Judul')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="judul" type="text"
                                            class="form-control @error('judul') is-invalid @enderror" name="judul"
                                            value="{{ $lelang->judul }}" autocomplete="name"
                                            autofocus>
            
                                        @error('judul')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="spesifikasi_produk" class="col-md-4 col-form-label text-md-end">{{ __('Spesifikasi Produk')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea class="form-control @error('spesifikasi_produk') is-invalid @enderror" name="spesifikasi_produk" id="spesifikasi_produk" cols="30" rows="10">{{ $lelang->spesifikasi_produk }}</textarea>
            
                                        @error('spesifikasi_produk')
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
                                                class="form-control @error('kuantitas') is-invalid @enderror thousand-style" name="kuantitas"
                                                value="{{ $lelang->kuantitas }}" autocomplete="name"
                                                autofocus>
                                            
                                            <div class="input-group-append">
                                                <span class="input-group-text kuantitas" >Kg</span>
                                            </div>
                                        </div>
    
            
                                        @error('kuantitas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kemasan" class="col-md-4 col-form-label text-md-end">{{ __('Kemasan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="kemasan" type="text"
                                            class="form-control @error('kemasan') is-invalid @enderror" name="kemasan"
                                            value="{{ $lelang->kemasan }}" autocomplete="name"
                                            autofocus>
            
                                        @error('kemasan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="lokasi_penyerahan" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi Penyerahan')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <textarea class="form-control @error('lokasi_penyerahan') is-invalid @enderror" name="lokasi_penyerahan" id="lokasi_penyerahan" cols="30" rows="10">{{ $lelang->lokasi_penyerahan }}</textarea>
            
                                        @error('lokasi_penyerahan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_harga_id" class="col-md-4 col-form-label text-md-end">{{ __('Harga Penawaran Untuk')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="selectgroup w-100">
                                                @foreach($jenisHarga as $jh)
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenis_harga_id" data-name="{{ $jh->nama_jenis }}" value="{{ $jh->jenis_harga_id }}" class="selectgroup-input" {{ $lelang->jenis_harga()->first()->jenis_harga_id ==  $jh->jenis_harga_id ? 'checked=""' : '' }}>
                                                    <span class="selectgroup-button">{{ $jh->nama_jenis_harga }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        @error('jenis_harga_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="harga_awal" class="col-md-4 col-form-label text-md-end">{{ __('Harga Awal')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input id="harga_awal" type="text"
                                                    class="form-control thousand-style @error('harga_awal') is-invalid @enderror" name="harga_awal"
                                                    value="{{ $lelang->harga_awal }}" autocomplete="name"
                                                    autofocus /> 

                                                <div class="input-group-append">
                                                    <span class="input-group-text"><div class="d-none harga_satuan"> / Kg</div></span>
                                                </div>
                                            </div>
                                        </div>

                                        @error('harga_awal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kelipatan_penawaran" class="col-md-4 col-form-label text-md-end">{{ __('Kelipatan Penawaran')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input id="kelipatan_penawaran" type="text"
                                                    class="form-control thousand-style @error('kelipatan_penawaran') is-invalid @enderror" name="kelipatan_penawaran"
                                                    value="{{ $lelang->kelipatan_penawaran }}" autocomplete="name"
                                                    autofocus />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><div class=" d-none harga_satuan"> / Kg</div></span>
                                                </div>
                                            </div>
                                        </div>

                                        @error('kelipatan_penawaran')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="harga_beli_sekarang_check" {{ is_null($lelang->harga_beli_sekarang) ? '' : 'checked' }} class="custom-control-input" id="harga_beli_sekarang">
                                            <label class="custom-control-label" for="harga_beli_sekarang">Opsi Beli Sekarang</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center {{ is_null($lelang->harga_beli_sekarang) ? 'd-none' : '' }} harga_beli_sekarang_wrapper">
                                    <label for="harga_beli_sekarang" class="col-md-4 col-form-label text-md-end">{{ __('Harga Beli Sekarang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input id="harga_beli_sekarang" type="text"
                                                    class="form-control thousand-style @error('harga_beli_sekarang') is-invalid @enderror" name="harga_beli_sekarang"
                                                    value="{{ $lelang->harga_beli_sekarang }}" autocomplete="name"
                                                    autofocus>
                                            </div>
                                        </div>

                                        @error('harga_beli_sekarang')
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
                                        <a type="button" href="{{ route('transaksi.lelang_baru.show', $lelang->lelang_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


