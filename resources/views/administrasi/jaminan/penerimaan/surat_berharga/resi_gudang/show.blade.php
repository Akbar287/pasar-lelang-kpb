@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan Resi Gudang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.index', $detailJaminan->detail_jaminan_id) }}">Resi Gudang</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Penerimaan Jaminan Resi Gudang</h2>
    <p class="section-lead">
        Detail data Penerimaan Jaminan Resi Gudang anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Penerimaan Jaminan Resi Gudang') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis" class="col-md-4 col-form-label text-md-end">{{ __('Jenis')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                        </div>
                                        <input id="jenis" type="text" readonly
                                            class="form-control" name="jenis"
                                            value="{{ $resiGudang->jenis }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="pemilik_barang" class="col-md-4 col-form-label text-md-end">{{ __('Pemilik Barang')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>

                                        <input id="pemilik_barang" type="text" readonly
                                            class="form-control" name="pemilik_barang"
                                            value="{{ $resiGudang->pemilik_barang }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="pemegang_resi_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Pemegang Resi Gudang')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>

                                        <input id="pemegang_resi_gudang" type="text" readonly
                                            class="form-control" name="pemegang_resi_gudang"
                                            value="{{ $resiGudang->pemegang_resi_gudang }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="no_penerbitan" class="col-md-4 col-form-label text-md-end">{{ __('No. Penerbitan')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>

                                        <input id="no_penerbitan" type="text" readonly
                                            class="form-control" name="no_penerbitan"
                                            value="{{ $resiGudang->no_penerbitan }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="nama_resi_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Nama Resi Gudang')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>

                                        <input id="nama_resi_gudang" type="text" readonly
                                            class="form-control" name="nama_resi_gudang"
                                            value="{{ $resiGudang->nama_resi_gudang }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_penerbitan" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Terbit')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input id="tanggal_penerbitan" type="date" readonly
                                            class="form-control" name="tanggal_penerbitan"
                                            value="{{ $resiGudang->tanggal_penerbitan }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="tanggal_jatuh_tempo" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Jatuh Tempo')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input id="tanggal_jatuh_tempo" type="date" readonly
                                            class="form-control" name="tanggal_jatuh_tempo"
                                            value="{{ $resiGudang->tanggal_jatuh_tempo }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nilai_resi_gudang" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Resi Gudang (Nilai Jaminan)')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_resi_gudang" type="text" readonly
                                            class="form-control thousand-style" name="nilai_resi_gudang"
                                            value="{{ $resiGudang->nilai_resi_gudang }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="haircut" class="col-md-4 col-form-label text-md-end">{{ __('Haircut')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="haircut" type="text" readonly
                                            class="form-control thousand-style" name="haircut"
                                            value="{{ $resiGudang->haircut }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nilai_tersedia" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Tersedia (Nilai Penyesuaian)')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_tersedia" type="text" readonly
                                            class="form-control thousand-style" name="nilai_tersedia"
                                            value="{{ $resiGudang->nilai_tersedia }}" />
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.resi_gudang.edit', [$detailJaminan->detail_jaminan_id, $resiGudang->resi_gudang_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('administrasi.jaminan.penerimaan.resi_gudang.destroy', [$detailJaminan->detail_jaminan_id, $resiGudang->resi_gudang_id]) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Penerimaan Jaminan Resi Gudang akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

