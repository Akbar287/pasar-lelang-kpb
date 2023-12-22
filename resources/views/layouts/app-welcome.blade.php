<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="route" content="{{ Route::currentRouteName() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', is_null(App\Models\Aplikasi::first()) ? 'e-Pasar lelang KPB' : App\Models\Aplikasi::first()->nama_aplikasi) }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <title>{{ config('app.name', is_null(App\Models\Aplikasi::first()) ? 'e-Pasar lelang KPB' : App\Models\Aplikasi::first()->nama_aplikasi) }}</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <div class="jumbotron jumbotron-fluid" @if(!is_null(App\Models\Aplikasi::first())) style="background-image:url('{{ asset('storage/header/' . App\Models\Aplikasi::first()->img_welcome) }}');" @endif>
            <div class="container">
              <h1 class="display-4">{{ config('app.name', is_null(App\Models\Aplikasi::first()) ? 'e-Pasar lelang KPB' : App\Models\Aplikasi::first()->nama_aplikasi) }}</h1>
              <p class="lead">{{ is_null(App\Models\Aplikasi::first()) ? 'Header Deskripsi' : App\Models\Aplikasi::first()->header_description }}</p>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 ">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', is_null(App\Models\Aplikasi::first()) ? 'e-Pasar lelang KPB' : App\Models\Aplikasi::first()->nama_aplikasi) }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ Route::currentRouteName() == 'welcome' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'welcome.lelang' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('welcome.lelang') }}">Lelang</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'welcome.artikel' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('welcome.artikel') }}">Artikel</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        @if (Route::has('login')) <a href="{{ route('login') }}" class="mr-2">Login</a> @endif
                        @if (Route::has('register')) <a href="{{ route('register') }}" >Register</a> @endif
                    </span>
                </div>
            </div>
        </nav>

        <div class="container mt-32">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="page-footer font-small pt-4 mt-4" style="background-color: #e9ecef;">
            <div class="container text-center text-md-left">
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                    <h5 class="text-uppercase">{{ config('app.name', is_null(App\Models\Aplikasi::first()) ? 'e-Pasar lelang KPB' : App\Models\Aplikasi::first()->nama_aplikasi) }}</h5>
                    <p>{{ is_null(App\Models\Aplikasi::first()) ? 'Footer Deskripsi' : App\Models\Aplikasi::first()->footer_description }}</p>

                    </div>
                    <hr class="clearfix w-100 d-md-none pb-3">
                    <div class="col-md-3 mb-md-0 mb-3">
                        <h5 class="text-uppercase">Links</h5>
                        <ul class="list-unstyled">
                            <li>
                            <a href="#!">Syarat Ketentuan</a>
                            </li>
                            <li>
                            <a href="#!">Saldo Jaminan</a>
                            </li>
                            <li>
                            <a href="#!">Mitra</a>
                            </li>
                            <li>
                            <a href="#!">Lelang</a>
                            </li>
                        </ul>
                    </div>

                    @if(App\Models\WebLink::count() > 0)
                    <div class="col-md-3 mb-md-0 mb-3">
                        <h5 class="text-uppercase">Web & Aplikasi</h5>
                        <ul class="list-unstyled">
                            @foreach(App\Models\WebLink::get() as $web)
                            <li>
                                <a target="_blank" href="{{ $web->link }}">{{ $web->nama_web }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="footer-copyright text-center py-3">© {{ now()->year }} Copyright {{ config('app.name', is_null(App\Models\Aplikasi::first()) ? 'e-Pasar lelang KPB' : App\Models\Aplikasi::first()->nama_aplikasi) }}
            </div>
        </footer>

        <script>
            $(document).ready(function() {
                let routeName = ($('meta[name=route]')[0].content);
                let csrf = ($('meta[name=csrf-token]')[0].content);
                let kelipatan_harga = parseInt($('#kelipatan_harga').text().replace(',', ''));

                console.log(routeName)

                if(routeName == 'welcome.event_offline_lelang_sesi') {
                    $(function() {
                    setInterval(function() {
                        $.ajax({
                            url: document.location.pathname + '/api',
                            data:{
                                'code': 'getAnyRequest',
                                '_token': csrf,
                                'harga': 0,
                                'peserta': 0,
                                'length': $('div.riwayat_penawaran').length
                            },
                            dataType: 'json',
                            method: 'post',
                            success: function(res) {
                                if(res.done) {
                                    // Selesai
                                    $('#bid_btn').addClass('d-none').removeClass('d-block');
                                    $('#waiting_btn').addClass('d-none').removeClass('d-block');
                                    $('#closed_btn').removeClass('d-none').addClass('d-block');
                                } else {
                                    if(!res.aktif && res.reset) {
                                        $('#bid_btn').addClass('d-none').removeClass('d-block');
                                        $('#waiting_btn').removeClass('d-none').addClass('d-block');
                                        $('#closed_btn').addClass('d-none').removeClass('d-block');
                                    }
                                    if(res.aktif && res.reset) {
                                        $('#bid_btn').removeClass('d-none').addClass('d-block');
                                        $('#waiting_btn').addClass('d-none').removeClass('d-block');
                                        $('#closed_btn').addClass('d-none').removeClass('d-block');
                                    }
                                    if(!res.aktif && !res.reset) {
                                        $('#bid_btn').addClass('d-none').removeClass('d-block');
                                        $('#waiting_btn').removeClass('d-none').addClass('d-block');
                                        $('#closed_btn').addClass('d-none').removeClass('d-block');

                                        if($('.riwayat_penawaran').children().length > 0) {
                                            $('.riwayat_penawaran').children().remove();
                                            $('#show_price').text($('#harga_awal').text());
                                            $('.riwayat_penawaran').append('<p>Belum ada Penawaran</p>');
                                        }
                                    }
                                }

                                var hours = ("0" + Math.floor(res.count / 3600)).slice(-2);
                                var minutes = ("0" + Math.floor((res.count - (hours * 3600)) / 60)).slice(-2);
                                var seconds = ("0" + (res.count - (hours * 3600) - (minutes * 60))).slice(-2);
                                document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;

                                if(res.data.length > 0) {
                                    if(res.aktif) {
                                        $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga))).replaceAll('.', ','));
                                    } else {
                                        $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]))).replaceAll('.', ','));
                                    }
                                    harga_awal = parseInt(res.data[res.data.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga);

                                    $('.riwayat_penawaran').children().remove();
                                    res.data.forEach(x => {
                                        var hours = ("0" + Math.floor(x.waktu / 3600)).slice(-2);
                                        var minutes = ("0" + Math.floor((x.waktu - (hours * 3600)) / 60)).slice(-2);
                                        var seconds = ("0" + (x.waktu - (hours * 3600) - (minutes * 60))).slice(-2);

                                            if($('div.riwayat_penawaran').children('p').length == 1) {
                                                $('.riwayat_penawaran').children('p').remove();
                                                $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                            } else {
                                                if($('div.riwayat_penawaran').children('ul').length == 0) {
                                                    $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                                } else {
                                                    $('.riwayat_penawaran').children('ul.list-group').prepend('<li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li>');
                                                }
                                            }
                                    });
                                }
                            }, error: function(err) {
                                console.error(err);
                            }
                        });
                    }, 1000);
                });
                }

                if(routeName == 'welcome.online_lelang_sesi') {
                    $(function() {
                        setInterval(function() {
                            $.ajax({
                                url: document.location.pathname + '/api',
                                data:{
                                    'code': 'getAnyRequest',
                                    '_token': csrf,
                                    'peserta': 0
                                },
                                dataType: 'json',
                                method: 'post',
                                success: function(res) {
                                    if(res.data.done) {
                                        // Selesai
                                        $('.bid_btn').addClass('d-none').removeClass('d-block');
                                        $('.waiting_btn').addClass('d-none').removeClass('d-block');
                                        $('.closed_btn').removeClass('d-none').addClass('d-block');
                                    } else {
                                        if(!res.data.aktif) {
                                            // Belum Mulai
                                            $('.closed_btn').addClass('d-none').removeClass('d-block');
                                            $('.bid_btn').addClass('d-none').removeClass('d-block');
                                            $('.waiting_btn').removeClass('d-none').addClass('d-block');
                                        } else {
                                            // Aktif
                                            $('.waiting_btn').addClass('d-none').removeClass('d-block');
                                            $('.closed_btn').addClass('d-none').removeClass('d-block');
                                            $('.bid_btn').removeClass('d-none').addClass('d-block');
                                        }
                                    }

                                    var hours = ("0" + Math.floor(res.data.count / 3600)).slice(-2);
                                    var minutes = ("0" + Math.floor((res.data.count - (hours * 3600)) / 60)).slice(-2);
                                    var seconds = ("0" + (res.data.count - (hours * 3600) - (minutes * 60))).slice(-2);
                                    document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;

                                    if(res.data.riwayat.length > 0) {
                                        if(res.data.aktif) {
                                            $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data.riwayat[res.data.riwayat.length - 1].harga_ajuan.split('.')[0]) + parseInt(kelipatan_harga))).replaceAll('.', ','));
                                        } else {
                                            $('#show_price').text((Intl.NumberFormat().format(parseInt(res.data.riwayat[res.data.riwayat.length - 1].harga_ajuan.split('.')[0]))).replaceAll('.', ','));
                                        }

                                        $('.riwayat_penawaran').children().remove();
                                        res.data.riwayat.forEach(x => {
                                            var hours = ("0" + Math.floor(x.waktu / 3600)).slice(-2);
                                            var minutes = ("0" + Math.floor((x.waktu - (hours * 3600)) / 60)).slice(-2);
                                            var seconds = ("0" + (x.waktu - (hours * 3600) - (minutes * 60))).slice(-2);

                                                if($('div.riwayat_penawaran').children('p').length == 1) {
                                                    $('.riwayat_penawaran').children('p').remove();
                                                    $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                                } else {
                                                    if($('div.riwayat_penawaran').children('ul').length == 0) {
                                                        $('.riwayat_penawaran').append('<ul class="list-group"><li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li></ul>');
                                                    } else {
                                                        $('.riwayat_penawaran').children('ul.list-group').prepend('<li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge badge-primary badge-pill">' + x.kode_peserta_lelang + '</span> <div>' + hours + ":" + minutes + ":" + seconds + '</div> Rp. ' + (Intl.NumberFormat().format(x.harga_ajuan)).replaceAll('.', ',') + '</li>');
                                                    }
                                                }
                                        });
                                    }
                                }, error: function(err) {
                                    console.error(err);
                                }
                            });
                        }, 1000);
                    });
                }
            })
        </script>
    </body>
</html>
