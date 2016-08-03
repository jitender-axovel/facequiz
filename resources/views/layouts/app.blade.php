<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:site_name" content="robodoo.com"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="@yield('og_url')"/>
    <meta property="og:title" content="@yield('og_title')"/>
    <meta property="og:description" content="@yield('og_description')"/>
    <meta name="author" content="@yield('og_author')"/>
    <meta property="og:image" content="@yield('og_image')"/>
    <meta property="og:image:type" content="image/png"/>
    <meta property="og:image:width" content="800"/>
    <meta property="og:image:height" content="420"/>
    <meta property="og:locale" content="@yield('og_locale')"/>

    <title>@yield('title')</title>

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

    <script type="text/javascript">
        // Additional JS functions here
        window.fbAsyncInit = function() {
            FB.init({
                appId      : 1617441138584190, // App ID
                status     : true,    // check login status
                cookie     : true,
                xfbml      : true,     // parse page for xfbml or html5
                // social plugins like login button below
                version    : 'v2.0',  // Specify an API version
            });
            $(document).trigger('fbload');

        // Put additional init code here
        };

        // Load the SDK Asynchronously
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</head>
<body>
<header class="site-header">
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
		<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
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
                    @foreach(App\Cms::get() as $cmsPage)
                    <li><a href="{{url('cms/'.$cmsPage->slug)}}">{{$cmsPage->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </footer>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('scripts')
</body>
</html>
