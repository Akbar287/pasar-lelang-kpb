@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Kas Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank') }}">Kas Bank</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Penerimaan Kas Bank</h2>
    <p class="section-lead">
        Tambahkan data Penerimaan Kas Bank.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <form action="{{ route('administrasi.kas_bank.penerimaan.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Penerimaan Kas Bank') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_transaksi_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Transaksi')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_transaksi_id') is-invalid @enderror" @if(count($jenisTransaksi) == 0) disabled @endif  name="jenis_transaksi_id" id="jenis_transaksi_id">
                                            @foreach ($jenisTransaksi as $jt)
                                            <option value="{{ $jt->nama_jenis }}">{{ $jt->nama_jenis }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('jenis_transaksi_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="kurs_mata_uang_id" class="col-md-4 col-form-label text-md-end">{{ __('Kurs Mata Uang')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('kurs_mata_uang_id') is-invalid @enderror" @if(count($kurs) == 0) disabled @endif  name="kurs_mata_uang_id" id="kurs_mata_uang_id">
                                            @foreach ($kurs as $jt)
                                            <option value="{{ $jt->kurs_mata_uang_id }}">{{ $jt->mata_uang_asal . ' - ' . $jt->mata_uang_tujuan }}</option>
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
                                    <label for="member_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('member_id') is-invalid @enderror" @if(count($member) == 0) disabled @endif  name="member_id" id="member_id">
                                            @foreach ($member as $jt)
                                            <option value="{{ $jt->member_id }}">{{ $jt->ktp()->first()->nama }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('member_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="rekening_bank_id" class="col-md-4 col-form-label text-md-end">{{ __('Rekening Bank')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select" disabled name="rekening_bank_id" id="rekening_bank_id">
                                        </select>
                                        
                                        @error('rekening_bank_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jumlah" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="jumlah" type="text"
                                                class="form-control thousand-style  @error('jumlah') is-invalid @enderror" name="jumlah"
                                                value="{{ old("jumlah") }}" autocomplete="name"
                                                autofocus>
                                        </div>
                                        @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center d-none cash-in cash-in-non">
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

                                {{-- Keuangan Cash In Trading --}}
                                <div class="row mb-3 justify-content-center d-none cash-in">
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
                                
                                <div class="row mb-3 justify-content-center d-none cash-in">
                                    <label for="jenis_alokasi" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Alokasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <select class="custom-select @error('jenis_alokasi') is-invalid @enderror" @if(count($member) == 0) disabled @endif  name="jenis_alokasi" id="jenis_alokasi">
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

                                <div class="row mb-3 justify-content-center d-none cash-in">
                                    <label for="sisa_alokasi" class="col-md-4 col-form-label text-md-end">{{ __('Sisa Alokasi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="sisa_alokasi" type="text"
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

                                <div class="row mb-3 justify-content-center d-none cash-in">
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

                                <div class="row mb-3 justify-content-center d-none cash-in">
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

                                <div class="row mb-3 justify-content-center d-none cash-in">
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
                                {{-- End - Keuangan Cash In Trading --}}
                                
                                {{-- Keuangan Cash In Settlement & Pengembalian Collateral --}}
                                <div class="row mb-3 justify-content-center d-none settlement pengembalian-collateral">
                                    <label for="no_rekening_tujuan_id" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening Admin')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('no_rekening_tujuan_id') is-invalid @enderror" @if(count($noRekAdmin) == 0) disabled @endif  name="no_rekening_tujuan_id" id="no_rekening_tujuan_id">
                                            @foreach ($noRekAdmin as $jt)
                                            <option value="{{ $jt->member()->first()->informasi_akun()->first()->rekening_bank()->first()->rekening_bank_id }}">{{ $jt->member()->first()->ktp()->first()->nama . ' ('.$jt->member()->first()->informasi_akun()->first()->rekening_bank()->first()->nomor_rekening.')' }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('no_rekening_tujuan_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>      
                                {{-- End - Keuangan Cash In Settlement & Pengembalian Collateral --}}                          

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
                                        <a type="button" href="{{ route('administrasi.kas_bank.penerimaan.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
