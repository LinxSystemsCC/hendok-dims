{{-- <!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dims</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fonts.css') }}" rel="stylesheet"  type='text/css'>

        <!-- Styles -->
        <style>
            html, body {
                color: #ffffff;
                font-family: 'Raleway', sans-serif;
                font-weight: 700;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                width: 100% !important;
            }

            .links, a {
                color: #ffffff;
                padding: 0 25px;
                font-size: 15px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            body {
                margin: auto;
                font-family: -apple-system, BlinkMacSystemFont, sans-serif;
                overflow: auto;
                background: linear-gradient(315deg, rgb(0, 9, 124) 3%, rgb(18, 102, 187) 38%, rgb(16, 228, 178) 68%, rgb(25, 75, 255) 98%);
                animation: gradient 15s ease infinite;
                background-size: 400% 400%;
                background-attachment: fixed;
            }

            @keyframes gradient {
                0% {
                    background-position: 0% 0%;
                }
                50% {
                    background-position: 100% 100%;
                }
                100% {
                    background-position: 0% 0%;
                }
            }

            .wave {
                background: rgb(255 255 255 / 25%);
                border-radius: 1000% 1000% 0 0;
                position: fixed;
                width: 200%;
                height: 12em;
                animation: wave 10s -3s linear infinite;
                transform: translate3d(0, 0, 0);
                opacity: 0.8;
                bottom: 0;
                left: 0;
                z-index: -1;
            }

            .wave:nth-of-type(2) {
                bottom: -1.25em;
                animation: wave 18s linear reverse infinite;
                opacity: 0.8;
            }

            .wave:nth-of-type(3) {
                bottom: -2.5em;
                animation: wave 20s -1s reverse infinite;
                opacity: 0.9;
            }

            @keyframes wave {
                2% {
                    transform: translateX(1);
                }

                25% {
                    transform: translateX(-25%);
                }

                50% {
                    transform: translateX(-50%);
                }

                75% {
                    transform: translateX(-25%);
                }

                100% {
                    transform: translateX(1);
                }
            }

            .header{
                font-size: 80px;
            }
        </style>
    </head>

    <body>

        <div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">HOME</a>
                    @else
                        <a href="{{ url('/login') }}">LOGIN</a>
                        <a href="{{ url('/register') }}">REGISTER</a>
                    @endif
                </div>
            @endif

            <div class="content">
                @if (Auth::check())
                    <img src="public/images/dimslogo.png" style="height: 100px;">
                    <div class="header"><strong>DIMS 23</strong></div>
                    <i class="fa fa-hand-right"></i> <h3><a href="{{ url('/sales') }}">CONTINUE</a></h3>
                @else
                <div class="links">
                    <div class="col-md-8 col-md-offset-2" style="color:black;font-weight: 900">
                        <div class="panel panel-default">
                            <div class="panel-heading">Login</div>
                            <div class="panel-body">

                                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('UserName') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label">User Name</label>

                                        <div class="col-md-6">
                                            <input id="UserName" type="text" class="form-control" name="UserName" value="{{ old('UserName') }}" required autofocus style="color:black;font-weight: 900">

                                            @if ($errors->has('UserName'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('UserName') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required style="color:black;font-weight: 900">

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group" >
                                        <div class="col-md-8 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Login
                                            </button>

                                            <a style="display: none;" class="btn btn-link" href="{{ route('password.request') }}">
                                                Forgot Your Password?
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </body>
</html> --}}

<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{asset('css/loginStyle.css')}}">
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
        <title>DIMS</title>
        <link rel="icon" href="{{asset('public/images/dimslogo.png')}}" type="image/icon type">
    </head>
    <body>
        <div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        <div class="wrapper fadeInDown">
            @if (Auth::check())
                <img src="public/images/dimslogo.png" style="height: 100px;">
                <div class="header"><strong>DIMS 23</strong></div>
                <i class="fa fa-hand-right"></i> <h3><a href="{{ url('/sales') }}">CONTINUE</a></h3>
            @else
            <div id="formContent">
                <!-- Tabs Titles -->
                <h2 class="active"> DIMS 23 </h2>
                <!--h2 class="inactive underlineHover">Sign Up </h2-->
                <!-- Icon -->
                <div class="fadeIn first">
                    <img src="{{asset('public/images/dimslogo.png')}}" id="icon" alt="User Icon" />
                </div>
                <!-- Login Form -->
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('UserName') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <input id="UserName" type="text" class="form-control" name="UserName" value="{{ old('UserName') }}" required autofocus placeholder="username">

                            @if ($errors->has('UserName'))
                                <span class="help-block">
                        <strong>{{ $errors->first('UserName') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required placeholder="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>
                    <input type="submit" class="fadeIn fourth" id="login" value="Log In">
                </form>
                
                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <a class="underlineHover" href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
            </div>
            @endif
        </div>
    </body>
</html>
