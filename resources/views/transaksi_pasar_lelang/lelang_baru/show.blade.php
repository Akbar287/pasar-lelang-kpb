@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi') }}">Transaksi Pasar lelang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('transaksi.lelang_baru') }}">Lelang</a></div>
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
                                <label for="jenis_perdagangan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Perdagangan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jenis_perdagangan_id" type="text" readonly
                                            class="form-control" name="jenis_perdagangan_id"
                                            value="{{ $lelang->jenis_perdagangan()->first()->nama_perdagangan }}">
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_inisiasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Inisiasi')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="jenis_inisiasi_id" type="text" readonly
                                            class="form-control" name="jenis_inisiasi_id"
                                            value="{{ $lelang->jenis_inisiasi()->first()->nama_inisiasi }}">
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>
        
                                <div class="col-md-6">
                                        <input id="informasi_akun_id" type="text" readonly
                                            class="form-control" name="informasi_akun_id"
                                            value="{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}">
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center kontrak">
                                <label for="kontrak_id" class="col-md-4 col-form-label text-md-end">{{ __('Kontrak')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="kontrak_id" type="text" readonly
                                        class="form-control" name="kontrak_id"
                                        value="{{ $lelang->kontrak()->first()->kontrak_id }}">
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
                                                    <td><p id="isi_satuan_transaksi">Rp. {{ number_format($lelang->kontrak()->first()->minimum_transaksi, 2, ",", '.') }}</p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Jenis Perdagangan</p></td>
                                                    <td><p id="isi_jenis_perdagangan">{{ $lelang->kontrak()->first()->jenis_perdagangan()->first()->nama_perdagangan }}</p></td>
                                                    <td><p>Maks. Transaksi</p></td>
                                                    <td><p id="isi_max_transaksi">Rp. {{ number_format($lelang->kontrak()->first()->maksimum_transaksi, 2, ",", ".") }}</p></td>
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
                                    <input id="nomor_lelang" type="text" readonly
                                        class="form-control" name="nomor_lelang"
                                        value="{{ $lelang->nomor_lelang }}">
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="asal_komoditas" class="col-md-4 col-form-label text-md-end">{{ __('Asal Komoditas')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="asal_komoditas" type="text" readonly
                                        class="form-control" name="asal_komoditas"
                                        value="{{ $lelang->asal_komoditas }}">
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="judul" class="col-md-4 col-form-label text-md-end">{{ __('Judul')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="judul" type="text" readonly
                                        class="form-control @error('judul') is-invalid @enderror" name="judul"
                                        value="{{ $lelang->judul }}">
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="spesifikasi_produk" class="col-md-4 col-form-label text-md-end">{{ __('Spesifikasi Produk')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" readonly name="spesifikasi_produk" id="spesifikasi_produk" cols="30" rows="10">{{ $lelang->spesifikasi_produk }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kuantitas" class="col-md-4 col-form-label text-md-end">{{ __('Kuantitas')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="kuantitas" type="text" readonly
                                            class="form-control thousand-style" name="kuantitas"
                                            value="{{ $lelang->kuantitas }}">
                                        
                                        <div class="input-group-append">
                                            <span class="input-group-text kuantitas" >{{ $lelang->kontrak()->first()->komoditas()->first()->satuan_ukuran }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kemasan" class="col-md-4 col-form-label text-md-end">{{ __('Kemasan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="kemasan" type="text" readonly
                                        class="form-control" name="kemasan"
                                        value="{{ $lelang->kemasan }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="lokasi_penyerahan" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi Penyerahan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <textarea class="form-control" readonly name="lokasi_penyerahan" id="lokasi_penyerahan" cols="30" rows="10">{{ $lelang->lokasi_penyerahan }}</textarea>
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
                                                <input type="radio" disabled name="jenis_harga_id" data-name="{{ $jh->nama_jenis }}" value="{{ $jh->jenis_harga_id }}" class="selectgroup-input" {{ $lelang->jenis_harga()->first()->jenis_harga_id ==  $jh->jenis_harga_id ? 'checked=""' : '' }}>
                                                <span class="selectgroup-button">{{ $jh->nama_jenis_harga }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
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
                                            <input id="harga_awal" type="text" readonly
                                                class="form-control" name="harga_awal"
                                                value="{{ number_format($lelang->harga_awal, 2, ".", ",") }}"/> 
                                        </div>
                                    </div>
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
                                            <input id="kelipatan_penawaran" type="text" readonly
                                                class="form-control" name="kelipatan_penawaran"
                                                value="{{ number_format($lelang->kelipatan_penawaran, 2, ".", ",") }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" disabled {{ is_null($lelang->harga_beli_sekarang) ? '' : 'checked' }} class="custom-control-input" id="harga_beli_sekarang">
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
                                            <input id="harga_beli_sekarang" type="text" readonly
                                                class="form-control" name="harga_beli_sekarang"
                                                value="{{ number_format($lelang->harga_beli_sekarang, 2, ".", ",") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                    </div>
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
                                    <a type="button" href="{{ route('transaksi.lelang_baru') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('transaksi.lelang_baru.file', $lelang->lelang_id) }}" class="btn mx-2 btn-info"><i class="fas fa-file"></i> Dokumen</a>
                                    <a type="button" href="{{ route('transaksi.lelang_baru.edit', $lelang->lelang_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('transaksi.lelang_baru.destroy', $lelang->lelang_id) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Lelang akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

