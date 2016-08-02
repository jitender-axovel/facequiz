<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <script>
        var languageStrings = {{json_encode($languageStrings)}};
        var defaultLanguageStrings = {!!json_encode($defaultLanguageStrings)!!};
        //Translation
        function __(key){
            if (languageStrings.hasOwnProperty(key)){
                return languageStrings[key];
            } else if (defaultLanguageStrings.hasOwnProperty(key)){
                return defaultLanguageStrings[key];
            } else {
                return key;
            }
        }
    </script>

</head>
<body>
<header>
    <div class="container-fluid">
        <div class="logo custom-left col-sm-3 col-xs-12">
            <img src="{{asset('images/logo.png')}}">
        </div>
        <div class="header-navigation col-md-8 col-sm-7 col-xs-12">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/') }}">Latest</a></li>
                        <li><a href="{{ url('quizzes/all') }}">popular</a></li>
                        <li><a href="#">categories</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="top-side-link col-md-2 col-sm-2">
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('redirect') }}">FB Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img height="32" width="32" src="{{ isset($profile_pic_header) ? $profile_pic_header : asset('images/avatar.png') }}">&nbsp;{{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</header>

    @yield('content')

    <footer>
        <div class="container-fluid">
            <div class="col-md-2 col-sm-3 col-xs-12 copyright">
                <p>Robodoo, All Rights Reserved</p>
            </div>
            <div class="footer-links col-md-10 col-sm-9 col-xs-12">
                <ul class="list-inline">
                    <li><a href="{{url('privacy-policy')}}">Privacy Policy</a></li>
                    <li><a href="#">Tearms & conditions</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
