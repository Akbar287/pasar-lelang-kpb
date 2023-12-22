@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang.penerimaan.show', $registrasi->registrasi_komoditas_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Gudang</h2>
    <p class="section-lead">
        Ubah data Gudang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('administrasi.gudang.penerimaan.update', $registrasi->registrasi_komoditas_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Gudang') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_registrasi_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Registrasi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="jenis_registrasi_id" type="text" readonly
                                        class="form-control" name="jenis_registrasi_id"
                                        value="{{ $registrasi->jenis_registrasi_komoditas()->first()->nama_jenis }}" />
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>
    
                                    <div class="col-md-6">
                                            <input id="tanggal" type="date"
                                                class="form-control  @error('tanggal') is-invalid @enderror" name="tanggal"
                                                value="{{ $registrasi->tanggal }}" />
    
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
                                                value="{{ $registrasi->kode_transaksi }}" />
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
                                            <option {{ $registrasi->informasi_akun_id == $jt->informasi_akun_id ? 'selected' : '' }} value="{{ $jt->informasi_akun_id }}">{{ $jt->nama . ' ('. $jt->nik .')' }}</option>
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
                                            <option {{ $registrasi->gudang()->first()->gudang_id == $jt->gudang_id ? 'selected' : '' }} value="{{ $jt->gudang_id }}">{{ $jt->nama_gudang }}</option>
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
                                            <option {{ $registrasi->komoditas()->first()->komoditas_id == $jt->komoditas_id ? 'selected' : '' }} value="{{ $jt->komoditas_id }}">{{ $jt->nama_komoditas }}</option>
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
                                            <option {{ $registrasi->mutu()->first()->mutu_id == $jt->mutu_id ? 'selected' : '' }} value="{{ $jt->mutu_id }}">{{ $jt->nama_mutu }}</option>
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
                                                value="{{ $registrasi->no_instruksi }}" autocomplete="name"
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
                                                value="{{ $registrasi->no_bast }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('nomor_bast')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
    
                                @if(!is_null($registrasi->registrasi_komoditas_alokasi()->first()))
                                <div class="row mb-3 justify-content-center">
                                    <label for="saldo_belum_teralokasi" class="col-md-4 col-form-label text-md-end">{{ __('Saldo Belum Teralokasi')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="saldo_belum_teralokasi" type="text"
                                                class="form-control thousand-style  @error('saldo_belum_teralokasi') is-invalid @enderror" name="saldo_belum_teralokasi"
                                                value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->saldo_belum_teralokasi }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('saldo_belum_teralokasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
    
                                <div class="row mb-3 justify-content-center">
                                    <label for="kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Kadaluarsa')
                                        }}</label>
    
                                    <div class="col-md-6">
                                            <input id="kadaluarsa" type="date"
                                                class="form-control  @error('kadaluarsa') is-invalid @enderror" name="kadaluarsa"
                                                value="{{ $registrasi->kadaluarsa }}" />
    
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
                                                value="{{ $registrasi->quantity }}" autocomplete="name"
                                                autofocus>
    
                                            <div class="input-group-prepend">
                                                <span class="input-group-text komoditas-satuan-ukuran">{{ $registrasi->komoditas()->first()->satuan_ukuran }}</span>
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
                                                value="{{ $registrasi->nilai }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('nilai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                @if(!is_null($registrasi->registrasi_komoditas_alokasi()->first()))
                                <div class="row mb-3 justify-content-center">
                                    <label for="sisa_alokasi" class="col-md-4 col-form-label text-md-end">{{ __('Sisa Alokasi')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="sisa_alokasi" type="text"
                                                class="form-control thousand-style  @error('sisa_alokasi') is-invalid @enderror" name="sisa_alokasi"
                                                value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->sisa_alokasi_saldo }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('sisa_alokasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
    
                                @if(!is_null($registrasi->registrasi_komoditas_alokasi()->first()))
                                <div class="row mb-3 justify-content-center">
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
                                @endif
    
                                @if(!is_null($registrasi->registrasi_komoditas_alokasi()->first()))
                                <div class="row mb-3 justify-content-center">
                                    <label for="alokasi_collateral" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Kolateral')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="alokasi_collateral" type="text"
                                                class="form-control thousand-style  @error('alokasi_collateral') is-invalid @enderror" name="alokasi_collateral"
                                                value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->alokasi_kolateral }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('alokasi_collateral')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
    
                                @if(!is_null($registrasi->registrasi_komoditas_alokasi()->first()))
                                <div class="row mb-3 justify-content-center">
                                    <label for="alokasi_penyelesaian" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Penyelesaian')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="alokasi_penyelesaian" type="text"
                                                class="form-control thousand-style  @error('alokasi_penyelesaian') is-invalid @enderror" name="alokasi_penyelesaian"
                                                value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->alokasi_penyelesaian }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('alokasi_penyelesaian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
    
                                @if(!is_null($registrasi->registrasi_komoditas_alokasi()->first()))
                                <div class="row mb-3 justify-content-center">
                                    <label for="alokasi_lain" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Lain')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="alokasi_lain" type="text"
                                                class="form-control thousand-style  @error('alokasi_lain') is-invalid @enderror" name="alokasi_lain"
                                                value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->alokasi_lain }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('alokasi_lain')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                {{-- End - Keuangan Reg In --}}
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <textarea id="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" type="text" cols="30" rows="10">{{ $registrasi->keterangan }}</textarea>
    
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
                                        <a type="button" href="{{ route('administrasi.gudang.penerimaan.show', $registrasi->registrasi_komoditas_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


