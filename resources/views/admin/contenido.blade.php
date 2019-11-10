@extends('layouts.intranet')

@section('content')

    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">--- MENÚ</li>
                    <li @click="menu=0"> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">USUARIOS</span></a></li>
                    <li @click="menu=1"> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">CIUDADES</span></a></li>
                    <li @click="menu=2"> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu"> PUBLICACIONES</span></a></li>
                    <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span class="hide-menu">CERRAR SESIÓN</span> </a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                </ul>
            </nav>
        </div>
    </aside>

    <template v-if="menu==0">
        <usuarios></usuarios>
    </template>

    <template v-if="menu==1">
        <ciudades></ciudades>
    </template>

    <template v-if="menu==2">
        <publicaciones></publicaciones>
    </template>
@endsection