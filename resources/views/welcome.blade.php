<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'e-Lelang KPB') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <title>{{ config('app.name', 'Monitoring SPBU') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    </head>
    <body class="antialiased">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">{{ config('app.name', 'e-Lelang KPB') }}</h1>
              <p class="lead">Disini untuk Portal Pemberitahuan / Pengumuman.</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-8 order-2 order-md-2 order-lg-1">
                    <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Judul Pemberitahuan</h5>
                          <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt iure consequatur laboriosam esse odit, libero tenetur, fugit sequi doloribus aut veritatis repellat neque rem! Laboriosam possimus alias incidunt maxime exercitationem?</p>
                          <a href="#" class="btn btn-primary">Baca</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-4 order-1 order-md-1 order-lg-2">
                    <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Login ke Aplikasi</h5>
                          <p class="card-text">Gunakan Username dan Password yang diberikan oleh admin</p>
                          <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </body>
</html>
