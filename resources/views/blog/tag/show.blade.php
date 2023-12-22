@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Tag</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.tag') }}">Tag</a></div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Detail Tag</h2>
    <p class="section-lead">
        Detail data Tag anda.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Ubah Tag') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3 justify-content-center">
                                <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Judul')
                                    }}</label>
        
                                <div class="col-md-6">
                                    <input id="title" type="text" readonly
                                        class="form-control" name="title"
                                        value="{{ $blogTag->title }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="slug" class="col-md-4 col-form-label text-md-end">{{ __('Slug')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="slug" type="text" readonly
                                        class="form-control" name="slug"
                                        value="{{ $blogTag->slug }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-3 justify-content-center">
                                <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Konten')
                                    }}</label>

                                <div class="col-md-6">
                                    <textarea id="content" readonly type="text" class="form-control" name="content" cols="30" rows="10">{{ $blogTag->content }}</textarea>
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
                                    <a type="button" href="{{ route('blog.tag') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a type="button" href="{{ route('blog.tag.edit', $blogTag->blog_tag_id) }}" class="btn mx-2 btn-success"><i class="fas fa-pen"></i> Ubah</a>
                                    <form action="{{ route('blog.tag.destroy', $blogTag->blog_tag_id) }}" method="POST">@csrf @method('delete')
                                        <button type="submit" onclick="return confirm('Tag Blog akan dihapus!\n Lanjutkan?')" title="Hapus Data" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
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

