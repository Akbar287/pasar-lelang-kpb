@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Transaksi Lelang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('operational') }}">Operational</a></div>
        <div class="breadcrumb-item"><a href="{{ route('operational.lelang.transaksi.index') }}">Transaksi Lelang</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Transaksi Lelang</h2>
    <p class="section-lead">
        Detail data Transaksi Lelang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Detail Transaksi Lelang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_lelang" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Lelang')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="nomor_lelang" type="text" readonly
                                        class="form-control" name="nomor_lelang"
                                        value="{{ $lelang->nomor_lelang }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="mnomor_kontrak" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Kontrak')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="mnomor_kontrak" type="text" readonly
                                        class="form-control" name="mnomor_kontrak"
                                        value="{{ $lelang->kontrak()->first()->kontrak_kode }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Komoditas')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="komoditas_id" type="text" readonly
                                        class="form-control" name="komoditas_id"
                                        value="{{ $lelang->kontrak()->first()->komoditas()->first()->nama_komoditas }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_perdagangan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jenis_perdagangan_id" type="text" readonly
                                        class="form-control" name="jenis_perdagangan_id"
                                        value="{{ $lelang->kontrak()->first()->jenis_perdagangan()->first()->nama_perdagangan }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="penyelenggara_pasar_lelang_id" class="col-md-4 col-form-label text-md-end">{{ __('Penyelenggara PLK')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="penyelenggara_pasar_lelang_id" type="text" readonly
                                        class="form-control" name="penyelenggara_pasar_lelang_id"
                                        value="{{ is_null($lelang->jenis_platform_lelang()->first()) ? 'Tidak Memiliki Penyelenggara' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? $lelang->event_lelang()->first()->offline_profile()->first()->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama : $lelang->event_lelang()->first()->offline_profile()->first()->penyelenggara_pasar_lelang()->first()->admin()->first()->member()->first()->ktp()->first()->nama)) }}" />
                                </div>
                            </div>

                            @if($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline)
                            <div class="row mb-3 justify-content-center">
                                <label for="member_id" class="col-md-4 col-form-label text-md-end">{{ __('Sesi Lelang Ke #')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="member_id" type="text" readonly
                                        class="form-control" name="member_id"
                                        value="{{ $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->sesi }}" />
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3 justify-content-center">
                                <label for="jam_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Waktu Mulai Lelang')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jam_mulai" type="text" readonly
                                        class="form-control" name="jam_mulai"
                                        value="{{ $lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_mulai : $lelang->event_lelang()->first()->jam_mulai }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jam_berakhir" class="col-md-4 col-form-label text-md-end">{{ __('Waktu Berakhir Lelang')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jam_berakhir" type="text" readonly
                                        class="form-control" name="jam_berakhir"
                                        value="{{ $lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? $lelang->lelang_sesi_online()->first()->master_sesi_lelang()->first()->jam_berakhir : $lelang->event_lelang()->first()->jam_selesai }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="inisiasi" class="col-md-4 col-form-label text-md-end">{{ __('Inisiasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="inisiasi" type="text" readonly
                                        class="form-control" name="inisiasi"
                                        value="{{ $lelang->jenis_inisiasi()->first()->nama_inisiasi }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jumlah" class="col-md-4 col-form-label text-md-end">{{ __('Inisiasi Harga Awal')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="jumlah" type="text" readonly
                                            class="form-control thousand-style" name="jumlah"
                                            value="{{ number_format($lelang->harga_awal, 0, ".", ",") }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="harga_deal" class="col-md-4 col-form-label text-md-end">{{ __('Harga Deal')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="harga_deal" type="text" readonly
                                            class="form-control thousand-style  @error('harga_deal') is-invalid @enderror" name="harga_deal"
                                            value="{{ is_null($hargaDeal) ? 0 : $hargaDeal }}" />
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3 justify-content-center">
                                <label for="jumlah_komoditas" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah Komoditas')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jumlah_komoditas" type="text" readonly
                                        class="form-control" name="jumlah_komoditas"
                                        value="{{ $lelang->kuantitas . '( '. $lelang->kontrak()->first()->komoditas()->first()->satuan_ukuran .')' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('operational.lelang.transaksi.update', $lelang->lelang_id) }}" method="POST">@csrf @method('put')
                @if(is_null($approval_lelang))
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Penjual') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Tidak Ada Penjual</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Penjual') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if(is_null($lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()))
                                <div class="row mb-3 justify-content-center">
                                    <label for="nik_penjual" class="col-md-4 col-form-label text-md-end">{{ __('NIK')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nik_penjual" type="text" readonly
                                            class="form-control" name="nik_penjual"
                                            value="{{ (!is_null($lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nik }}" />
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nama_penjual" type="text" readonly
                                            class="form-control" name="nama_penjual"
                                            value="{{ !is_null($lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()) ? $lelang->kontrak()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->kontrak()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" />
                                    </div>
                                </div>
                                @endif

                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_opsi_pembayaran_lelang_id_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Opsi Pembayaran')}}</label>

                                    <div class="col-md-6">
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                        <input id="jenis_opsi_pembayaran_lelang_id_penjual" type="text" readonly
                                            class="form-control" name="jenis_opsi_pembayaran_lelang_id_penjual"
                                            value="{{ $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->jenis_opsi_pembayaran_lelang()->first()->nama_jenis }}" />
                                        @else
                                        <select class="custom-select @error('jenis_opsi_pembayaran_lelang_id_penjual') is-invalid @enderror" @if(count($jenisOpsiPembayaran) == 0) disabled @endif name="jenis_opsi_pembayaran_lelang_id_penjual" id="jenis_opsi_pembayaran_lelang_id_penjual">
                                            @foreach($jenisOpsiPembayaran as $ppl)
                                            <option {{ old('jenis_opsi_pembayaran_lelang_id') == $ppl->jenis_opsi_pembayaran_lelang_id ? 'selected' : '' }} value="{{ $ppl->jenis_opsi_pembayaran_lelang_id }}">{{ $ppl->nama_jenis }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('jenis_opsi_pembayaran_lelang_id_penjual')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="tagihan_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Tagihan Penjual')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="tagihan_penjual" type="text" readonly
                                                class="form-control thousand-style  @error('tagihan_penjual') is-invalid @enderror" name="harga_deal"
                                                value="{{ number_format(($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal, 0, ".", ",") }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="biaya_lain_lain_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Biaya Lain Lain Penjual')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="biaya_lain_lain_penjual" type="text" @if(!is_null($approval_lelang->pembayaran_lelang()->first())) readonly @endif
                                                class="form-control thousand-style  @error('biaya_lain_lain_penjual') is-invalid @enderror" name="biaya_lain_lain_penjual"
                                                value="{{!is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->biaya_lain_lain : '0' }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelesaian_komoditas_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Penyelesaian Komoditas Penjual')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="penyelesaian_komoditas_penjual" type="text" readonly
                                                class="form-control thousand-style  @error('penyelesaian_komoditas_penjual') is-invalid @enderror" name="penyelesaian_komoditas_penjual"
                                                value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? number_format((($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->biaya_lain_lain, 0, ".", ",") : number_format(($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal, 0, ".", ",") }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pembeli') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="nik_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('NIK')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nik_pembeli" type="text" readonly
                                            class="form-control" name="nik_pembeli"
                                            value="{{ is_null($lelang->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? ((!is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nik) : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? ((!is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nik) : ((!is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nik))) }}" />
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nama_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Nama')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nama_pembeli" type="text" readonly
                                            class="form-control" name="nama_pembeli"
                                            value="{{ is_null($lelang->jenis_platform_lelang()->first()) ? '<div class="badge badge-danger">Belum Ada</div>' : ($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? ((!is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama) : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? ((!is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama) : ((!is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first())) ? $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->lembaga()->first()->nama_lembaga : $lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->daftar_peserta_lelang()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama))) }}" />
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_opsi_pembayaran_lelang_id_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Opsi Pembayaran')
                                        }}</label>

                                    <div class="col-md-6">
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                        <input id="jenis_opsi_pembayaran_lelang_id_pembeli" type="text" readonly
                                            class="form-control" name="jenis_opsi_pembayaran_lelang_id_pembeli"
                                            value="{{ $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->jenis_opsi_pembayaran_lelang()->first()->nama_jenis }}" />
                                        @else
                                        <select class="custom-select @error('jenis_opsi_pembayaran_lelang_id_pembeli') is-invalid @enderror" @if(count($jenisOpsiPembayaran) == 0) disabled @endif name="jenis_opsi_pembayaran_lelang_id_pembeli" id="jenis_opsi_pembayaran_lelang_id_pembeli">
                                            @foreach($jenisOpsiPembayaran as $ppl)
                                            <option {{ old('jenis_opsi_pembayaran_lelang_id') == $ppl->jenis_opsi_pembayaran_lelang_id ? 'selected' : '' }} value="{{ $ppl->jenis_opsi_pembayaran_lelang_id }}">{{ $ppl->nama_jenis }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('jenis_opsi_pembayaran_lelang_id_pembeli')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="tagihan_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Tagihan Pembeli')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="tagihan_pembeli" type="text" readonly
                                                class="form-control thousand-style @error('tagihan_pembeli') is-invalid @enderror" name="harga_deal"
                                                value="{{ number_format($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal), 0, ".", ",") }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="biaya_lain_lain_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Biaya Lain Lain Pembeli')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="biaya_lain_lain_pembeli" type="text" @if(!is_null($approval_lelang->pembayaran_lelang()->first())) readonly @endif
                                                class="form-control thousand-style @error('biaya_lain_lain_pembeli') is-invalid @enderror" name="biaya_lain_lain_pembeli"
                                                value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain : '0' }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="penyelesaian_komoditas_pembeli" class="col-md-4 col-form-label text-md-end">{{ __('Penyelesaian Komoditas Pembeli')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="penyelesaian_komoditas_pembeli" type="text" readonly
                                                class="form-control thousand-style  @error('penyelesaian_komoditas_pembeli') is-invalid @enderror" name="penyelesaian_komoditas_pembeli"
                                                value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? number_format(($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain), 0, ".", ",") : number_format($hargaDeal +  (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal), 0, ".", ",") }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Total Harus Dibayar ke Penjual') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="total_dibayar_ke_penjual" class="col-md-4 col-form-label text-md-end">{{ __('Total Dibayar Ke Penjual')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input id="total_dibayar_ke_penjual" type="text" readonly
                                                class="form-control thousand-style  @error('total_dibayar_ke_penjual') is-invalid @enderror" name="total_dibayar_ke_penjual"
                                                value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? number_format(($hargaDeal + (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'buyer')->first()->biaya_lain_lain) - ((($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_penjual / 100) * $hargaDeal) + $approval_lelang->pembayaran_lelang()->first()->opsi_pembayaran_lelang()->where('jenis_informasi_akun', 'seller')->first()->biaya_lain_lain), 0, ".", ",") : number_format($hargaDeal + (($lelang->kontrak()->first()->kontrak_keuangan()->first()->fee_pembeli / 100) * $hargaDeal), 0, ".", ",") }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Proses Settlement') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="kode_penyelesaian" class="col-md-4 col-form-label text-md-end">{{ __('Nomor ID Penyelesaian')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="kode_penyelesaian" type="text" readonly
                                            class="form-control" name="kode_penyelesaian"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $lelang->approval_lelang()->first()->pembayaran_lelang()->first()->nomor_penyelesaian : $kodePenyelesaian }}" />
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal" type="text" readonly
                                            class="form-control" name="tanggal"
                                            value="{{ $tanggal }}" />
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="jatuh_tempo" class="col-md-4 col-form-label text-md-end">{{ __('Jatuh Tempo')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="jatuh_tempo" type="text" readonly
                                            class="form-control" name="jatuh_tempo"
                                            value="{{ $jatuhTempo }}" />
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="status_penyelesaian_id" class="col-md-4 col-form-label text-md-end">{{ __('Status penyelesaian')
                                        }}</label>

                                    <div class="col-md-6">
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                        <input id="status_penyelesaian_id" type="text" readonly
                                            class="form-control" name="status_penyelesaian_id"
                                            value="{{ $approval_lelang->pembayaran_lelang()->first()->status_penyelesaian()->first()->nama_jenis }}" />
                                        @else
                                        <select class="custom-select @error('status_penyelesaian_id') is-invalid @enderror" @if(count($statusPenyelesaian) == 0) disabled @endif name="status_penyelesaian_id" id="status_penyelesaian_id">
                                            @foreach($statusPenyelesaian as $ppl)
                                            <option {{ old('status_penyelesaian_id') == $ppl->status_penyelesaian_id ? 'selected' : '' }} value="{{ $ppl->status_penyelesaian_id }}">{{ $ppl->nama_jenis }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('status_penyelesaian_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea name="keterangan" @if(!is_null($approval_lelang->pembayaran_lelang()->first())) readonly @endif class="form-control " id="keterangan" id="" cols="30" rows="10">{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keterangan : old('keterangan') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Status Proses Penyelesaian') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-title mt-0">Keuangan Masuk</div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_instruksi_keuangan_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_instruksi_keuangan_masuk" type="text" @if(!is_null($approval_lelang->pembayaran_lelang()->first())) readonly @endif
                                            class="form-control" name="nomor_instruksi_keuangan_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->no_instruksi : (is_null(old('nomor_instruksi_keuangan_masuk')) ? $instruksi['keuangan_masuk'] : old('nomor_instruksi_keuangan_masuk')) }}" />

                                            @error('nomor_instruksi_keuangan_masuk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_faktur_keuangan_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Faktur')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_faktur_keuangan_masuk" type="text" readonly
                                            class="form-control" name="nomor_faktur_keuangan_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->no_faktur : $faktur['keuangan_masuk'] }}" />
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_keuangan_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal_keuangan_masuk" type="text" readonly
                                            class="form-control" name="tanggal_keuangan_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->tanggal_instruksi : (is_null(old('tanggal_keuangan_masuk')) ? date('Y-m-d') : old('tanggal_keuangan_masuk')) }}" />

                                        @error('tanggal_keuangan_masuk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_rekening_penyelenggara_keuangan_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening Penyelenggara')
                                        }}</label>

                                    <div class="col-md-6">
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                        <input id="nomor_rekening_penyelenggara_keuangan_masuk" type="text" readonly
                                            class="form-control" name="nomor_rekening_penyelenggara_keuangan_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->rekening_bank()->first()->nama_pemilik . ' - ' . $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->rekening_bank()->first()->nomor_rekening . ' ('. $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->rekening_bank()->first()->mata_uang .' '. $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->rekening_bank()->first()->saldo .')' :'Tidak ada Nomor Rekening' }}" />
                                        @else
                                        <select class="custom-select @error('nomor_rekening_penyelenggara_keuangan_masuk') is-invalid @enderror" @if(count($rekening['penyelenggara']) == 0) disabled @endif name="nomor_rekening_penyelenggara_keuangan_masuk" id="nomor_rekening_penyelenggara_keuangan_masuk">
                                            @foreach($rekening['penyelenggara'] as $ppl)
                                            <option {{ old('nomor_rekening_penyelenggara_keuangan_masuk') == $ppl->rekening_bank_id ? 'selected' : '' }} value="{{ $ppl->rekening_bank_id }}">{{ $ppl->nama_pemilik . ' - ' . $ppl->nomor_rekening . ' ('. $ppl->mata_uang .'  '. $ppl->saldo .')' }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('nomor_rekening_penyelenggara_keuangan_masuk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="status_keuangan_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="status_keuangan_masuk" type="text" readonly
                                            class="form-control" name="status_keuangan_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_masuk()->first()->status : 'Belum Selesai' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="section-title mt-0">Komoditas Masuk</div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_instruksi_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_instruksi_komoditas_masuk" type="text" @if(!is_null($approval_lelang)) readonly @endif
                                            class="form-control" name="nomor_instruksi_komoditas_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->no_instruksi : (is_null(old('nomor_instruksi_komoditas_masuk')) ? $instruksi['komoditas_masuk'] : old('nomor_instruksi_komoditas_masuk')) }}" />

                                            @error('nomor_instruksi_komoditas_masuk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_faktur_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Faktur')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_faktur_komoditas_masuk" type="text" readonly
                                            class="form-control" name="nomor_faktur_komoditas_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->no_faktur : $faktur['komoditas_masuk'] }}" />
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal_komoditas_masuk" type="text" readonly
                                            class="form-control" name="tanggal_komoditas_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->tanggal_instruksi : (is_null(old('tanggal_komoditas_masuk')) ? date('Y-m-d') : old('tanggal_komoditas_masuk')) }}" />
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="status_komoditas_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="status_komoditas_masuk" type="text" readonly
                                            class="form-control" name="status_komoditas_masuk"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status : 'Belum Selesai' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="section-title mt-0">Keuangan Keluar</div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_instruksi_keuangan_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_instruksi_keuangan_keluar" type="text" @if(!is_null($approval_lelang)) readonly @endif
                                            class="form-control" name="nomor_instruksi_keuangan_keluar"
                                            value="{{!is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->no_instruksi : (is_null(old('nomor_instruksi_keuangan_keluar')) ? $instruksi['keuangan_keluar'] : old('nomor_instruksi_keuangan_keluar')) }}" />

                                        @error('nomor_instruksi_keuangan_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_keuangan_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal_keuangan_keluar" type="text" readonly
                                            class="form-control" name="tanggal_keuangan_keluar"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->tanggal_instruksi : (is_null(old('tanggal_keuangan_keluar')) ? date('Y-m-d') : old('tanggal_keuangan_keluar')) }}" />

                                            @error('tanggal_keuangan_keluar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_rekening_penyelenggara_keuangan_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening Penyelenggara')
                                        }}</label>

                                    <div class="col-md-6">
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                        <input id="nomor_rekening_penyelenggara_keuangan_keluar" type="text" readonly
                                            class="form-control" name="nomor_rekening_penyelenggara_keuangan_keluar"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first()->rekening_bank()->first()->nama_pemilik . ' - ' . $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first()->rekening_bank()->first()->nomor_rekening . ' ('. $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first()->rekening_bank()->first()->mata_uang .' '. $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'asal')->first()->rekening_bank()->first()->saldo .')' :'Tidak ada Nomor Rekening' }}" />
                                        @else
                                        <select class="custom-select @error('nomor_rekening_penyelenggara_keuangan_keluar') is-invalid @enderror" @if(count($rekening['penyelenggara']) == 0) disabled @endif name="nomor_rekening_penyelenggara_keuangan_keluar" id="nomor_rekening_penyelenggara_keuangan_keluar">
                                            @foreach($rekening['penyelenggara'] as $ppl)
                                            <option {{ old('nomor_rekening_penyelenggara_keuangan_keluar') == $ppl->rekening_bank_id ? 'selected' : '' }} value="{{ $ppl->rekening_bank_id }}">{{ $ppl->nama_pemilik . ' - ' . $ppl->nomor_rekening . ' ('. $ppl->mata_uang .'  '. $ppl->saldo .')' }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('nomor_rekening_penyelenggara_keuangan_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_rekening_penjual_keuangan_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening Penjual')
                                        }}</label>

                                    <div class="col-md-6">
                                        @if(!is_null($approval_lelang->pembayaran_lelang()->first()))
                                        <input id="nomor_rekening_penjual_keuangan_keluar" type="text" readonly
                                            class="form-control" name="nomor_rekening_penjual_keuangan_keluar"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'tujuan')->first()->rekening_bank()->first()->nama_pemilik . ' - ' . $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'tujuan')->first()->rekening_bank()->first()->nomor_rekening . ' ('. $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'tujuan')->first()->rekening_bank()->first()->mata_uang .' '. $approval_lelang->pembayaran_lelang()->first()->keuangan_keluar()->first()->rekening_keuangan_asal()->where('jenis_rekening', 'tujuan')->first()->rekening_bank()->first()->saldo .')' :'Tidak ada Nomor Rekening' }}" />
                                        @else
                                        <select class="custom-select @error('nomor_rekening_penjual_keuangan_keluar') is-invalid @enderror" @if(count($rekening['penjual']) == 0) disabled @endif name="nomor_rekening_penjual_keuangan_keluar" id="nomor_rekening_penjual_keuangan_keluar">
                                            @foreach($rekening['penjual'] as $ppl)
                                            <option {{ old('nomor_rekening_penjual_keuangan_keluar') == $ppl->rekening_bank_id ? 'selected' : '' }} value="{{ $ppl->rekening_bank_id }}">{{ $ppl->nama_pemilik . ' - ' . $ppl->nomor_rekening . ' ('. $ppl->mata_uang .'  '. $ppl->saldo .')' }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('nomor_rekening_penjual_keuangan_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="status_keuangan_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="status_keuangan_keluar" type="text" readonly
                                            class="form-control" name="status_keuangan_keluar"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_masuk()->first()->status :'Belum Selesai' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="section-title mt-0">Komoditas Keluar</div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="nomor_instruksi_komoditas_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="nomor_instruksi_komoditas_keluar" type="text" @if(!is_null($approval_lelang)) readonly @endif
                                            class="form-control" name="nomor_instruksi_komoditas_keluar"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->no_instruksi : (is_null(old('nomor_instruksi_komoditas_keluar')) ? $instruksi['komoditas_keluar'] : old('nomor_instruksi_komoditas_keluar')) }}" />

                                        @error('nomor_instruksi_komoditas_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="tanggal_komoditas_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="tanggal_komoditas_keluar" type="text" readonly
                                            class="form-control" name="tanggal_komoditas_keluar"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->tanggal_instruksi : (is_null(old('tanggal_komoditas_keluar')) ? date('Y-m-d') : old('tanggal_komoditas_keluar')) }}" />
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label for="status_komoditas_keluar" class="col-md-4 col-form-label text-md-end">{{ __('Status')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="status_komoditas_keluar" type="text" readonly
                                            class="form-control" name="status_komoditas_keluar"
                                            value="{{ !is_null($approval_lelang->pembayaran_lelang()->first()) ? $approval_lelang->pembayaran_lelang()->first()->komoditas_keluar()->first()->status : 'Belum Selesai' }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 d-flex align-items-end">
                                        <a type="button" href="{{ route('operational.lelang.transaksi.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if(!is_null($approval_lelang))
                                        @if(($lelang->jenis_platform_lelang()->first()->online && !$lelang->jenis_platform_lelang()->first()->offline ? (is_null($lelang->peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first()->pembayaran_lelang()->first()) ? true : false) : ($lelang->jenis_platform_lelang()->first()->online && $lelang->jenis_platform_lelang()->first()->offline ? (is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first()->pembayaran_lelang()->first()) ? true : false) : (is_null($lelang->daftar_peserta_lelang_berlangsung()->orderBy('harga_ajuan', 'desc')->first()->approval_lelang()->first()->pembayaran_lelang()->first()) ? true : false) )))
                                        <button type="submit" onclick="return confirm('Data akan di simpan dan tidak dapat diubah kembali! \n Lanjutkan?')" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Simpan</button>
                                        @endif
                                        @endif
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

