@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Tag</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item">Tag</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Tag</h2>
    <p class="section-lead">
        Kelola Tag.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Tag') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('blog.tag.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-blog-tag">
                            <thead>
                                <tr>
                                    <th>Id Tag</th>
                                    <th>Judul</th>
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
