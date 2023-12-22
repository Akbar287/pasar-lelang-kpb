@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kontrak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('kontrak') }}">Kontrak</a></div>
        <div class="breadcrumb-item"><a href="{{ route('kontrak.pengajuan') }}">Pengajuan</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Kontrak</h2>
    <p class="section-lead">
        Tambahkan data Kontrak anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('kontrak.pengajuan.store') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Tambah Kontrak Anggota') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara Pasar Lelang')
                                        }}</label>

                                    <div class="col-md-6">
                                        <select class="custom-select @error('penyelenggara_pasar_lelang_id') is-invalid @enderror" name="penyelenggara_pasar_lelang_id" id="penyelenggara_pasar_lelang_id">
                                            <option value="0" selected>Pilih Penyelenggara</option>
                                            @foreach($penyelenggaraPasarLelang as $ppl)
                                            <option {{ old('penyelenggara_pasar_lelang_id') == $ppl->penyelenggara_pasar_lelang_id ? 'selected' : '' }} value="{{ $ppl->penyelenggara_pasar_lelang_id }}">{{ $ppl->admin()->first()->member()->first()->ktp()->first()->nama }}</option>
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
                                            <option value="0" selected>Pilih Jenis Perdagangan</option>
                                            @foreach($jenisPerdagangan as $jp)
                                            <option {{ old('jenis_perdagangan_id') == $jp->jenis_perdagangan_id ? 'selected' : '' }} value="{{ $jp->jenis_perdagangan_id }}">{{ $jp->nama_perdagangan }}</option>
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
                                            <option value="0" selected>Pilih Komoditas</option>
                                            @foreach($komoditas as $kom)
                                            <option {{ old('komoditas_id') == $kom->komoditas_id ? 'selected' : '' }} value="{{ $kom->komoditas_id }}">{{ $kom->nama_komoditas }}</option>
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
                                            <option {{ old('mutu_id') == $m->mutu_id ? 'selected' : '' }} value="{{ $m->mutu_id }}">{{ $m->nama_mutu }}</option>
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
                                    <label for="minimum_transaksi" class="col-md-4 col-form-label text-md-end">{{ __('Minimum Transaksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp. </div>
                                            </div>
                                            <input id="minimum_transaksi" type="text"
                                                class="form-control thousand-style @error('minimum_transaksi') is-invalid @enderror" name="minimum_transaksi"
                                                value="{{ old("minimum_transaksi") }}" />

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
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp. </div>
                                            </div>

                                            <input id="maksimum_transaksi" type="text"
                                                class="form-control thousand-style @error('maksimum_transaksi') is-invalid @enderror" name="maksimum_transaksi"
                                                value="{{ old("maksimum_transaksi") }}" />

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
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp. </div>
                                            </div>
                                            <input id="fluktuasi_harga_harian" type="text" value="0"
                                                class="form-control thousand-style @error('fluktuasi_harga_harian') is-invalid @enderror" name="fluktuasi_harga_harian"
                                                value="{{ old("fluktuasi_harga_harian") }}" />
                                        </div>

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
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-percent"></i></div>
                                            </div>
                                            <input id="premium" type="text" value="0"
                                                class="form-control thousand-style @error('premium') is-invalid @enderror" name="premium"
                                                value="{{ old("premium") }}" />

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
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-percent"></i></div>
                                            </div>
                                            <input id="diskon" type="text" value="0"
                                                class="form-control thousand-style @error('diskon') is-invalid @enderror" name="diskon"
                                                value="{{ old("diskon") }}" />

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
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                            </div>
                                            <input id="jatuh_tempo_t_plus" type="number" min="0" value="14"
                                                class="form-control @error('jatuh_tempo_t_plus') is-invalid @enderror" name="jatuh_tempo_t_plus"
                                                value="{{ old("jatuh_tempo_t_plus") }}" />

                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Hari</div>
                                            </div>
                                        </div>

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
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('kontrak.pengajuan') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
