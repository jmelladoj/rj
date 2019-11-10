@extends('layouts.app')

@section('contenido')
    <inicio></inicio>

    <template v-if="ciudad > 0">
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
                    <div class="row text-center"><a href="#"  class="btn-block theme_button color1 bottommargin_5 center-block">USUARIOS ONLINE</a></div>
                    <div class="row text-center"><a href="#"  class="btn-block theme_button color1 bottommargin_5 center-block">CHAT</a></div>
                    <div class="row text-center"><a href="{{ url('/valoradas') }}" class="btn-block theme_button color1 bottommargin_5 center-block">MEJOR VALORADAS</a></div>
                    <div class="row text-center"><a href="{{ url('/ventas') }}" class="btn-block theme_button color1 bottommargin_5 center-block">VENTA DE FOTOS Y VÍDEOS</a></div>
                    <div class="row text-center"><a href="{{ url('/videos')}}" class="btn-block theme_button color1 bottommargin_5 center-block">CERTIFICADAS CON VÍDEOS</a></div>
                    <div class="row text-center"><a href="#" class="btn-block theme_button color1 bottommargin_5 center-block">DATOS PARA ESCORTS</a></div>
                </div>
            </div>
        </section>

        <registro-usuario></registro-usuario>

        <usuarios-video-estado :ciudad="ciudad"></usuarios-video-estado>
        
        <usuarios-vip :ciudad="ciudad"></usuarios-vip>

        <usuarios-mejor-valorados :ciudad="ciudad"></usuarios-mejor-valorados>

        <descanso-uno></descanso-uno> 

        <usuarios-normal :ciudad="ciudad"></usuarios-normal>

        <descanso-dos></descanso-dos> 

        <registro-usuario></registro-usuario>

        <avisos-usuario-inicio :ciudad="ciudad"></avisos-usuario-inicio>

        <publicaciones-pagina></publicaciones-pagina>  

        <seccion-nosotros></seccion-nosotros>
    </template>

@endsection