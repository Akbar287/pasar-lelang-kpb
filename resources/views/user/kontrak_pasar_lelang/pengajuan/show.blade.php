@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kontrak</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('kontrak') }}">Kontrak</a></div>
        <div class="breadcrumb-item"><a href="{{ route('kontrak.pengajuan') }}">Pengajuan</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Kontrak</h2>
    <p class="section-lead">
        Detail data Kontrak anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Ubah Kontrak Anggota') }}</h4>
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
                                        value="{{ $kontrak->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_perdagangan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Perdagangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{ $kontrak->jenis_perdagangan()->first()->nama_perdagangan }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Komoditas')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{$kontrak->komoditas()->first()->nama_komoditas  }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{ !is_null($kontrak->informasi_akun()->first()->member()->first()) ? $kontrak->informasi_akun()->first()->member()->first()->ktp()->first()->nama : $kontrak->informasi_akun()->first()->lembaga()->first()->nama_lembaga }}" />
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="simbol" class="col-md-4 col-form-label text-md-end">{{ __('Simbol')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="simbol" type="text" readonly
                                        class="form-control" name="simbol"
                                        value="{{ $kontrak->simbol }}" />
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

                                        <input id="minimum_transaksi" type="text" readonly
                                            class="form-control  thousand-style @error('minimum_transaksi') is-invalid @enderror" name="minimum_transaksi"
                                            value="{{ number_format($kontrak->minimum_transaksi, 0, ".", ",") }}" />

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

                                        <input id="maksimum_transaksi" type="text" readonly
                                            class="form-control  thousand-style @error('maksimum_transaksi') is-invalid @enderror" name="maksimum_transaksi"
                                            value="{{ number_format($kontrak->maksimum_transaksi, 0, ".", ",") }}" />

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
                                        <input id="fluktuasi_harga_harian" type="text" readonly
                                            class="form-control thousand-style  @error('fluktuasi_harga_harian') is-invalid @enderror" name="fluktuasi_harga_harian"
                                            value="{{ number_format($kontrak->fluktuasi_harga_harian, 0, ".", ",") }}" />
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
                                        <input id="premium" type="text" readonly
                                            class="form-control thousand-style  @error('premium') is-invalid @enderror" name="premium"
                                            value="{{ number_format($kontrak->premium, 0, ".", ",") }}" />

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

                                        <input id="diskon" type="text" readonly
                                            class="form-control  thousand-style @error('diskon') is-invalid @enderror" name="diskon"
                                            value="{{ number_format($kontrak->diskon, 0, ".", ",") }}" />

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
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                        </div>
                                        <input id="jatuh_tempo_t_plus" type="text" readonly
                                            class="form-control" name="jatuh_tempo_t_plus"
                                            value="{{ number_format($kontrak->jatuh_tempo_t_plus, 0, ".", ",") }}" />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Hari</div>
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
                    <h4>{{ __('Lama Waktu Kontrak') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_aktif" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Aktif')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                        </div>
                                        <input id="tanggal_aktif" type="date" readonly
                                            class="form-control" name="tanggal_aktif"
                                            value="{{ $kontrak->tanggal_aktif }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_berakhir" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Berakhir')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                        </div>
                                        <input id="tanggal_berakhir" type="date" readonly
                                            class="form-control" name="tanggal_berakhir"
                                            value="{{ $kontrak->tanggal_berakhir }}" />
                                    </div>
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
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-percent"></i></div>
                                            </div>

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
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-percent"></i></div>
                                        </div>
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
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-percent"></i></div>
                                        </div>
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
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-percent"></i></div>
                                        </div>
                                        <input id="fee_pembeli" type="text" readonly
                                            class="form-control thousand-style " name="fee_pembeli"
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
                                    <a type="button" href="{{ route('kontrak.pengajuan') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('kontrak.pengajuan.edit', $kontrak->kontrak_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('kontrak.pengajuan.destroy', $kontrak->kontrak_id) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Kontrak akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

