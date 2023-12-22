@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Penerimaan Jaminan Deposito</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi') }}">Administrasi</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan') }}">Jaminan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.index') }}">Penerimaan</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.show', $detailJaminan->detail_jaminan_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('administrasi.jaminan.penerimaan.saham.index', $detailJaminan->detail_jaminan_id) }}">Deposito</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Penerimaan Jaminan Deposito</h2>
    <p class="section-lead">
        Detail data Penerimaan Jaminan Deposito anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Penerimaan Jaminan Deposito') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="kode_saham" class="col-md-4 col-form-label text-md-end">{{ __('Kode Saham')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input id="kode_saham" type="text" readonly
                                            class="form-control" name="kode_saham"
                                            value="{{ $saham->kode_saham }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="penerbit" class="col-md-4 col-form-label text-md-end">{{ __('Penerbit')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>

                                        <input id="penerbit" type="text" readonly
                                            class="form-control" name="penerbit"
                                            value="{{ $saham->penerbit }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="harga_saham" class="col-md-4 col-form-label text-md-end">{{ __('Harga Saham')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="harga_saham" type="text" readonly
                                            class="form-control thousand-style" name="harga_saham"
                                            value="{{ $saham->harga_saham }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="lot" class="col-md-4 col-form-label text-md-end">{{ __('Lot')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                        </div>
                                        <input id="lot" type="text" readonly
                                            class="form-control thousand-style" name="lot"
                                            value="{{ $saham->lot }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="nilai_saham" class="col-md-4 col-form-label text-md-end">{{ __('Nilai Saham (Nilai Jaminan)')
                                    }}</label>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input id="nilai_saham" type="text" readonly
                                            class="form-control thousand-style" name="nilai_saham"
                                            value="{{ $saham->nilai_saham }}" />
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
                                            value="{{ $saham->haircut }}" />
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
                                            value="{{ $saham->nilai_tersedia }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="lokasi" class="col-md-4 col-form-label text-md-end">{{ __('lokasi')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="lokasi" class="form-control" readonly name="lokasi" type="text" cols="30" rows="10">{{ $saham->lokasi }}</textarea>
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
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.saham.index', $detailJaminan->detail_jaminan_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('administrasi.jaminan.penerimaan.saham.edit', [$detailJaminan->detail_jaminan_id, $saham->saham_id]) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('administrasi.jaminan.penerimaan.saham.destroy', [$detailJaminan->detail_jaminan_id, $saham->saham_id]) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Data Penerimaan Jaminan Saham akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

