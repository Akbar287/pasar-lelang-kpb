@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dokumen</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil.dokumen') }}">Dokumen</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Dokumen</h2>
    <p class="section-lead">
        Detail data Dokumen anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Dokumen') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="jenis_dokumen_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Dokumen')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control" value="{{ $dokumenMember->jenis_dokumen()->first()->nama_jenis }}" name="jenis_dokumen_id" id="jenis_dokumen_id" />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="file_member" class="col-md-4 col-form-label text-md-end">{{
                                    __('File')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <img src="{{ asset('storage/dokumen_member/' . $dokumenMember->nama_file) }}" alt="{{ $dokumenMember->nama_dokumen }}" class="img img-thumbnail img-temporary" style="width: 800px; height: auto"> 
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
                                        <a type="button" href="{{ route('home.profil.dokumen') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <a type="button" href="{{ route('home.profil.dokumen.edit', $dokumenMember->dokumen_member_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                        <form action="{{ route('home.profil.dokumen.destroy', $dokumenMember->dokumen_member_id) }}" method="POST">@csrf @method('delete')
                                            <button type="submit" onclick="return confirm('Dokumen Member akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

