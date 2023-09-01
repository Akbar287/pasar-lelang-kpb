@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Event Lelang Online</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('online') }}">Lelang Online</a></div>
        <div class="breadcrumb-item">Event Lelang Online</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Event Lelang Online</h2>
    <p class="section-lead">
        Kelola Event Lelang Online.
    </p>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('msg')){!! session('msg') !!} @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Event Lelang Online') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lelang-event">
                            <thead>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <th>Tanggal</th>
                                    <th>Sesi</th>
                                    <th>Produk Lelang</th>
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
