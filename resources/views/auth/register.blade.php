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
                                <h4>{{ __('Register') }}</h4>
                            </div>

                            <div class="card-body">
                                @if(session('msg')) {!! session('msg') !!} @endif
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="ktp">{{ __('Ktp') }}</label>
                                        <input id="ktp" type="text" class="form-control @error('ktp') is-invalid @enderror" value="{{ old('ktp') }}" name="ktp">
                                        @error('ktp')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">{{ __('Nama') }}</label>
                                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" name="nama">
                                        @error('nama')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{ __('E-mail') }}</label>
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email">
                                        @error('email')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="no_hp">{{ __('No. HP') }}</label>
                                        <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" name="no_hp">
                                        @error('no_hp')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tempat_lahir">{{ __('Tempat Lahir') }}</label>
                                        <input id="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" name="tempat_lahir">
                                        @error('tempat_lahir')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_lahir">{{ __('Tanggal Lahir') }}</label>
                                        <input id="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ is_null(old('tanggal_lahir')) ? date('Y-m-d') : old('tanggal_lahir') }}" name="tanggal_lahir">
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_kelamin">{{ __('Jenis Kelamin') }}</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="custom-select @error('jenis_kelamin') is-invalid @enderror">
                                            <option {{ old('jenis_kelamin') == 'pria' ? 'selected' : '' }} value="pria">Pria</option>
                                            <option {{ old('jenis_kelamin') == 'wanita' ? 'selected' : '' }} value="wanita">Wanita</option>
                                        </select>
                                        @error('jenis_kelamin')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="username">{{ __('Username') }}</label>
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
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password_confirmation" class="control-label">{{ __('Konfirmasi Password') }}</label>
                                        </div>

                                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" tabindex="2" autocomplete="current-password_confirmation">

                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </form>
                                <div class="row">
                                    @if (Route::has('login'))
                                    <div class="col-12">
                                        <div class="form-group">
                                            Sudah Punya Akun? <a href="{{ route('login') }}" class="">
                                                {{ __('Login') }}
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
