<!DOCTYPE html>
<html>
    <head>
        <title>Login - {{ $setting->sitename }}</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">    
        <style>
        /*
            these styles will animate bootstrap alerts.
        */
        .alert{
            z-index: 99;
            right:18px;
            min-width:30%;
            position: fixed;
            animation: slide 10.5s forwards;
        }

        @keyframes slide {
            100% { top: 30px; }
        }

        @media screen and (max-width: 668px) {
            .alert{ /* center the alert on small screens */
                left: 10px;
                right: 10px; 
            }
        }
      </style>
    </head>

    <body class="login-page login-1">
        <div id="app" class="login-wrapper">
            <div class="login-box">

                @if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                  </div>
                @endif

                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <strong>Error!</strong>
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
        
                <div class="logo-main">
                    <h2 style="color: #fff">{{ $title }}</h2>
                    <h1 style="color: #fff">{{ $setting->sitename }}</h1>
                </div>
                
                <form method="POST" action="{{ route($loginRoute) }}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter email" required="">

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Enter Password" required="">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="other-actions row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" value="{{ old('remember') ? 'checked' : '' }}">
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <!--@if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route($forgotPasswordRoute) }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif-->
                            <a class="btn btn-link" href="{{ route('register') }}">
                                {{ __('Click here to signup') }}
                            </a>
                        </div>
                    </div>
                    <button class="btn btn-theme btn-full">Login</button>           
                </form>

                <div class="page-copyright">
                   
                    <p>{{ $setting->sitename }} © {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </body>
</html>
{{-- Success Alert --}}
       @if(session('status'))
           <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{session('status')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
       @endif

       {{-- Error Alert --}}
       @if(session('error'))
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
               {{session('error')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
       @endif

       <script>
           //close the alert after 3 seconds.
           $(document).ready(function(){
            setTimeout(function() {
               $(".alert").alert('close');
            }, 40000);
         });
       </script>