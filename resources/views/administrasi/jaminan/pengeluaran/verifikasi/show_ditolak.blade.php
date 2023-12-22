@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Pengeluaran Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.pengeluaran.verifikasi.index') }}">Verifikasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.pengeluaran.verifikasi.index_ditolak') }}">Ditolak</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Pengeluaran Jaminan</h2>
    <p class="section-lead">
        Detail data Pengeluaran Jaminan anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
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
                                            class="form-control" name="kode_transaksi"
                                            value="{{ $pengeluaranJaminan->kode_transaksi }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_pengeluaran_jaminan_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Registrasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="jenis_pengeluaran_jaminan_id" type="text" readonly
                                            class="form-control" name="jenis_pengeluaran_jaminan_id"
                                            value="{{ $pengeluaranJaminan->jenis_pengeluaran_jaminan()->first()->nama_jenis }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="informasi_akun_id" type="text" readonly
                                            class="form-control" name="informasi_akun_id"
                                            value="{{ $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama . ' ('. $pengeluaranJaminan->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nik .')' }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                    }}</label>

                                <div class="col-md-6">
                                        <input id="tanggal" type="date" readonly
                                            class="form-control" name="tanggal"
                                            value="{{ $pengeluaranJaminan->tanggal }}" />
                                </div>
                            </div>

                            {{-- Return Cash --}}
                            @if($pengeluaranJaminan->jenis_pengeluaran_jaminan()->first()->nama_jenis == 'Return Cash Collateral')
                            <div class="row mb-3 justify-content-center return-cash">
                                <label for="jumlah_pengembalian" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah Pengembalian')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="jumlah_pengembalian" type="text" readonly
                                            class="form-control thousand-style" name="jumlah_pengembalian"
                                            value="{{ $pengeluaranJaminan->return_cash()->first()->jumlah_pengembalian }}" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            {{-- End Return Cash --}}

                            {{-- Release Commodity Collateral --}}
                            @if($pengeluaranJaminan->jenis_pengeluaran_jaminan()->first()->nama_jenis == 'Release Commodity Collateral')
                            <div class="row mb-3 justify-content-center jaminan_komoditas">
                                <label for="registrasi_jaminan_komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Jaminan Komoditas')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="registrasi_jaminan_komoditas_id" type="text" readonly
                                        class="form-control" name="registrasi_jaminan_komoditas_id"
                                        value="{{ $pengeluaranJaminan->jaminan_komoditas()->first()->registrasi_komoditas_jaminan()->first()->komoditi . ' ('. $pengeluaranJaminan->jaminan_komoditas()->first()->registrasi_komoditas_jaminan()->first()->kuantitas . ' '. $pengeluaranJaminan->jaminan_komoditas()->first()->registrasi_komoditas_jaminan()->first()->unit .')' }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center jaminan_komoditas">
                                <label for="qty_settlement" class="col-md-4 col-form-label text-md-end">{{ __('Kuantitas Penyelesaian')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="qty_settlement" type="text" readonly
                                            class="form-control thousand-style" name="qty_settlement"
                                            value="{{ $pengeluaranJaminan->jaminan_komoditas()->first()->qty_settlement }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center jaminan_komoditas">
                                <label for="alokasi_settlement" class="col-md-4 col-form-label text-md-end">{{ __('Alokasi Settlement')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="alokasi_settlement" type="text" readonly
                                            class="form-control thousand-style" name="alokasi_settlement"
                                            value="{{ $pengeluaranJaminan->jaminan_komoditas()->first()->alokasi_settlement }}" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            {{-- End Release Commodity Collateral --}}

                            {{-- Realease Cash  --}}
                            @if($pengeluaranJaminan->jenis_pengeluaran_jaminan()->first()->nama_jenis == 'Release Cash Collateral')
                            <div class="row mb-3 justify-content-center release-cash">
                                <label for="jumlah" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="jumlah" type="text" readonly
                                            class="form-control thousand-style" name="jumlah"
                                            value="{{ $pengeluaranJaminan->release_cash()->first()->jumlah }}" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            {{-- End Realease Cash  --}}

                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan" readonly class="form-control" name="keterangan" type="text" cols="30" rows="10">{{ $pengeluaranJaminan->keterangan }}</textarea>
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
                                <div class="row mb-3 justify-content-center">
                                    <label for="confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Aktif')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        @if(is_null($pengeluaranJaminan->verified_log()->first()))
                                        <select class="custom-select @error('confirmation') is-invalid @enderror" {{ !is_null($pengeluaranJaminan->verified_log()->first()) ? 'disabled' : '' }} name="confirmation" id="confirmation">
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
                                            value="{{ $pengeluaranJaminan->verified_log()->first()->is_agree ? 'Verifikasi Diterima' : 'Verifikasi Ditolak' }}" />
                                        @endif 
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <textarea id="keterangan" {{ !is_null($pengeluaranJaminan->verified_log()->first()) ? 'disabled' : '' }} class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" type="text" cols="30" rows="10">{{ !is_null($pengeluaranJaminan->verified_log()->first()) ? $pengeluaranJaminan->verified_log()->first()->keterangan : '' }}</textarea>
    
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
                                        <a type="button" href="{{ route('administrasi.jaminan.pengeluaran.verifikasi.index_ditolak') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if(!is_null($pengeluaranJaminan->verified_log()->first()))
                                        <form action="{{ route('administrasi.jaminan.pengeluaran.verifikasi.confirmation_ulang', $pengeluaranJaminan->pengeluaran_jaminan_id) }}" method="post"> @csrf @method('put')
                                            <button type="submit" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Verifikasi Ulang</button>
                                        </form>
                                        @endif
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

