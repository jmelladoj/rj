@extends('layouts.app')

@section('contenido')

        <section id="about" class="ds ms page_about parallax section_padding_100 columns_padding_25 columns_margin_bottom_30">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h2 class="section_header">¿Qué deseas?</h2>
                        <p class="small-text highlight lusitana">Bienvenidos</p>
                    </div>
                </div>
                    <div class="col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6 text-center">
                    <div class="row text-center"><a href="#agencia" class="btn-block theme_button color1 bottommargin_5 center-block"><font size="5">ESCORT EN TU CIUDAD</font></a></div>
                    <div class="row text-center"><a href="#avisos"  class="btn-block theme_button color1 bottommargin_5 center-block">AVISOS ERÓTICOS</a></div>
                    <div class="row text-center"><a href="{{ url('/valoradas') }}" class="btn-block theme_button color1 bottommargin_5 center-block">MEJOR VALORADAS</a></div>
                    <div class="row text-center"><a href="{{ url('/ventas') }}" class="btn-block theme_button color1 bottommargin_5 center-block">VENTA DE FOTOS Y VÍDEOS</a></div>
                    <div class="row text-center"><a href="{{ url('/anuncios') }}" class="btn-block theme_button color1 bottommargin_5 center-block">CONOCE GENTE</a></div>
                    <div class="row text-center"><a href="{{ url('/videos')}}" class="btn-block theme_button color1 bottommargin_5 center-block">PERFILES CON VÍDEO</a></div>
                </div>
            </div>
        </section>

        <registro-usuario></registro-usuario>

        <usuarios-video-estado :ciudad="1"></usuarios-video-estado>
        
        <usuarios-vip :ciudad="1"></usuarios-vip>

        <usuarios-mejor-valorados :ciudad="1"></usuarios-mejor-valorados>

        <descanso-uno></descanso-uno> 

        <usuarios-normal :ciudad="1"></usuarios-normal>

        <descanso-dos></descanso-dos> 

        <registro-usuario></registro-usuario>

        <avisos-usuario-inicio :ciudad="1"></avisos-usuario-inicio>

        <publicaciones-pagina></publicaciones-pagina>  

        <seccion-nosotros></seccion-nosotros>

@endsection