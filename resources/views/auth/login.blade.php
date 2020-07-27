@extends('auth.layout')

@push('css')
    <style>
        .box {
            margin-top: 40px;

            font-family: "Rubik", sans-serif;

            background: white;

            border-radius: 5px;
            border: 1px rgba(128, 128, 128, 0.29) solid;
        }

        .box-sidebar {
            background: #564f64;
            width: 70px;

            color: white;

            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center align-items-center d-flex">
        <div class="col-xs-12 col-12 col-md-4">
            <div class="box d-flex">

                <div class="box-sidebar p-2 text-center">
                    <img src="{{asset('img/logo_monkey_planner_88px.png')}}"
                         width="80%">
                </div>

                <div class="card-body text-center">
                    <form method="POST"
                          action="{{ route('login') }}">
                        @csrf

                        <img src="{{asset('img/logo_monkey_planner_88px.png')}}">
                        <h5>Monkey planner</h5>

                        <div class="form-group row mt-5">
                            <label for="email"
                                   class="col-sm-4 col-form-label text-md-right">{{ __('E-mailová adresa') }}</label>

                            <div class="col-md-6">
                                <input id="email"
                                       type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback"
                                          role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Heslo') }}</label>

                            <div class="col-md-6">
                                <input id="password"
                                       type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback"
                                          role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label"
                                           for="remember">
                                        {{ __('Uložit přihlášení') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit"
                                        class="btn btn-primary">
                                    {{ __('Přihlásit se') }}
                                </button>

                                {{--                                        <a class="btn btn-link"--}}
                                {{--                                           href="{{ route('password.request') }}">--}}
                                {{--                                            {{ __('Zapomněli jste heslo?') }}--}}
                                {{--                                        </a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
