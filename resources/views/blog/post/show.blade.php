@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Post</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post') }}">Post</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Post</h2>
    <p class="section-lead">
        Detail data Post anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Ubah Post') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="admin" class="col-md-4 col-form-label text-md-end">{{ __('Admin')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="admin" type="text" readonly
                                        class="form-control" name="admin"
                                        value="{{ $blogPost->admin()->first()->member()->first()->ktp()->first()->nama }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="kategori" class="col-md-4 col-form-label text-md-end">{{ __('Kategori')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="kategori" type="text" readonly
                                        class="form-control" name="kategori"
                                        value="{{ $blogPost->blog_kategori()->first()->title }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="tag" class="col-md-4 col-form-label text-md-end">{{ __('Tag')
                                    }}</label>
        
                                <div class="col-md-6">
                                    @php $temp = []; @endphp @foreach($blogPost->blog_tag()->get() as $bt) @php $temp[] = $bt->title; @endphp @endforeach
                                    <input id="tag" type="text" readonly
                                        class="form-control" name="tag"
                                        value="{{ join(', ', $temp) }}" />
        
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
                                    <input id="title" type="text" readonly
                                        class="form-control" name="title"
                                        value="{{ $blogPost->title }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="slug" class="col-md-4 col-form-label text-md-end">{{ __('Slug')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="slug" type="text" readonly
                                        class="form-control" name="slug"
                                        value="{{ $blogPost->slug }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="summary" class="col-md-4 col-form-label text-md-end">{{ __('Ringkasan')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="summary" readonly type="text" class="form-control" name="summary" cols="30" rows="10">{{ $blogPost->summary }}</textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Konten')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="content" readonly type="text" class="form-control" name="content" cols="30" rows="10">{{ $blogPost->content }}</textarea>
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
                                <div class="col-md-12 text-center d-flex align-items-end">
                                    <a type="button" href="{{ route('blog.post') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('blog.post.edit', $blogPost->blog_post_id) }}" class="btn mr-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <a type="button" href="{{ route('blog.post.meta', $blogPost->blog_post_id) }}" class="btn mr-2 btn-warning"><i class="fas fa-tags"></i> Meta Tag</a>
                                    <form action="{{ route('blog.post.publish', $blogPost->blog_post_id) }}" method="POST">@csrf @method('put')
                                        @if(is_null($blogPost->published) || $blogPost->published == false)
                                        <input type="hidden" name="jenis" value="publish">
                                        <button type="submit" onclick="return confirm('Post Blog akan dipublish!\n Lanjutkan?')" title="Publish Data" class="btn btn-info"><i class="fas fa-check"></i> Publish</button>
                                        @else 
                                        <input type="hidden" name="jenis" value="unpublish">
                                        <button type="submit" onclick="return confirm('Post Blog akan ditarik dari Publikasi!\n Lanjutkan?')" title="Tarik Publikasi Data" class="btn btn-info"><i class="fas fa-times"></i> Tarik Publikasi</button>
                                        @endif
                                    </form>
                                    <form action="{{ route('blog.post.destroy', $blogPost->blog_post_id) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Post Blog akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn ml-2 btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

