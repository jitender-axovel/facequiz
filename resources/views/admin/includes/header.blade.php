<header class="admin-header navbar-fixed-top">
    <div class="container">
        <div class="col-md-6 left-side">
            <ul class="left-menu list-inline">
                <li><a href="#" class="site-logo"><img src="{{ asset('images/logo.png') }}"></a></li>
            </ul>
        </div>
        <div class="col-md-6 right-side">
            <ul class="list-inline">
                <li class="login"><a class="btn btn-success" href="{{url('/')}}">Visit Site</a></li>
                <li><a class="btn btn-danger" href="{{ url('logout') }}"><i class="fa fa-power-off"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</header>