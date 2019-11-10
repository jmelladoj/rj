@extends('layouts.app')

@section('contenido')
    <section id="wrapper">
        <div class="login-register" style="background-image:url('{{ asset('general/images/login.jpeg') }}');">
            <div class="login-box card">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <center>
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </center>
                    </div>
                @endif
                <div class="card-body">
                    <form method="POST" class="form-horizontal form-material" id="loginform" action="{{ route('login') }}">
                        @csrf
                        <h3 class="box-title m-b-20 text-center">Ingreso</h3>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="usuario" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" type="text" name="usuario" value="{{ old('usuario') }}" autofocus placeholder="Usuario" required> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Contraseña"> 
                            </div>
                        </div>
                        <br>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-10">
                                <button type="submit" class="btn btn-lg btn-primary btn-rounded theme_button color1" >Ingresar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
