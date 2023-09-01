@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Penerimaan Gudang</h2>
    <p class="section-lead">
        Tambahkan data Penerimaan Gudang.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('administrasi.gudang.penerimaan.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Penerimaan Gudang') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_registrasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Registrasi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_registrasi_id') is-invalid @enderror" @if(count($jenisRegistrasi) == 0) disabled @endif  name="jenis_registrasi_id" id="jenis_registrasi_id">
                                            @foreach ($jenisRegistrasi as $jt)
                                            <option value="{{ $jt->nama_jenis }}">{{ $jt->nama_jenis }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('jenis_registrasi_id')
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

                                <div class="row mb-3 justify-content-center">
                                    <label for="transaksi_id" class="col-md-4 col-form-label text-md-end">{{ __('Transaksi Id')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="transaksi_id" type="text" readonly
                                                class="form-control @error('transaksi_id') is-invalid @enderror" name="transaksi_id"
                                                value="{{ $kodeTransaksi }}" />
                                        </div>
                                        @error('transaksi_id')
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
                                        <select class="custom-select @error('informasi_akun_id') is-invalid @enderror" @if(count($informasi_akun) == 0) disabled @endif  name="informasi_akun_id" id="informasi_akun_id">
                                            @foreach ($informasi_akun as $jt)
                                            <option value="{{ $jt->informasi_akun_id }}">{{ $jt->ktp()->first()->nama }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('informasi_akun_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="gudang_id" class="col-md-4 col-form-label text-md-end">{{ __('Gudang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('gudang_id') is-invalid @enderror" @if(count($gudang) == 0) disabled @endif  name="gudang_id" id="gudang_id">
                                            @foreach ($gudang as $jt)
                                            <option value="{{ $jt->gudang_id }}">{{ $jt->nama_gudang }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('gudang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Komoditas')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('komoditas_id') is-invalid @enderror" @if(count($komoditas) == 0) disabled @endif  name="komoditas_id" id="komoditas_id">
                                            @foreach ($komoditas as $jt)
                                            <option value="{{ $jt->komoditas_id }}">{{ $jt->nama_komoditas }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('komoditas_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="mutu_id" class="col-md-4 col-form-label text-md-end">{{ __('Mutu')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('mutu_id') is-invalid @enderror" @if(count($mutu) == 0) disabled @endif  name="mutu_id" id="mutu_id">
                                            @foreach ($mutu as $jt)
                                            <option value="{{ $jt->mutu_id }}">{{ $jt->nama_mutu }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('mutu_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_instruksi" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="nomor_instruksi" type="text"
                                                class="form-control @error('nomor_instruksi') is-invalid @enderror" name="nomor_instruksi"
                                                value="{{ old("nomor_instruksi") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('nomor_instruksi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_bast" class="col-md-4 col-form-label text-md-end">{{ __('Nomor BAST')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="nomor_bast" type="text"
                                                class="form-control @error('nomor_bast') is-invalid @enderror" name="nomor_bast"
                                                value="{{ old("nomor_bast") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('nomor_bast')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="saldo_belum_teralokasi" class="col-md-4 col-form-label text-md-end">{{ __('Saldo Belum Teralokasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="saldo_belum_teralokasi" type="text"
                                                class="form-control thousand-style  @error('saldo_belum_teralokasi') is-invalid @enderror" name="saldo_belum_teralokasi"
                                                value="{{ old("saldo_belum_teralokasi") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('saldo_belum_teralokasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Kadaluarsa')
                                        }}</label>

                                    <div class="col-md-6">
                                            <input id="kadaluarsa" type="date"
                                                class="form-control  @error('kadaluarsa') is-invalid @enderror" name="kadaluarsa"
                                                value="{{ is_null(old("kadaluarsa")) ? date('Y-m-d') : old("kadaluarsa") }}" />

                                        @error('kadaluarsa')
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
                                                class="form-control thousand-style  @error('kuantitas') is-invalid @enderror" name="kuantitas"
                                                value="{{ old("kuantitas") }}" autocomplete="name"
                                                autofocus>

                                            <div class="input-group-prepend">
                                                <span class="input-group-text komoditas-satuan-ukuran">{{ $komoditas->first()->satuan_ukuran }}</span>
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
                                    <label for="nilai" class="col-md-4 col-form-label text-md-end">{{ __('Nilai')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="nilai" type="text"
                                                class="form-control thousand-style  @error('nilai') is-invalid @enderror" name="nilai"
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
                                
                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="sisa_alokasi" class="col-md-4 col-form-label text-md-end">{{ __('Sisa Alokasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="sisa_alokasi" type="text" readonly
                                                class="form-control thousand-style  @error('sisa_alokasi') is-invalid @enderror" name="sisa_alokasi"
                                                value="{{ old("sisa_alokasi") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('sisa_alokasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="jenis_alokasi" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Alokasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <select class="custom-select @error('jenis_alokasi') is-invalid @enderror" name="jenis_alokasi" id="jenis_alokasi">
                                                <option {{ old('jenis_alokasi') == 'nominal' ? 'selected' : ''  }} value="{{ 'nominal' }}">{{ 'Nominal' }}</option>
                                            </select>
                                        </div>

                                        @error('jenis_alokasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="alokasi_collateral" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Kolateral')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="alokasi_collateral" type="text"
                                                class="form-control thousand-style  @error('alokasi_collateral') is-invalid @enderror" name="alokasi_collateral"
                                                value="{{ old("alokasi_collateral") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('alokasi_collateral')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="alokasi_penyelesaian" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Penyelesaian')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="alokasi_penyelesaian" type="text"
                                                class="form-control thousand-style  @error('alokasi_penyelesaian') is-invalid @enderror" name="alokasi_penyelesaian"
                                                value="{{ old("alokasi_penyelesaian") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('alokasi_penyelesaian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center reg-in">
                                    <label for="alokasi_lain" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Lain')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="alokasi_lain" type="text"
                                                class="form-control thousand-style  @error('alokasi_lain') is-invalid @enderror" name="alokasi_lain"
                                                value="{{ old("alokasi_lain") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('alokasi_lain')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- End - Keuangan Reg In --}}
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea id="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" type="text" cols="30" rows="10">{{ old("keterangan") }}</textarea>

                                        @error('jumlah')
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
                                        <a type="button" href="{{ route('administrasi.gudang.penerimaan.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
