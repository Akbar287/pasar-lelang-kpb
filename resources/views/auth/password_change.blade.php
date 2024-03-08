@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Ubah Password</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('home.profil') }}">Profil</a></div>
        <div class="breadcrumb-item">Ubah Password</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Ubah Password</h2>
    <p class="section-lead">
        Ubah Password.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('home.profil.password_edit') }}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Ubah Password') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="old_password" class="col-md-4 col-form-label text-md-end">{{ __('Password Lama')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="old_password" type="password" placeholder="Masukan Password Lama" class="form-control @error('old_password') is-invalid @enderror" name="old_password" value="" />

                                            <div class="input-group-append">
                                                <button class="btn btn-primary password" type="button"><i class="fas fa fa-eye"></i></button>
                                            </div>
                                        </div>

                                        @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="new_password" class="col-md-4 col-form-label text-md-end">{{ __('Password Baru')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="new_password" type="password" placeholder="Masukan Password Baru Anda"
                                                class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                                                value="" />

                                            <div class="input-group-append">
                                                <button class="btn btn-primary password" type="button"><i class="fas fa fa-eye"></i></button>
                                            </div>
                                        </div>

                                        @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="confirmation_password" class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi Password Baru')
                                        }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="confirmation_password" type="password" placeholder="Masukan Password Baru Anda" class="form-control @error('confirmation_password') is-invalid @enderror" name="confirmation_password" value="" />

                                            <div class="input-group-append">
                                                <button class="btn btn-primary password" type="button"><i class="fas fa fa-eye"></i></button>
                                            </div>
                                        </div>

                                        @error('confirmation_password')
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
                                        <a type="button" href="{{ route('home.profil') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn btn-success mr-2"><i class="fas fa-pen"></i> Simpan</button>
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
