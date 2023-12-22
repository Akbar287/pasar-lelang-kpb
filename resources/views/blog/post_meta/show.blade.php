@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Post Meta</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post') }}">Post</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post.show', $blogPost->blog_post_id) }}">Detail</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post.meta', $blogPost->blog_post_id) }}">Post Meta</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Post Meta</h2>
    <p class="section-lead">
        Detail data Post Meta anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Ubah Post Meta') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="key" class="col-md-4 col-form-label text-md-end">{{ __('Key Meta')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="key" type="text" readonly
                                        class="form-control" name="key"
                                        value="{{ $blogPostMeta->key }}"  />
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Konten')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="content" type="text" readonly class="form-control" name="content" cols="30" rows="10">{{ $blogPostMeta->content }}</textarea>
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
                                    <a type="button" href="{{ route('blog.post.meta', $blogPost->blog_post_id) }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('blog.post.meta.edit', [$blogPost->blog_post_id, $blogPostMeta->blog_post_meta_id]) }}" class="btn mr-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('blog.post.meta.destroy', [$blogPost->blog_post_id, $blogPostMeta->blog_post_meta_id]) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Meta Post Blog akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn ml-2 btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

