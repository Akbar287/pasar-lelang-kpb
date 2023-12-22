@extends('layouts.app-welcome')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        @if(App\Models\Carousel::where('page', 'Lelang')->count() > 0)
        <div id="carouselWelcome" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach(App\Models\Carousel::where('page', 'Home')->get() as $c)
                <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ asset('storage/carousel/'.$c->image_src ) }}" height="350" alt="{{ $c->title }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $c->title }}</h5>
                        <p>{{ $c->subtitle }}</p>
                    </div>
                </div>
                @endforeach
                @if(App\Models\Carousel::where('page', 'Home')->count() > 1)
                <a class="carousel-control-prev" href="#carouselWelcome" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselWelcome" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
