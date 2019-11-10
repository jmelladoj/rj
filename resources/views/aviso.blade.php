@extends('layouts.app')

@section('contenido')

    <header class="page_header header_darkgrey columns_padding_0 table_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 text-center">
                    <a href="{{ url('/') }}" class="logo logo_image">
                        <img src="{{ asset('general/images/logo.png') }}" alt="" style="max-height: 60px;">
                    </a>
                </div>
                <div class="col-md-6 text-center">
                    <nav class="mainmenu_wrapper">
                        <ul class="center-block mainmenu nav sf-menu">
                            <li class="active">
                                <a href="{{ url('/') }}">Inicio</a>
                            </li>
    
                            <li>
                                <a href="{{ url('/#nosotros') }}">Nosotros</a>
                            </li>
                            
                            <li>
                                <a href="{{ url('/#agencia') }}">Escort VIP</a>
                            </li>

                            <li>
                                <a href="{{ url('/#independiente') }}">Escort</a>
                            </li>

                            <li>
                                <a href="{{ url('/#publicate') }}">Publicate</a>
                            </li>

                        </ul>
                    </nav>
                    <span class="toggle_menu">
                        <span></span>
                    </span>
                </div>
                <div class="col-md-3 col-sm-6 header-contacts text-center hidden-xs">
                    <div class="highlight inline-block fontsize_30 thin"><a title="Click para chatear" href="{{ $usuario->linkWhatsapp }}" target="_blank">{{ $usuario->celular }} <img src="{{ asset('general/images/whatsapp.png') }}" height="30px" width="30px" alt=""></a></div>
                    <div class="fontsize_20 grey topmargin_-5">Concepción</div>
                </div>
            </div>
        </div>
    </header>

    <section class="page_breadcrumbs changeable ls gradient gorizontal_padding section_padding_20 columns_padding_5 table_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 text-center text-sm-left darklinks">
                    <a href="{{ $usuario->linkWhatsapp }}" target="_blank">
                        <em>{{ $usuario->celular }}</em>
                    </a>
                </div>
                <div class="col-sm-6 text-center">
                    <ol class="center-block breadcrumb">
                        <li>
                            <a href="{{ url('/') }}">
                                Inicio
                            </a>
                        </li>
                        <li class="active">
                            <span>{{ $usuario->nombre}}</span>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-3 text-center text-sm-right">
                    <ul class="inline-dropdown inline-block">
                        <li class="dropdown login-dropdown">
                            @guest
                                <login></login>                              
                            @else
                                <a class="topline-button" id="login" href="{{ url('/home')}}" role="button" >
                                    <i class="rt-icon2-user"></i> {{ Auth::user()->nombre }}
                                </a>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="ds model-page section_padding_70 section_padding_bottom_60 columns_padding_25">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-push-7">
                    <div class="vertical-item with_background models_square">
                        <div class="item-media">
                            <img src="{{ asset('storage/' . $usuario->perfil_url) }}" alt="Placerconce.cl - {{ $usuario->nombre }}">
                        </div>
                        <div class="model-parameters grey gradient_bg_goriz before_cover text-center">
                            <div class="bg_overlay"></div>
                            <div>
                                <span class="bold">Altura</span>
                                <br>
                                <span>{{ $usuario->altura}}</span>
                            </div>
                            <div>
                                <span class="bold">Busto</span>
                                <br>
                                <span>{{ $usuario->busto}}</span>
                            </div>
                            <div>
                                <span class="bold">Cintura</span>
                                <br>
                                <span>{{ $usuario->cintura}}</span>
                            </div>
                            <div>
                                <span class="bold">Caderas</span>
                                <br>
                                <span>{{ $usuario->caderas}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-md-pull-5">
                    <h2 class="topmargin_0 bottommargin_30">{{ $aviso->titulo }}</h2>
                    <p class="text-justify">
                        {!! $aviso->contenido !!}
                    </p>
                </div>

            </div>

            @if(count($usuario->fotos) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div id="gallery-owl-carousel" data-autoplay="true" class="owl-carousel" data-dots="true" data-items="3" data-responsive-lg="3" data-responsive-md="2" data-responsive-sm="2" data-responsive-xs="1">
                            @foreach ($usuario->fotos as $item)
                                <div class="vertical-item gallery-extended-item with_background">
                                    <img class="galeria" src="{{ asset('storage/' . $item) }}" alt="Placerconce.cl - {{ $usuario->nombre }}">
                                </div>               
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </section>
    
@endsection