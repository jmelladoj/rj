<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;
use App\Http\Resources\User as UserResource;
use App\Aviso;
use App\Http\Resources\Aviso as AvisoResource;
use App\Publicacion;
use App\Http\Resources\Publicacion as PublicacionResource;
use App\Estado;
use App\Http\Middleware\Request;
use App\Http\Resources\Estado as EstadoResource;
use App\ValoracionUsuario;
use App\Http\Resources\ValoracionUsuario as ValoracionUsuarioResource;
use Carbon\Carbon;

Route::get('/', 'HomeController@inicio')->name('inicio');
Route::get('/concepcion', 'HomeController@inicioConcepcion')->name('inicio concepcion');

Route::get('/modelo/{id}/ver', 'HomeController@modelo')->name('modelo');
Route::get('/aviso/{id}', 'HomeController@aviso')->name('aviso');
Route::get('/publicacion/{id}', 'HomeController@publicacion')->name('publicacion');
Route::get('/videos', 'HomeController@videos')->name('videos');
Route::get('/valoradas', 'HomeController@valoradas')->name('valoradas');
Route::get('/ventas', 'HomeController@ventas')->name('ventas'); 
Route::post('/usuario/calificar', 'UsuarioController@calificar')->name('calificacion_usuario');
Route::post('/cliente/calificar', 'UsuarioController@calificar_cliente')->name('calificacion_cliente');
Route::get('/ciudades/usuario', 'CiudadController@index_usuario');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['request'])->group(function(){
    //Route::get('/usuarios/agencia/{ciudad}', function ($ciudad) { 
    //    dd($ciudad);
    //    return UserResource::collection(User::where('ciudad_id', $ciudad)->where('perfil_url', '!=', null)->where('tipo_usuario', 2)->where('agencia', 1)->where('visible', 1)->orderBy('updated_at', 'DESC')->get());
    //});

    Route::get('/usuarios/normal/{ciudad}', function ($ciudad) { 
        return UserResource::collection(User::where('ciudad_id', $ciudad)->where('perfil_url', '!=', null)->where('tipo_usuario', 2)->where('agencia', 0)->where('visible', 1)->orderBy('updated_at', 'DESC')->get());
    });

    Route::get('/usuarios/agencia/{ciudad}', function ($ciudad) { 
        return UserResource::collection(User::where('ciudad_id', $ciudad)->where('perfil_url', '!=', null)->where('tipo_usuario', 2)->where('agencia', 1)->where('visible', 1)->orderBy('updated_at', 'DESC')->get());
    });

    Route::get('/usuarios/mejor_valoradas/{ciudad}', function ($ciudad) { 
        return UserResource::collection(User::where('ciudad_id', $ciudad)->where('perfil_url', '!=', null)->where('tipo_usuario', 2)->where('visible', 1)->orderBy('updated_at', 'DESC')->get());
    });

    Route::get('/usuarios/venta/{ciudad}', function ($ciudad) { 
        return UserResource::collection(User::where('ciudad_id', $ciudad)->where('perfil_url', '!=', null)->where('tipo_usuario', 2)->where('vendedor', 1)->where('visible', 1)->orderBy('updated_at', 'DESC')->get());
    });

    Route::get('/usuarios/videos/{ciudad}', function ($ciudad) { 
        return UserResource::collection(User::where('ciudad_id', $ciudad)->where('perfil_url', '!=', null)->where('tipo_usuario', 2)->where('visible', 1)->orderBy('updated_at', 'DESC')->get());
    });

    Route::get('/avisos/{ciudad}', function ($ciudad) { 
        $avisos = Aviso::orderBy('updated_at', 'DESC')->limit(15)->get();

        $avisos->filter(function ($aviso) use ($ciudad) {
            return $aviso->usuario->ciudad_id == $ciudad;
        });

        return AvisoResource::collection($avisos);
    });

    Route::get('/publicaciones/pagina', function () { 
        return PublicacionResource::collection(Publicacion::orderBy('updated_at', 'DESC')->limit(16)->get());
    });

    Route::get('/video/estado/{ciudad}', function ($ciudad) { 

        $estados = Estado::whereDate('created_at', Carbon::today())->orderBy('created_at', 'DESC')->get();

        $estados->filter(function ($estado) use ($ciudad) {
            return $estado->usuario->ciudad_id == $ciudad;
        });
        
        return EstadoResource::collection($estados);
    });

    Route::get('/valoraciones/usuario/{id}', function ($id) { 
        return ValoracionUsuarioResource::collection(ValoracionUsuario::where('user_id', $id)->orderBy('created_at', 'DESC')->get());
    });

});

Route::middleware(['auth', 'request'])->group(function(){
    //Rutas de usuarios
    Route::get('/usuarios', 'UsuarioController@index');
    Route::get('/usuario/obtener', 'UsuarioController@indexObtenerUsuario');
    Route::post('/usuario/crear', 'UsuarioController@crear');
    Route::post('/usuario/actualizar', 'UsuarioController@actualizar');
    Route::post('/usuario/eliminar', 'UsuarioController@eliminar');
    Route::post('/usuario/agencia', 'UsuarioController@agencia');
    Route::post('/usuario/mostrar', 'UsuarioController@mostrar');
    
    //Rutas de videos
    Route::get('/video/usuario/{id}', 'VideoController@indexUser');
    Route::get('/videosUsuario', 'VideoController@indexUsuario');
    Route::get('/videos/usuario', 'VideoController@indexUserAuth');
    Route::post('/video/crear/administrador', 'VideoController@crear_administrador');
    Route::post('/video/crear/usuario', 'VideoController@crear_usuario');
    Route::post('/video/borrar', 'VideoController@eliminar');
    Route::post('/video/registrar/usuario', 'VideoController@guardarVideoUsuario');

    //Rutas de avisos
    Route::post('/aviso/crear/administrador', 'AvisoController@crear_administrador');
    Route::post('/aviso/crear/usuario', 'AvisoController@crear_usuario');
    Route::get('/aviso/usuario/{id}', 'AvisoController@indexUser');
    Route::get('/avisos/usuario', 'AvisoController@indexUserAuth');    
    Route::post('/aviso/borrar', 'AvisoController@eliminar');

    //Rutas de estado
    Route::get('/estados/usuario', 'EstadoController@indexUser');

    //Rutas de ciudad
    Route::get('/ciudades/administrador', 'CiudadController@index_administrador');
    Route::post('/ciudad/crear', 'CiudadController@crear');
    Route::post('/ciudad/actualizar', 'CiudadController@actualizar');
    Route::post('/ciudad/borrar', 'CiudadController@borrar');

    //Rutas de publicaicones
    Route::get('/publicaciones', 'PublicacionController@index');
    Route::post('/publicacion/crear/administrador', 'PublicacionController@crear_administrador');
    Route::post('/publicacion/borrar', 'PublicacionController@borrar');

    //Rutas de video estado
    Route::post('/video/estado/crear', 'EstadoController@crearVideoEstado');


});


