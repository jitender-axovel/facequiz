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

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <script>
        // var languageStrings = {{--{!!htmlspecialchars_decode(json_encode($languageStrings))!!}--}};
        // var defaultLanguageStrings = {{--{!!htmlspecialchars_decode(json_encode($defaultLanguageStrings))!!}--}};
        
        // //Translation
        // function __(key){
        //     if (languageStrings.hasOwnProperty(key)){
        //         return languageStrings[key];
        //     } else if (defaultLanguageStrings.hasOwnProperty(key)){
        //         return defaultLanguageStrings[key];
        //     } else {
        //         return key;
        //     }
        // }
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
        <div class="logo custom-left col-sm-3 col-xs-12 ">
            <a href="{{ url('/') }}"><img src="{{asset('images/logo.png')}}"></a>
        </div>
        
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
                    <li><a class="login" href="{{ url('redirect') }}">{{ $languageStrings['Login'] or 'Login' }}</a></li>
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
                            <li class="full"><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ $languageStrings['Logout'] or 'Logout' }}</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <div class="header-navigation col-md-6 col-sm-5 col-xs-12">
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
                        <li><a href="{{ url('/') }}">{{ $languageStrings['Latest'] or 'Latest' }}</a></li>
                        <li><a href="{{ url('quizzes/popular') }}">{{ $languageStrings['Popular'] or 'Popular' }}</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

<!--div for web-->
    <div class="top-header">
        <div class="container web-view">
            <div class="logo custom-left col-sm-4 col-xs-12 ">
                <a href="{{ url('/') }}" class="logo-link"><img src="{{asset('images/logo.png')}}"></a>
                <select name="language" id="language-selector">
                    @foreach(App\Language::get() as $language)
                        <option value="{{ $language->code }}"{{$language->code == Session::get('locale') ? ' selected' : ''}}>{{ $language->name }}</option>
                    @endforeach
                </select>
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
                            <li><a href="{{ url('/') }}">{{ $languageStrings['Latest'] or 'Latest' }}</a></li>
                            <li><a href="{{ url('quizzes/popular') }}">{{ $languageStrings['Popular'] or 'Popular' }}</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="top-side-link col-md-2 col-sm-3 col-xs-6 ">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a class="login" href="{{ url('redirect') }}">{{ $languageStrings['Login'] or 'Login' }}</a></li>
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
                                <li class="full"><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ $languageStrings['Logout'] or 'Logout' }}</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="like-section web-view">
        <div class="container-fluid">
            <div class="col-md-9 col-sm-8 col-xs-12 text-center">
                <p>{{ $languageStrings['We like you. Like us back!'] or "We like you. Like us back!" }}</p>
            </div>
            <div class="custom-like-button col-md-3 col-sm-4">
                <span class="bold">{{ $languageStrings['Like Us'] or "Like Us" }} <i class="fa fa-arrow-right"></i> </span>
                @if(isset($fb_like_button))
                    {!!$fb_like_button!!}
                @else
                    <div class="fb-like" data-href="https://www.facebook.com/robodoo.en" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                @endif
            </div>
        </div>
    </div>
</header>

    @yield('content')

    <footer>
        <div class="container-fluid text-center">
            <div class="footer-links col-md-12 col-sm-12 col-xs-12">
                <ul class="list-inline">
                    @foreach(App\Cms::get() as $cmsPage)
                    <li><a href="{{url('cms/'.$cmsPage->slug)}}">{{ $languageStrings[$cmsPage->title] or $cmsPage->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p>{{ $languageStrings['Disclaimer: All contents on this website are provided for fun and entertainment purposes only.'] or 'Disclaimer: All contents on this website are provided for fun and entertainment purposes only.' }}</p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 copyright">
                <p>{{ $languageStrings['©2016 Robodoo Entertainment, All Rights Reserved.'] or '©2016 Robodoo Entertainment, All Rights Reserved.' }}</p>
            </div>
            
        </div>
    </footer>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('scripts')
    <script type="text/javascript">
        $('#language-selector').change(function() {
            lang = $(this).val();
            window.location.href = window.location.href.split('?')[0] + '?lang=' + lang;
        });
    </script>
</body>
</html>
