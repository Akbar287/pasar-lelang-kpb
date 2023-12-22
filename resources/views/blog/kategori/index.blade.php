@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Kategori</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></div>
        <div class="breadcrumb-item">Kategori</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Kategori</h2>
    <p class="section-lead">
        Kelola Kategori.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Kategori') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('blog.kategori.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-blog-kategori">
                            <thead>
                                <tr>
                                    <th>Id Kategori</th>
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
