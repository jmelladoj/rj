<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('general/images/logo.png') }}">
    <title>@yield('titulo', 'Placer Conce - Administrador')</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css-admin.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('general/images/logo.png') }}">

    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fixed-layout skin-red-dark">

    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <b>
                            RJ
                        </b>
                        <span>
                            - RELAJANDOTE
                        </span> 
                    </a>
                </div>

                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    </ul>
                    
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-user"></i> {{ Auth::user()->nombre }}</a></li>
                    </ul>
                </div>
            </nav>
        </header>

        <div id="app" class="m-b-40">
            @yield('content')
        </div>

        <footer class="footer">
            Relajandote 2019 ©. Todos los derechos reservados.
        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/js-admin.js') }}"></script>
</body>

</html>