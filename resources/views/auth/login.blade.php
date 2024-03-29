<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="route" content="{{ 'login' }}" />

    <title>{{ config('app.name', 'Login') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Icon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="{{ asset('/images/e-kpb.png') }}" alt="logo" width="100" class="shadow-light">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>{{ __('Login') }}</h4>
                            </div>

                            <div class="card-body">
                                @if(session('msg')) {!! session('msg') !!} @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">{{ __('username') }}</label>
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" name="username" tabindex="1" autofocus>
                                        @error('username')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">{{ __('Password') }}</label>
                                            @if (Route::has('password.request'))
                                            <div class="float-right">
                                                <a href="{{ route('password.request') }}" class="text-small">
                                                {{ __('Forgot Your Password?') }}
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" autocomplete="current-password">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" id="see_password" type="button"><i class="fas fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                                <div class="row">
                                    @if (Route::has('register'))
                                    <div class="col-12">
                                        <div class="form-group">
                                            Belum Punya Akun? <a href="{{ route('register') }}" class="">
                                                {{ __('Registrasi') }}
                                                </a>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-12 text-center">
                                        <a type="button" class="" href="{{ url('/') }}" tabindex="4">
                                            {{ __('Kembali') }}
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; {{config('app.name', 'e-Lelang KPB')}} {{ now()->year }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
