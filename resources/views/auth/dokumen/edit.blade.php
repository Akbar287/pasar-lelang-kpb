@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dokumen</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil.dokumen') }}">Dokumen</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil.dokumen.show', $dokumenMember->dokumen_member_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Ubah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Dokumen</h2>
    <p class="section-lead">
        Ubah data Dokumen anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('home.profil.dokumen.update', $dokumenMember->dokumen_member_id) }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Data Dokumen') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="jenis_dokumen_id" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Dokumen')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select class="custom-select @error('jenis_dokumen_id') is-invalid @enderror" name="jenis_dokumen_id" id="jenis_dokumen_id">
                                            @foreach($jenisDokumen as $jd)
                                            <option {{ $dokumenMember->jenis_dokumen_id == $jd->jenis_dokumen_id ? 'selected' : '' }} value="{{ $jd->jenis_dokumen_id }}">{{ $jd->nama_jenis }}</option>
                                            @endforeach
                                        </select>
            
                                        @error('jenis_dokumen_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="file_member" class="col-md-4 col-form-label text-md-end">{{
                                        __('File')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" name="file_member" class="custom-file-input" id="file_member">
                                            <label class="custom-file-label" for="file_member">Pilih File</label>
                                        </div>
            
                                        @error('file_member')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
    
                                        <img src="{{asset('storage/dokumen_member/' . $dokumenMember->nama_file)}}" alt="{{ $dokumenMember->nama_dokumen }}" class="img img-thumbnail img-temporary" style="width: 800px; height: auto"> 
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
                                        <a type="button" href="{{ route('home.profil.dokumen.show', $dokumenMember->dokumen_member_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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


