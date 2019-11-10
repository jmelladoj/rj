<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" defer>
    @if(request()->is('login')) <link href="{{ asset('css/css-login.css') }}" rel="stylesheet" defer> @endif
    <link href="{{ asset('css/pagina.css') }}" rel="stylesheet" id="color-switcher-link" defer>
    <link href="{{ url('css/fonts.css') }}" rel="stylesheet" defer>

    <link rel="shortcut icon" href="{{ asset('general/images/logo.png') }}">
</head>
<body>
    <div id="parent" v-autoscroll:noscroll="'top center'">
        <div id="app">
            <div id="canvas">
                <div id="box_wrapper">
                    
                    <header class="page_header header_darkgrey header_logo_center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 text-md-center">
                                    <div class="logo_wrapper">
                                        <a href="{{ url('/') }}" class="logo top_logo">
                                            <img src="{{ asset('general/images/logo.png') }}" alt="Logo Relajandote">
                                        </a>
                                    </div>
                                    <!-- header toggler -->
                                    <span class="toggle_menu">
                                        <span></span>
                                    </span>
                                    <!-- main nav start -->
                                    <nav class="mainmenu_wrapper">
                                        <ul class="mainmenu nav sf-menu">
                                            <li class="active">
                                                @if(request()->is('/'))<a href="#box_wrapper">Inicio</a> @else <a href="{{ url('/') }}">Inicio</a> @endif
                                            </li>
                                            <li><a href="{{ url('/login') }}">Ingresar</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </header>


                    @yield('contenido')

                    <a href="#" id="toTop" style="display: inline;"><span id="toTopHover" style="opacity: 0;"></span></a>

                </div>
                <!-- eof #box_wrapper -->
                <section class="ls page_copyright table_section section_padding_50">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <p class="grey thin">&copy; Relajandote 2019. Todos los derechos reservados.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/pagina.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    
</body>
</html>
