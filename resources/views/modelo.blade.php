@extends('layouts.app')

@section('contenido')
    <section class="page_breadcrumbs cs section_padding_50 gradient table_section table_section_md">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-left">
                    <h2 class="small">{{ $usuario->nombre}}</h2>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ url('/') }}">
                                Inicio
                            </a>
                        </li>
                        <li class="active">
                                <a title="Click para chatear" href="{{ $usuario->linkWhatsapp }}" target="_blank">{{ $usuario->celular }} <img src="{{ asset('general/images/whatsapp.png') }}" height="30px" width="30px" alt=""></a>
                        </li>
                    </ol>
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
                    <h2 class="topmargin_0 bottommargin_30">{{ $usuario->nombre }} - <div class="highlight inline-block fontsize_30 thin"><a title="Click para chatear" href="{{ $usuario->linkWhatsapp }}" target="_blank" rel="noopener"><img src="{{ asset('general/images/whatsapp.png') }}" height="30px" width="30px" alt=""> {{ $usuario->celular }}</a></div></h2>
                    <p class="text-justify">
                        {!! $usuario->descripcion !!}
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
            
            @if($usuario->video_url != null)
                <div class="row">
                    <div class="col-md-12">                    
                        <div class="columns_padding_5">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{ asset('storage/' . $usuario->video_url) }}" allowfullscreen autoplay></iframe>
                            </div>
                        </div>     
                    </div>
                </div>
            @endif
        </div>
    </section>

    @auth
        @if(Auth::user()->tipo_usuario == 2)
            <calificacion-cliente :usuario="{{ json_encode($usuario) }}"> </calificacion-cliente>
        @endif
    @else
        <calificacion-usuario :usuario="{{ json_encode($usuario) }}"> </calificacion-usuario>
    @endauth
    
    <calificaciones :usuario="{{ json_encode($usuario) }}"></calificaciones>
    
@endsection