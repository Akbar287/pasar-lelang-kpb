@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kontrak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master') }}">Master Data</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.kontrak') }}">Kontrak</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.kontrak.pengaturan') }}">Pengaturan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('master.kontrak.pengaturan.show', $kontrak->kontrak_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Kontrak</h2>
    <p class="section-lead">
        Ubah data Kontrak anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('master.kontrak.pengaturan.update', $kontrak->kontrak_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Kontrak Anggota') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id" id="penyelenggara_pasar_lelang_id">
                                            @foreach($penyelenggaraPasarLelang as $ppl)
                                            <option {{ $kontrak->penyelenggara_pasar_lelang()->first()->penyelenggara_pasar_lelang_id == $ppl->penyelenggara_pasar_lelang_id ? 'selected' : '' }} value="{{ $ppl->penyelenggara_pasar_lelang_id }}">{{ $ppl->admin()->first()->member()->first()->ktp()->first()->nama }}</option>
                                            @endforeach
                                        </select>

                                        @error('penyelenggara_pasar_lelang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_perdagangan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Perdagangan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_perdagangan_id') is-invalid @enderror" name="jenis_perdagangan_id" id="jenis_perdagangan_id">
                                            @foreach($jenisPerdagangan as $jp)
                                            <option {{ $kontrak->jenis_perdagangan()->first()->jenis_perdagangan_id == $jp->jenis_perdagangan_id ? 'selected' : '' }} value="{{ $jp->jenis_perdagangan_id }}">{{ $jp->nama_perdagangan }}</option>
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
                                    <label for="komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Komoditas')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('komoditas_id') is-invalid @enderror" name="komoditas_id" id="komoditas_id">
                                            @foreach($komoditas as $kom)
                                            <option {{ $kontrak->komoditas()->first()->komoditas_id == $kom->komoditas_id ? 'selected' : '' }} value="{{ $kom->komoditas_id }}">{{ $kom->nama_komoditas }}</option>
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
                                        <select class="custom-select @error('mutu_id') is-invalid @enderror" name="mutu_id" id="mutu_id">
                                            <option value="0" selected>Pilih Mutu</option>
                                            @foreach($mutu as $m)
                                            <option {{ $kontrak->mutu()->first()->mutu_id == $m->mutu_id ? 'selected' : '' }} value="{{ $m->mutu_id }}">{{ $m->nama_mutu }}</option>
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
                                    <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('informasi_akun_id') is-invalid @enderror" name="informasi_akun_id" id="informasi_akun_id">
                                            @foreach($informasiAkun as $ia)
                                            <option {{ $kontrak->informasi_akun()->first()->informasi_akun_id == $ia->informasi_akun()->first()->informasi_akun_id ? 'selected' : '' }} value="{{ $ia->informasi_akun()->first()->informasi_akun_id }}">{{ $ia->ktp()->first()->nama . (!is_null($ia->lembaga_informasi_pic()->first()) ? ' ('. $ia->lembaga_informasi_pic()->first()->lembaga()->first()->nama_lembaga .')' : '') }}</option>
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
                                    <label for="simbol" class="col-md-4 col-form-label text-md-end">{{ __('Simbol')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="simbol" type="text"
                                            class="form-control @error('simbol') is-invalid @enderror" name="simbol"
                                            value="{{ $kontrak->simbol }}" autocomplete="name"
                                            autofocus>

                                        @error('simbol')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="minimum_transaksi" class="col-md-4 col-form-label text-md-end">{{ __('Minimum Transaksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <input id="minimum_transaksi" type="text"
                                                class="form-control thousand-style  @error('minimum_transaksi') is-invalid @enderror" name="minimum_transaksi"
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
                                            <input id="maksimum_transaksi" type="text"
                                                class="form-control thousand-style  @error('maksimum_transaksi') is-invalid @enderror" name="maksimum_transaksi"
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
                                        <input id="fluktuasi_harga_harian" type="text"
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
                                            <input id="premium" type="text"
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
                                            <input id="diskon" type="text"
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
                                        <input id="jatuh_tempo_t_plus" type="text"
                                            class="form-control @error('jatuh_tempo_t_plus') is-invalid @enderror" name="jatuh_tempo_t_plus"
                                            value="{{ $kontrak->jatuh_tempo_t_plus }}" autocomplete="name"
                                            autofocus>

                                        @error('jatuh_tempo_t_plus')
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
                        <h4>{{ __('Lama Waktu Kontrak') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Aktif')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal_aktif" type="date"
                                            class="form-control @error('tanggal_aktif') is-invalid @enderror" name="tanggal_aktif"
                                            value="{{ $kontrak->tanggal_aktif }}" autocomplete="name"
                                            autofocus>

                                        @error('tanggal_aktif')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_berakhir" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Berakhir')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal_berakhir" type="date"
                                            class="form-control @error('tanggal_berakhir') is-invalid @enderror" name="tanggal_berakhir"
                                            value="{{ $kontrak->tanggal_berakhir }}" autocomplete="name"
                                            autofocus>

                                        @error('tanggal_berakhir')
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
                                                <input id="jaminan_lelang" type="text"
                                                    class="form-control thousand-style @error('jaminan_lelang') is-invalid @enderror" name="jaminan_lelang"
                                                    value="{{ $kontrak->kontrak_keuangan()->first()->jaminan_lelang }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">x Nilai Transaksi</div>
                                                </div>
                                            </div>

                                        @error('jaminan_lelang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="denda" class="col-md-4 col-form-label text-md-end">{{ __('Denda')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <input id="denda" type="text"
                                                class="form-control thousand-style @error('denda') is-invalid @enderror" name="denda"
                                                value="{{ $kontrak->kontrak_keuangan()->first()->denda }}" >
                                            <div class="input-group-append">
                                                <div class="input-group-text">/bulan x kurang bayar</div>
                                            </div>
                                        </div>

                                        @error('denda')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="fee_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Fee Penjual')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <input id="fee_penjual" type="text"
                                                class="form-control thousand-style @error('fee_penjual') is-invalid @enderror" name="fee_penjual"
                                                value="{{ $kontrak->kontrak_keuangan()->first()->fee_penjual }}">

                                            <div class="input-group-append">
                                                <div class="input-group-text">x Nilai Transaksi</div>
                                            </div>
                                        </div>

                                        @error('fee_penjual')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="fee_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Fee Pembeli')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <input id="fee_pembeli" type="text"
                                                class="form-control thousand-style  @error('fee_pembeli') is-invalid @enderror" name="fee_pembeli"
                                                value="{{ $kontrak->kontrak_keuangan()->first()->fee_pembeli }}">

                                            <div class="input-group-append">
                                                <div class="input-group-text">x Nilai Transaksi</div>
                                            </div>
                                        </div>

                                        @error('fee_pembeli')
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
                                        <a type="button" href="{{ route('master.kontrak.pengaturan.show', $kontrak->kontrak_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


