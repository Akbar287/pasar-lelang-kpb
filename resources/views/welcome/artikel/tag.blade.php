@extends('layouts.app-welcome')

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 col-lg-8">
        <div class="row mb-4">
            <div class="col-3">
                <h6>Pencarian untuk Tag: </h6>
            </div>
            <div class="col-9">
                <div class="badge badge-primary">{{ $blogTag->title }}</div>
            </div>
        </div>
        @if(count($blog) > 0)
        @foreach($blog as $b)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                          <h5 class="card-title">{{ $b->title }}</h5>
                          <p class="card-text">{{ $b->summary }}</p>
                          <a href="{{ route('welcome.artikel.post', $b->blog_post_id) }}" class="btn btn-primary">Baca</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-12">
                {!! $blog->links() !!}
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <p>Tidak ada Berita</p>
            </div>
        </div>
        @endif
    </div>
    <div class="col-12 col-sm-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                  <h5 class="card-title">Login ke Aplikasi</h5>
                  <p class="card-text">Gunakan Username dan Password yang diberikan oleh admin</p>
                  <div class="row">
                    <div class="col-12">
                        <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                        @if (Route::has('register')) <a href="{{ route('register') }}" class="btn btn-info">Register</a> @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
