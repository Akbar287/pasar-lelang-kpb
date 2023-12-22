@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Pengeluaran Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.pengeluaran.index') }}">Pengeluaran</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Pengeluaran Jaminan</h2>
    <p class="section-lead">
        Tambahkan data Pengeluaran Jaminan.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('administrasi.jaminan.pengeluaran.store') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pengeluaran Jaminan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_transaksi" class="col-md-4 col-form-label text-md-end">{{ __('Kode Transaksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="kode_transaksi" type="text" readonly
                                                class="form-control @error('kode_transaksi') is-invalid @enderror" name="kode_transaksi"
                                                value="{{ $kodeTransaksi }}" />
                                        </div>
                                        @error('kode_transaksi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_pengeluaran_jaminan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Registrasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_pengeluaran_jaminan_id') is-invalid @enderror" @if(count($jenisPengeluaranJaminan) == 0) disabled @endif  name="jenis_pengeluaran_jaminan_id" id="jenis_pengeluaran_jaminan_id">
                                            @foreach ($jenisPengeluaranJaminan as $jt)
                                            <option value="{{ $jt->nama_jenis }}">{{ $jt->nama_jenis }}</option>
                                            @endforeach
                                        </select>

                                        @error('jenis_pengeluaran_jaminan_id')
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
                                        <select class="custom-select @error('informasi_akun_id') is-invalid @enderror" @if(count($informasiAkun) == 0) disabled @endif  name="informasi_akun_id" id="informasi_akun_id">
                                            @foreach ($informasiAkun as $jt)
                                            <option value="{{ $jt->informasi_akun_id }}">{{ $jt->nama }}</option>
                                            @endforeach
                                        </select>

                                        @error('informasi_akun_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center return-cash release-cash">
                                    <label for="saldo_tersedia" class="col-md-4 col-form-label text-md-end">{{ __('Total Saldo Tersedia')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="saldo_tersedia" type="text" readonly
                                                class="form-control thousand-style " name="saldo_tersedia"
                                                value="{{ '0' }}" />
                                        </div>
                                        @error('saldo_tersedia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>

                                    <div class="col-md-6">
                                            <input id="tanggal" type="date"
                                                class="form-control  @error('tanggal') is-invalid @enderror" name="tanggal"
                                                value="{{ is_null(old("tanggal")) ? date('Y-m-d') : old("tanggal") }}" />

                                        @error('tanggal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Return Cash --}}
                                <div class="row mb-3 justify-content-center return-cash d-none">
                                    <label for="jumlah_pengembalian" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah Pengembalian')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="jumlah_pengembalian" type="text"
                                                class="form-control thousand-style  @error('jumlah_pengembalian') is-invalid @enderror" name="jumlah_pengembalian"
                                                value="{{ old('jumlah_pengembalian') }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('jumlah_pengembalian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- End Return Cash --}}

                                {{-- Release Commodity Collateral --}}
                                <div class="row mb-3 justify-content-center jaminan_komoditas d-none">
                                    <label for="registrasi_komoditas_jaminan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jaminan Komoditas')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select" disabled name="registrasi_komoditas_jaminan_id" id="registrasi_komoditas_jaminan_id">
                                        </select>

                                        @error('registrasi_komoditas_jaminan_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center jaminan_komoditas d-none">
                                    <label for="qty_settlement" class="col-md-4 col-form-label text-md-end">{{ __('Kuantitas Diserahkan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                            </div>
                                            <input id="qty_settlement" type="text"
                                                class="form-control thousand-style  @error('qty_settlement') is-invalid @enderror" name="qty_settlement"
                                                value="{{ old('qty_settlement') }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('qty_settlement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center jaminan_komoditas d-none">
                                    <label for="alokasi_settlement" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Settlement')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="alokasi_settlement" type="text" readonly
                                                class="form-control thousand-style  @error('alokasi_settlement') is-invalid @enderror" name="alokasi_settlement"
                                                value="{{ old('alokasi_settlement') }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('alokasi_settlement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- End Release Commodity Collateral --}}

                                {{-- Realease Cash  --}}
                                <div class="row mb-3 justify-content-center release-cash">
                                    <label for="jumlah" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="jumlah" type="text"
                                                class="form-control thousand-style  @error('jumlah') is-invalid @enderror" name="jumlah"
                                                value="{{ old('jumlah') }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- End Realease Cash  --}}

                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea id="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" type="text" cols="30" rows="10">{{ old('keterangan') }}</textarea>

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
                                        <a type="button" href="{{ route('administrasi.jaminan.pengeluaran.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
