@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Post Meta</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post') }}">Post</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog.post.show', $blogPost->blog_post_id) }}">Detail</a></div>
        <div class="breadcrumb-item">Meta</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Post Meta</h2>
    <p class="section-lead">
        Kelola Post Meta.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Post Meta') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('blog.post.meta.create', $blogPost->blog_post_id) }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-blog-post-meta">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
