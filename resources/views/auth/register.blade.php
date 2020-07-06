<!DOCTYPE html>
<html>
    <head>
        <title>Register - {{ $setting->sitename }}</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">    
    </head>

    <body class="login-page login-1">
        <div id="app" class="login-wrapper">
            <div class="login-box">
                <div class="logo-main" style="margin-top: 50px">
                    <h2 style="color: #fff">Sign Up</h2>
                    <h1 style="color: #fff">{{ $setting->sitename }}</h1>
                </div>
                
                <div class="pt-3" style="">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter fullname">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Enter email">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="tel" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required placeholder="Enter phone number">

                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Enter password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm password">
                        </div>

                        <div class="other-actions row">
                            
                            <div class="col-6 text-right">
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('Click here to login') }}
                                </a>
                            </div>
                        </div>
                        <button class="btn btn-theme btn-full" type="submit">{{ __('Register') }}</button> 
                    </form>
                </div>
                <div class="page-copyright">
                    <p>{{ $setting->sitename }} © {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </body>
</html>
