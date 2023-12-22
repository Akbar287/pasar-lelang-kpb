@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Post Meta</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post') }}">Post</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post.show', $blogPost->blog_post_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post.meta', $blogPost->blog_post_id) }}">Post Meta</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Post Meta</h2>
    <p class="section-lead">
        Tambahkan data Post Meta anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('blog.post.meta.store', $blogPost->blog_post_id) }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Tambah Post Meta') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="key" class="col-md-4 col-form-label text-md-end">{{ __('Key Meta')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="key" type="text"
                                            class="form-control @error('key') is-invalid @enderror" name="key"
                                            value="{{ old("key") }}"  />
            
                                        @error('key')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Konten')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" cols="30" rows="10">{{ old("content") }}</textarea>
            
                                        @error('content')
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
                                        <a type="button" href="{{ route('blog.post.meta', $blogPost->blog_post_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
