@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
@endif

@section('auth_header')
    <br>
    <div class="">
        <div class="row">
            <div class="col-sm-2 ">

            </div>
            <div class="col-sm-4 text-center ">
                <img src="{{asset('storage/imporcomexImage/logo-dany-travel.png')}}" width="90" alt="">
            </div>
            <div class="col-sm-4  text-center">
                <img src="{{asset('storage/imporcomexImage/logo_academia.png')}}" width="115" alt="">
            </div>
            <div class="col-sm-2  ">

            </div>
        </div>
    </div>
@stop


@section('auth_body')

    <form action="{{ route('register') }}" method="post">
        @csrf

        {{-- Name field --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Nombre Completo" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>El nombre es requerido</strong>
                </span>
            @enderror
        </div>

        {{-- telefono --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="number" name="telefono"
                class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}"
                placeholder="Teléfono" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </div>

        {{-- Fecha --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                value="{{ old('date') }}" placeholder="Fecha de Nacimiento" autofocus>


            @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>La fecha es requerida</strong>
                </span>
            @enderror
        </div>

        {{-- Importacion --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="text" name="importacion"
                class="form-control @error('importacion') is-invalid @enderror" value="{{ old('importacion') }}"
                placeholder="Importaciones realizas en 1 año" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-hashtag {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('importacion')
                <span class="invalid-feedback" role="alert">
                    <strong>La importación es requerida</strong>
                </span>
            @enderror
        </div>
        
        {{-- Idioma --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="text" name="idioma" id="autocomplete"
                class="form-control @error('idioma') is-invalid @enderror" value="{{ old('idioma') }}" placeholder="Idioma"
                autofocus>
            

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-language {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('idioma')
                <span class="invalid-feedback" role="alert">
                    <strong>El idioma es requerido</strong>
                </span>
            @enderror
        </div>

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="email" name="email"
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                placeholder="Correo electrónico">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>El email es requerido</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>La contraseña es requerida</strong>
                </span>
            @enderror
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input autocomplete="off" type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Vuelva a escribir la contraseña">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>La contraseña no coincide</strong>
                </span>
            @enderror
        </div>

        {{-- Register button --}}
        <button style="background-color:#DB2311" type="submit"
            class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-danger') }}">
            <span class="fas fa-user-plus"></span>
            REGISTRAR
        </button>

    </form>

    <script>
        $("#autocomplete").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.idioma') }}",
                    dataType: 'json',
                    data: {
                        temp: request.temp
                    },
                    success: function(data) {
                        response(data)
                    }
                });
            }
        });
    </script>

@stop

@section('auth_footer')
    <div class="text-center">
        <p class="my-0">
            <a href="{{ $login_url }}">
                ¿Ya tienes cuenta?
            </a>
        </p>
    </div>
@stop
