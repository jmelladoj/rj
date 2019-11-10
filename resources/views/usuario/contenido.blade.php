@extends('layouts.intranet')

@section('titulo', 'Placer Conce - Usuario')

@section('content')

    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">--- MENÚ</li>
                    <li @click="menu=0"> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu"> MI PERFIL</span></a></li>
                    <li @click="menu=1"> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-upload"></i><span class="hide-menu"> VÍDEO ESTADO</span></a></li>
                    <li @click="menu=2"> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-file"></i><span class="hide-menu"> MIS AVISOS</span></a></li>
                    <li @click="menu=3"> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-play"></i><span class="hide-menu"> MIS VIDEOS</span></a></li>
                    <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span class="hide-menu">CERRAR SESIÓN</span> </a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                </ul>
            </nav>
        </div>
    </aside>

    <template v-if="menu==0">
        <perfil-usuario></perfil-usuario>
    </template>

    <template v-if="menu==1">
        <video-estado></video-estado>
    </template>

    <template v-if="menu==2">
        <avisos-usuario></avisos-usuario>
    </template>

    <template v-if="menu==3">
        <videos-usuario></videos-usuario>
    </template>

@endsection