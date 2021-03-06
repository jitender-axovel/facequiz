<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ $page or 'Robodoo - Play with Robo' }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}"/>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?version='.time()) }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <script>
        function getWidth() {
            if (self.innerWidth) {
                return self.innerWidth;
            }

            if (document.documentElement && document.documentElement.clientWidth) {
                return document.documentElement.clientWidth;
            }

            if (document.body) {
                return document.body.clientWidth;
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
    <!-- for mobile-view-->
    <header class="site-header ">
        <div class="container-fluid mobile-view">
            <div class="col-md-2 col-sm-2  col-md-6 col-xs-6 custom-like-button">
                <span class="bold">Like Us <i class="fa fa-arrow-right"></i> </span>
                @if(isset($fb_like_button))
                    {!!$fb_like_button!!}
                @else
                    <div class="fb-like" data-href="https://www.facebook.com/robodoo.en" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                @endif
            </div>
            <div class="top-side-link col-md-2  col-sm-2 col-md-6  ">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->

                    @if (Auth::guest())
                        <li><a class="login" href="{{ url('redirect') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a class="profile_pic" href="#" class="dropdown-toggle media" data-toggle="dropdown" role="button" aria-expanded="false">
                                <div class="media-left">
                                    @if(Auth::user()->avatar)
                                        <img  class="media-object" height="40px" width="40px" src="{{Auth::user()->avatar}}">
                                    @else
                                        <img class="media-object" height="40px" width="40px" src="{{ asset(config('image.user_profile_pic').'/avatar.png') }}">
                                    @endif
                                </div>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="left">
                                    @if(Auth::user()->avatar)
                                        <img  class="media-object" height="40px" width="40px" src="{{Auth::user()->avatar}}">
                                    @else
                                        <img class="media-object" height="40px" width="40px" src="{{ asset(config('image.user_profile_pic').'/avatar.png') }}">
                                    @endif
                                </li>
                                <li class="right">
                                    <span>{{Auth::user()->name}}</span>
                                </li>
                                <li class="full"><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="logo custom-left col-sm-6 col-xs-6 ">
                <a href="{{ url('/') }}"><img src="{{asset('images/logo.png')}}"></a>
            </div>
            <div class="header-navigation col-md-6 col-sm-6 col-xs-6">
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
                </nav>
            </div>
            <div class="collapse navbar-collapse mobile-toggle" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Latest</a></li>
                    <li><a href="{{ url('quizzes/popular') }}">Popular</a></li>
                </ul>
            </div>
        </div>

    <!--div for web-->
        <div class="top-header">
            <div class="container web-view">
                <div class="logo custom-left col-sm-4 col-xs-12 ">
                    <a href="{{ url('/') }}" class="logo-link"><img src="{{asset('images/logo.png')}}"></a>
                </div>
                <div class="header-navigation col-md-5 col-sm-5 col-xs-12">
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
                                <li><a href="{{ url('quizzes/popular') }}">Popular</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="top-side-link col-md-2 col-sm-3 col-xs-6 ">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a class="login" href="{{ url('redirect') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a class="profile_pic" href="#" class="dropdown-toggle media" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <div class="media-left">
                                        @if(Auth::user()->avatar)
                                            <img  class="media-object" height="40px" width="40px" src="{{Auth::user()->avatar}}">
                                        @else
                                            <img class="media-object" height="40px" width="40px" src="{{ asset(config('image.user_profile_pic').'/avatar.png') }}">
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="left">
                                        @if(Auth::user()->avatar)
                                            <img  class="media-object" height="40px" width="40px" src="{{Auth::user()->avatar}}">
                                        @else
                                            <img class="media-object" height="40px" width="40px" src="{{ asset(config('image.user_profile_pic').'/avatar.png') }}">
                                        @endif
                                    </li>
                                    <li class="right">
                                        <span>{{Auth::user()->name}}</span>
                                    </li>
                                    <li class="full"><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="container main-content" style="min-height: 400px;">
        <div class="row advertise-block">
            @include('includes.above-quizzes-widgets')
        </div>
        <div class="row text-center">
        	<h1 class="text-bold">Oops!</h1>
        	<h3>looks like you are on a wrong page.</h3>
        	<a href="{{ url('/') }}" class="btn btn-danger btn-lg"><i class="fa fa-home"></i>&nbsp;Go to HomePage</a>
        </div>
        <div class="row">
            @include('includes.below-quizzes-widgets')
        </div>
    </div>
    <footer>
        <div class="container-fluid text-center">
            <div class="footer-links col-md-12 col-sm-12 col-xs-12">
                <ul class="list-inline">
                    @foreach(App\Cms::get() as $cmsPage)
                        <li><a href="{{url('cms/'.$cmsPage->slug)}}">{{ $languageStrings[$cmsPage->title] or $cmsPage->title }}</a></li>
                    @endforeach
                    @if(Auth::check())
                        <li>
                            <a href="javascript:void(0);"
                                onclick="document.getElementById('revoke-form').submit();">
                                Delete App
                            </a>
                            <form id="revoke-form" action="{{ url('/revoke') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p>Disclaimer: All contents on this website are provided for fun and entertainment purposes only.</p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 copyright">
                <p>©2016 Robodoo Entertainment, All Rights Reserved.</p>
            </div>
            
        </div>
    </footer>
</body>
</html>
