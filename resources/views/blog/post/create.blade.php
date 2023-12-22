@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Post</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post') }}">Post</a></div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tambah Post</h2>
    <p class="section-lead">
        Tambahkan data Post anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
            <form action="{{ route('blog.post.store') }}" method="post" enctype="multipart/form-data">@csrf 
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Tambah Post') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3 justify-content-center">
                                    <label for="admin" class="col-md-4 col-form-label text-md-end">{{ __('Admin')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select id="admin" @if(count($admin) == 0) disabled @endif type="text" class="form-control @error('admin') is-invalid @enderror" name="admin">
                                            @if(count($admin) > 0)
                                            @foreach($admin as $k)
                                            <option {{ old('admin') == $k->admin_id ? 'selected' : '' }} value="{{ $k->admin_id }}">{{ $k->member()->first()->ktp()->first()->nama }}</option>
                                            @endforeach
                                            @else 
                                            <option value="0">Tidak ada Admin</option>
                                            @endif
                                        </select>
            
                                        @error('admin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="kategori" class="col-md-4 col-form-label text-md-end">{{ __('Kategori')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select id="kategori" @if(count($kategori) == 0) disabled @endif type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori">
                                            @if(count($kategori) > 0)
                                            @foreach($kategori as $k)
                                            <option {{ old('kategori') == $k->blog_kategori_id ? 'selected' : '' }} value="{{ $k->blog_kategori_id }}">{{ $k->title }}</option>
                                            @endforeach
                                            @else 
                                            <option value="0">Tidak ada Kategori</option>
                                            @endif
                                        </select>
            
                                        @error('kategori')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="tag" class="col-md-4 col-form-label text-md-end">{{ __('Tag')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <select id="tag" @if(count($tag) == 0) disabled @endif type="text" class="form-control @error('tag') is-invalid @enderror" name="tag[]">
                                            @if(count($tag) > 0)
                                            @foreach($tag as $k)
                                            <option value="{{ $k->blog_tag_id }}">{{ $k->title }}</option>
                                            @endforeach
                                            @else 
                                            <option value="0">Tidak ada Tag</option>
                                            @endif
                                        </select>
            
                                        @error('tag')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                               
                                <div class="row mb-3 justify-content-center">
                                    <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Judul')
                                        }}</label>
            
                                    <div class="col-md-6">
                                        <input id="title" type="text"
                                            class="form-control @error('title') is-invalid @enderror" name="title"
                                            value="{{ old("title") }}"  />
            
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="slug" class="col-md-4 col-form-label text-md-end">{{ __('Slug')
                                        }}</label>

                                    <div class="col-md-6">
                                        <input id="slug" type="text" readonly
                                            class="form-control @error('slug') is-invalid @enderror" name="slug"
                                            value="{{ old("slug") }}"  />
            
                                        @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3 justify-content-center">
                                    <label for="summary" class="col-md-4 col-form-label text-md-end">{{ __('Ringkasan')
                                        }}</label>

                                    <div class="col-md-6">
                                        <textarea placeholder="Berisi 1 Paragraf dan tidak terlalu banyak untuk summary" id="summary" type="text" class="form-control @error('summary') is-invalid @enderror" name="summary" cols="30" rows="10">{{ old("summary") }}</textarea>
            
                                        @error('summary')
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
                                        <textarea placeholder="Berisi seluruh artikel dengan tidak dibatasinya banyaknya kata" id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" cols="30" rows="10">{{ old("content") }}</textarea>
            
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
                                        <a type="button" href="{{ route('blog.post') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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
