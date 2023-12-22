@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang') }}">Gudang</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.gudang.verifikasi.index') }}">Verifikasi</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Gudang</h2>
    <p class="section-lead">
        Detail data Gudang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
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
                                        <input id="tanggal" type="date" readonly
                                            class="form-control" name="tanggal"
                                            value="{{ $registrasi->tanggal }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="transaksi_id" class="col-md-4 col-form-label text-md-end">{{ __('Transaksi Id')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="transaksi_id" type="text" readonly
                                            class="form-control" name="transaksi_id"
                                            value="{{ $registrasi->kode_transaksi }}" />
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row mb-3 justify-content-center">
                                <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="transaksi_id" type="text" readonly
                                        class="form-control" name="transaksi_id"
                                        value="{{ $registrasi->informasi_akun()->first()->member()->first()->ktp()->first()->nama }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="gudang_id" class="col-md-4 col-form-label text-md-end">{{ __('Gudang')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="gudang_id" type="text" readonly
                                        class="form-control" name="gudang_id"
                                        value="{{ $registrasi->gudang()->first()->nama_gudang }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="komoditas_id" class="col-md-4 col-form-label text-md-end">{{ __('Komoditas')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="komoditas_id" type="text" readonly
                                        class="form-control" name="komoditas_id"
                                        value="{{ $registrasi->komoditas()->first()->nama_komoditas }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="mutu_id" class="col-md-4 col-form-label text-md-end">{{ __('Mutu')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="mutu_id" type="text" readonly
                                        class="form-control" name="mutu_id"
                                        value="{{ $registrasi->mutu()->first()->nama_mutu }}" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_instruksi" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Instruksi')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="nomor_instruksi" type="text" readonly
                                            class="form-control" name="nomor_instruksi"
                                            value="{{ $registrasi->no_instruksi }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nomor_bast" class="col-md-4 col-form-label text-md-end">{{ __('Nomor BAST')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="nomor_bast" type="text" readonly
                                            class="form-control" name="nomor_bast"
                                            value="{{ $registrasi->no_bast }}" />
                                    </div>
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
                                        <input id="saldo_belum_teralokasi" type="text" readonly
                                            class="form-control thousand-style" name="saldo_belum_teralokasi"
                                            value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->saldo_belum_teralokasi }}" />
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3 justify-content-center">
                                <label for="kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Kadaluarsa')
                                    }}</label>

                                <div class="col-md-6">
                                        <input id="kadaluarsa" type="date" readonly
                                            class="form-control" name="kadaluarsa"
                                            value="{{ $registrasi->kadaluarsa }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kuantitas" class="col-md-4 col-form-label text-md-end">{{ __('Kuantitas')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input id="kuantitas" type="text" readonly
                                            class="form-control thousand-style  @error('kuantitas') is-invalid @enderror" name="kuantitas"
                                            value="{{ $registrasi->quantity }}" />

                                        <div class="input-group-prepend">
                                            <span class="input-group-text komoditas-satuan-ukuran">{{ $registrasi->komoditas()->first()->satuan_ukuran }}</span>
                                        </div>
                                    </div>
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
                                        <input id="nilai" type="text" readonly
                                            class="form-control thousand-style  @error('nilai') is-invalid @enderror" name="nilai"
                                            value="{{ $registrasi->nilai }}" />
                                    </div>
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
                                        <input id="sisa_alokasi" type="text" readonly
                                            class="form-control thousand-style  @error('sisa_alokasi') is-invalid @enderror" name="sisa_alokasi"
                                            value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->sisa_alokasi_saldo }}" />
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
                                    <input id="jenis_alokasi" type="text" readonly
                                            class="form-control" name="jenis_alokasi"
                                            value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->type_alokasi }}" />
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
                                        <input id="alokasi_collateral" type="text" readonly
                                            class="form-control thousand-style" name="alokasi_collateral"
                                            value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->alokasi_kolateral }}" />
                                    </div>
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
                                        <input id="alokasi_penyelesaian" type="text" readonly
                                            class="form-control thousand-style" name="alokasi_penyelesaian"
                                            value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->alokasi_penyelesaian }}" />
                                    </div>
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
                                            class="form-control thousand-style" readonly name="alokasi_lain"
                                            value="{{ $registrasi->registrasi_komoditas_alokasi()->first()->alokasi_lain }}" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            {{-- End - Keuangan Reg In --}}
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="keterangan" class="form-control" readonly name="keterangan" type="text" cols="30" rows="10">{{ $registrasi->keterangan }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('administrasi.gudang.verifikasi.confirmation', $registrasi->registrasi_komoditas_id) }}" method="post"> @csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Verifikasi') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Aktif')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        @if(is_null($registrasi->verified_log()->first()))
                                        <select class="custom-select @error('confirmation') is-invalid @enderror" {{ !is_null($registrasi->verified_log()->first()) ? 'disabled' : '' }} name="confirmation" id="confirmation">
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
                                            value="{{ $registrasi->verified_log()->first()->is_agree ? 'Verifikasi Diterima' : 'Verifikasi Ditolak' }}" />
                                        @endif 
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan')
                                        }}</label>
    
                                    <div class="col-md-6">
                                        <textarea id="keterangan" {{ !is_null($registrasi->verified_log()->first()) ? 'disabled' : '' }} class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" type="text" cols="30" rows="10">{{ !is_null($registrasi->verified_log()->first()) ? $registrasi->verified_log()->first()->keterangan : '' }}</textarea>
    
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
                                        <a type="button" href="{{ route('administrasi.gudang.verifikasi.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        @if(is_null($registrasi->verified_log()->first()))
                                        <button type="submit" href="{{ route('administrasi.gudang.verifikasi.confirmation', $registrasi->registrasi_komoditas_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Verifikasi</button>
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

