@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Kontrak Non-Aktif</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.kontrak') }}">Anggota</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.kontrak.nonaktif') }}">Kontrak</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Kontrak Non-Aktif</h2>
    <p class="section-lead">
        Detail data Kontrak Non-Aktif.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Kontrak Anggota') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="penyelenggara_pasar_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{ $kontrak->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_perdagangan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Perdagangan')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{ $kontrak->jenis_perdagangan()->first()->nama_perdagangan }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Komoditas')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{$kontrak->komoditas()->first()->nama_komoditas  }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{ !is_null($kontrak->informasi_akun()->first()->member()->first()) ? $kontrak->informasi_akun()->first()->member()->first()->ktp()->first()->nama : $kontrak->informasi_akun()->first()->lembaga()->first()->nama_lembaga }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="simbol" class="col-md-4 col-form-label text-md-end">{{ __('Simbol')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{ $kontrak->simbol }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="minimum_transaksi" class="col-md-4 col-form-label text-md-end">{{ __('Minimum Transaksi')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <input id="minimum_transaksi" type="text" readonly
                                            class="form-control  thousand-style @error('minimum_transaksi') is-invalid @enderror" name="minimum_transaksi"
                                            value="{{ $kontrak->minimum_transaksi }}" autocomplete="name"
                                            autofocus>
                                            
                                        <div class="input-group-append">
                                            <div class="input-group-text">/ Kg</div>
                                        </div>
                                    </div>
        
                                    @error('minimum_transaksi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="maksimum_transaksi" class="col-md-4 col-form-label text-md-end">{{ __('Maksimum Transaksi')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <input id="maksimum_transaksi" type="text" readonly
                                            class="form-control  thousand-style @error('maksimum_transaksi') is-invalid @enderror" name="maksimum_transaksi"
                                            value="{{ $kontrak->maksimum_transaksi }}" autocomplete="name"
                                            autofocus>
                                            
                                        <div class="input-group-append">
                                            <div class="input-group-text">/ Kg</div>
                                        </div>
                                    </div>
        
                                    @error('maksimum_transaksi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="fluktuasi_harga_harian" class="col-md-4 col-form-label text-md-end">{{ __('Fluktuasi Harga Harian')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="fluktuasi_harga_harian" type="text" readonly
                                        class="form-control  thousand-style @error('fluktuasi_harga_harian') is-invalid @enderror" name="fluktuasi_harga_harian"
                                        value="{{ $kontrak->fluktuasi_harga_harian }}" autocomplete="name"
                                        autofocus>
        
                                    @error('fluktuasi_harga_harian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="premium" class="col-md-4 col-form-label text-md-end">{{ __('Premium')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <input id="premium" type="text" readonly
                                            class="form-control  thousand-style @error('premium') is-invalid @enderror" name="premium"
                                            value="{{ $kontrak->premium }}" autocomplete="name"
                                            autofocus>
                                            
                                        <div class="input-group-append">
                                            <div class="input-group-text">/ Kg</div>
                                        </div>
                                    </div>
        
                                    @error('premium')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="diskon" class="col-md-4 col-form-label text-md-end">{{ __('Diskon')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <input id="diskon" type="text" readonly
                                            class="form-control  thousand-style @error('diskon') is-invalid @enderror" name="diskon"
                                            value="{{ $kontrak->diskon }}" autocomplete="name"
                                            autofocus>
                                            
                                        <div class="input-group-append">
                                            <div class="input-group-text">/ Kg</div>
                                        </div>
                                    </div>
        
                                    @error('diskon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="jatuh_tempo_t_plus" class="col-md-4 col-form-label text-md-end">{{ __('Jatuh Tempo T+')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jatuh_tempo_t_plus" type="text" readonly
                                        class="form-control" name="jatuh_tempo_t_plus"
                                        value="{{ $kontrak->jatuh_tempo_t_plus }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Lama Waktu Kontrak') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Aktif')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="tanggal_aktif" type="date" readonly
                                        class="form-control" name="tanggal_aktif"
                                        value="{{ $kontrak->tanggal_aktif }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_berakhir" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Berakhir')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="tanggal_berakhir" type="date" readonly
                                        class="form-control" name="tanggal_berakhir"
                                        value="{{ $kontrak->tanggal_berakhir }}" autocomplete="name"
                                        autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Kontrak Keuangan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="jaminan_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Jaminan Lelang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    
                                        <div class="input-group mb-2">
                                            <input id="jaminan_lelang" type="text" readonly
                                                class="form-control thousand-style " name="jaminan_lelang"
                                                value="{{ $kontrak->kontrak_keuangan()->first()->jaminan_lelang }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">x Nilai Transaksi</div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="denda" class="col-md-4 col-form-label text-md-end">{{ __('Denda')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <input id="denda" type="text" readonly
                                            class="form-control thousand-style " name="denda"
                                            value="{{ $kontrak->kontrak_keuangan()->first()->denda }}" >
                                        <div class="input-group-append">
                                            <div class="input-group-text">/bulan x kurang bayar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="fee_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Fee Penjual')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <input id="fee_penjual" type="text" readonly
                                            class="form-control thousand-style " name="fee_penjual"
                                            value="{{ $kontrak->kontrak_keuangan()->first()->fee_penjual }}">
                                            
                                        <div class="input-group-append">
                                            <div class="input-group-text">x Nilai Transaksi</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="fee_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Fee Pembeli')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <input id="fee_pembeli" type="text" readonly
                                            class="form-control  thousand-style " name="fee_pembeli"
                                            value="{{ $kontrak->kontrak_keuangan()->first()->fee_pembeli }}">
                                            
                                        <div class="input-group-append">
                                            <div class="input-group-text">x Nilai Transaksi</div>
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
                                    <a type="button" href="{{ route('master.kontrak.nonaktif') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <form action="{{ route('master.kontrak.nonaktif.aktif', $kontrak->kontrak_id) }}" method="POST">@csrf @method('put')
                                        <button type="submit" onclick="return confirm('Kontrak akan diaktifkan!\n Lanjutkan?')" title="Aktifkan Kontrak" class="btn btn-success"><i class="fas fa-check"></i> Aktifkan</button>
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

