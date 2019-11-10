@extends('layouts.app')

@section('contenido')

    <section class="page_breadcrumbs cs section_padding_50 gradient table_section table_section_md">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-left">
                    <h2 class="small">Perfiles con vídeo</h2>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ url('/') }}">
                                Inicio
                            </a>
                        </li>
                        <li class="active">Perfiles con vídeo</li>
                    </ol>
            </div>
        </div>
    </section>

    <usuarios-video></usuarios-video>

    <registro-usuario></registro-usuario>
@endsection