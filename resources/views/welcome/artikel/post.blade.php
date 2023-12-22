@extends('layouts.app-welcome')

@section('content')
<div class="row my-5">
    <div class="col-12">
        <a href="{{ route('welcome.artikel') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8">
        <h1>{{ $post->title }}</h1>
        <p>Dipublish pada {{ $post->published_at }} disunting <a href="{{ route('welcome.artikel.user', $post->admin_id) }}">{{ $post->admin()->first()->member()->first()->ktp()->first()->nama }}</a></p>
        <p>{{ $post->content }}</p>

         <div class="row">
            <div class="col-12">
                @foreach($post->blog_tag()->get() as $t)
                <a href="{{ route('welcome.artikel.tag', $t->blog_tag_id) }}" class="badge badge-primary">{{ $t->title }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <h4>Post Terbaru</h4>
        @if(count($blog) > 0)
        @foreach($blog as $b)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $b->title }}</h5>
                <p class="card-text">{{ $b->content }}</p>
                <a href="{{ route('welcome.artikel.post', $b->blog_post_id) }}" class="btn btn-primary">Baca</a>
            </div>
        </div>
        @endforeach
        @else
        <p>Tidak Ada Post Terbaru</p>
        @endif
    </div>
</div>
@endsection
