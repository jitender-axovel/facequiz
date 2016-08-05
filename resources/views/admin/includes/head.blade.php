<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $page or 'Robodoo - Play with Robo' }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}"/>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}" type="text/javascript"></script>
    @yield('admin-head-script')

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css"/>
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css?version='.time()) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin.styles.css?version='.time()) }}" rel="stylesheet" type="text/css">
    @yield('admin-styles')
</head>