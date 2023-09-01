@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kas Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank') }}">Kas Bank</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.kas_bank.list.index') }}">List</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Kas Bank</h2>
    <p class="section-lead">
        Detail data Kas Bank anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Kas Bank') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_transaksi_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Transaksi')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="jenis_transaksi_id" type="text" readonly
                                        class="form-control" name="jenis_transaksi_id"
                                        value="{{ is_null($keuangan->jenis_transaksi()->first()) ? "Belum ada" : $keuangan->jenis_transaksi()->first()->nama_jenis }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="kurs_mata_uang_id" class="col-md-4 col-form-label text-md-end">{{ __('Kurs Mata Uang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="kurs_mata_uang_id" type="text" readonly
                                        class="form-control" name="kurs_mata_uang_id"
                                        value="{{ $keuangan->kurs_mata_uang()->first()->mata_uang_asal . ' - ' .  $keuangan->kurs_mata_uang()->first()->mata_uang_tujuan }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="member_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="member_id" type="text" readonly
                                        class="form-control" name="member_id"
                                        value="{{ $keuangan->rekening_bank()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" />
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
                                        <input id="jumlah" type="text" readonly
                                            class="form-control thousand-style  @error('jumlah') is-invalid @enderror" name="jumlah"
                                            value="{{ $keuangan->jumlah }}" />
                                    </div>
                                </div>
                            </div>

                            @if($keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank In (Trading)' || $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank In (Non-Trading)')
                            <div class="row mb-3 justify-content-center">
                                <label for="saldo_belum_teralokasi" class="col-md-4 col-form-label text-md-end">{{ __('Saldo Belum Teralokasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="saldo_belum_teralokasi" type="text" readonly
                                            class="form-control thousand-style  @error('saldo_belum_teralokasi') is-invalid @enderror" name="saldo_belum_teralokasi"
                                            value="{{ $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank In (Trading)' ? $keuangan->keuangan_cash_in_trading()->first()->saldo_belum_teralokasi : $keuangan->keuangan_cash_non_trading()->first()->saldo_belum_teralokasi }}" />
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Keuangan Cash In Trading --}}
                            @if($keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank In (Trading)')
                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_instruksi" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="nomor_instruksi" type="text" readonly
                                            class="form-control @error('nomor_instruksi') is-invalid @enderror" name="nomor_instruksi"
                                            value="{{ $keuangan->keuangan_cash_in_trading()->first()->nomor_instruksi }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_alokasi" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Alokasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="jenis_alokasi" type="text" readonly
                                            class="form-control" name="jenis_alokasi"
                                            value="{{ $keuangan->keuangan_cash_in_trading()->first()->jenis_alokasi }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="sisa_alokasi" class="col-md-4 col-form-label text-md-end">{{ __('Sisa Alokasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="sisa_alokasi" type="text" readonly
                                            class="form-control thousand-style  @error('sisa_alokasi') is-invalid @enderror" name="sisa_alokasi"
                                            value="{{ $keuangan->keuangan_cash_in_trading()->first()->sisa_alokasi }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="alokasi_collateral" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Kolateral')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="alokasi_collateral" type="text" readonly
                                            class="form-control thousand-style  @error('alokasi_collateral') is-invalid @enderror" name="alokasi_collateral"
                                            value="{{ $keuangan->keuangan_cash_in_trading()->first()->alokasi_collateral }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="alokasi_penyelesaian" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Penyelesaian')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="alokasi_penyelesaian" type="text" readonly
                                            class="form-control thousand-style  @error('alokasi_penyelesaian') is-invalid @enderror" name="alokasi_penyelesaian"
                                            value="{{ $keuangan->keuangan_cash_in_trading()->first()->alokasi_penyelesaian }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="alokasi_lain" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Lain')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="alokasi_lain" type="text" readonly
                                            class="form-control thousand-style  @error('alokasi_lain') is-invalid @enderror" name="alokasi_lain"
                                            value="{{ $keuangan->keuangan_cash_in_trading()->first()->alokasi_lain }}" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            {{-- End - Keuangan Cash In Trading --}}
                            
                            {{-- Keuangan Cash In Settlement & Pengembalian Collateral --}}
                            @if($keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Settlement)' || $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Pengembalian Collateral)')
                            <div class="row mb-3 justify-content-center">
                                <label for="no_rekening_tujuan_id" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening Admin')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="no_rekening_tujuan_id" type="text" readonly
                                        class="form-control" name="no_rekening_tujuan_id"
                                        value="{{ $keuangan->jenis_transaksi()->first()->nama_jenis == 'Cash / Bank Out (Settlement)' ? $keuangan->keuangan_cash_settlement()->first()->rekening_bank()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama . ' ('.$keuangan->keuangan_cash_settlement()->first()->rekening_bank()->first()->informasi_akun()->first()->member()->first()->informasi_akun()->first()->rekening_bank()->first()->nomor_rekening.')' : $keuangan->keuangan_cash_pengembalian_collateral()->first()->rekening_bank()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama . ' ('.$keuangan->keuangan_cash_pengembalian_collateral()->first()->rekening_bank()->first()->informasi_akun()->first()->member()->first()->informasi_akun()->first()->rekening_bank()->first()->nomor_rekening.')' }}" />
                                    
                                    @error('no_rekening_tujuan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            {{-- End - Keuangan Cash In Settlement & Pengembalian Collateral --}}                          

                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan" readonly class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" type="text" cols="30" rows="10">{{ $keuangan->keterangan }}</textarea>

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

            <form action="{{ route('administrasi.kas_bank.verifikasi.confirmation', $keuangan->keuangan_id) }}" method="post"> @csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Pilihan') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Aktif')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        @if(is_null($keuangan->verified_log()->first()))
                                        <select class="custom-select @error('confirmation') is-invalid @enderror" {{ !is_null($keuangan->verified_log()->first()) ? 'disabled' : '' }} name="confirmation" id="confirmation">
                                            <option value="true">Verifikasi Diterima</option>
                                            <option value="false">Verifikasi Ditolak</option>
                                        </select>
            
                                        @error('confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        @else 
                                        <input id="confirmation" type="text" readonly
                                            class="form-control" name="confirmation"
                                            value="{{ $keuangan->verified_log()->first()->is_agree ? 'Verifikasi Diterima' : 'Verifikasi Ditolak' }}" />
                                        @endif 
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <textarea id="keterangan" {{ !is_null($keuangan->verified_log()->first()) ? 'disabled' : '' }} class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" type="text" cols="30" rows="10">{{ !is_null($keuangan->verified_log()->first()) ? $keuangan->verified_log()->first()->keterangan : '' }}</textarea>
    
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
                                        <a type="button" href="{{ route('administrasi.kas_bank.list.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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

