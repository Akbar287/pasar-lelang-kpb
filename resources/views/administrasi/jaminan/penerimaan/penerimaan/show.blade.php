@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Penerimaan Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Penerimaan Jaminan</h2>
    <p class="section-lead">
        Detail data Penerimaan Jaminan anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Penerimaan Jaminan') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="informasi_akun_id" class="col-md-4 col-form-label text-md-end">{{ __('Anggota')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="informasi_akun_id" type="text" readonly
                                        class="form-control" name="informasi_akun_id"
                                        value="{{ $detailJaminan->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nama . ' ('. $detailJaminan->jaminan()->first()->informasi_akun()->first()->member()->first()->ktp()->first()->nik .')' }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center reg-in">
                                <label for="tanggal" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                                        </div>
                                        <input id="tanggal" type="date" readonly
                                            class="form-control" name="tanggal"
                                            value="{{ is_null($detailJaminan->tanggal_transaksi) ? date('Y-m-d') : $detailJaminan->tanggal_transaksi }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center reg-in">
                                <label for="total_saldo_jaminan" class="col-md-4 col-form-label text-md-end">{{ __('Total Saldo Jaminan')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="total_saldo_jaminan" type="text" readonly
                                            class="form-control thousand-style" name="total_saldo_jaminan"
                                            value="{{ $detailJaminan->jaminan()->first()->total_saldo_jaminan }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center reg-in">
                                <label for="saldo_teralokasi" class="col-md-4 col-form-label text-md-end">{{ __('Saldo Teralokasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="saldo_teralokasi" type="text" readonly
                                            class="form-control thousand-style" name="saldo_teralokasi"
                                            value="{{ $detailJaminan->jaminan()->first()->saldo_teralokasi }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center reg-in">
                                <label for="saldo_tersedia" class="col-md-4 col-form-label text-md-end">{{ __('Saldo Tersedia')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="saldo_tersedia" type="text" readonly
                                            class="form-control thousand-style" name="saldo_tersedia"
                                            value="{{ $detailJaminan->jaminan()->first()->saldo_tersedia }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center reg-in">
                                <label for="nilai_jaminan" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Jaminan')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_jaminan" type="text" readonly
                                            class="form-control thousand-style" name="nilai_jaminan"
                                            value="{{ $detailJaminan->nilai_jaminan }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center reg-in">
                                <label for="nilai_penyesuaian" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Penyesuaian')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_penyesuaian" type="text" readonly
                                            class="form-control thousand-style" name="nilai_penyesuaian"
                                            value="{{ $detailJaminan->nilai_penyesuaian }}" />
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
                                    <div class="col-md-12 d-flex align-items-end justify-content-center">
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.kas.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-info mr-2"><i class="fas fa-dollar-sign"></i> Kas</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.komoditas.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-warning mr-2"><i class="fas fa-box"></i> Komoditas</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.deposito.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-file"></i> Deposito</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.obligasi.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-info mr-2"><i class="fas fa-file"></i> Obligasi</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.saham.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-warning mr-2"><i class="fas fa-file"></i> Saham</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-file"></i> Resi Gudang</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.edit', $detailJaminan->detail_jaminan_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('administrasi.jaminan.penerimaan.destroy', $detailJaminan->detail_jaminan_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Penerimaan Jaminan akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

