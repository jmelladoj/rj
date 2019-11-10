<?php

namespace App\Http\Controllers;

use App\Aviso;
use App\Publicacion;
use Illuminate\Http\Request;
use App\User;
use App\ValoracionCliente;
use App\ValoracionUsuario;
use App\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //
    public function index(Request $request){
        if (!$request->ajax() || \Auth()->user()->tipo_usuario != 1) return redirect('/home');
        
        $usuarios = User::where('tipo_usuario', 2)->orderBy('nombre', 'desc')->get();

        return ['usuarios' => $usuarios];
    }

    public function indexObtenerUsuario(Request $request){
        $usuario = \Auth::user();

        return ['usuario' => $usuario];
    }

    public function crear(Request $request){
        $datos_usuario = json_decode($request->usuario);
        $url_imagenes = array("foto_uno_url", "foto_dos_url", "foto_tres_url", "foto_cuatro_url", "foto_cinco_url", "foto_seis_url", "foto_siete_url", "foto_ocho_url", "foto_nueve_url", "foto_diez_url", "foto_once_url", "foto_doce_url");

        $usuario = User::create(
            ['usuario' => $datos_usuario->usuario,
             'password' => $datos_usuario->clave,
             'nombre' => $datos_usuario->nombre, 
             'telefono' => $datos_usuario->telefono,
             'edad' => $datos_usuario->edad,  
             'sexo' => 1,  
             'nacionalidad' => $datos_usuario->nacionalidad, 
             'ciudad_id' => $datos_usuario->ciudad_id, 
             'password' => Hash::make($datos_usuario->clave),
             'altura' => $datos_usuario->altura,
             'busto' => $datos_usuario->busto,
             'cintura' => $datos_usuario->cintura,
             'caderas' => $datos_usuario->caderas, 
             'descripcion' => $datos_usuario->descripcion,
             'vendedor' => $datos_usuario->vende
            ]
        );

        if ($request->hasFile('video')) {
            $foto_perfil = $request->file('video');
            $nombre = $usuario->id . '-1.' . $request->file('video')->getClientOriginalExtension();
            
            $url = Storage::putFileAs(
                'videos', $foto_perfil, $nombre, 'public'
            );

            $usuario = User::updateOrCreate(['usuario' => $datos_usuario->usuario], ['video_url' => $url]);
        } 

        if ($request->hasFile('imagen_perfil')) {
            $foto_perfil = $request->file('imagen_perfil');
            $nombre = $usuario->id . '-1.' . $request->file('imagen_perfil')->getClientOriginalExtension();
            
            $url = Storage::putFileAs(
                'fotos_perfil', $foto_perfil, $nombre, 'public'
            );

            $usuario = User::updateOrCreate(['usuario' => $datos_usuario->usuario], ['perfil_url' => $url]);
        }   


        for ($i=0; $i < count($url_imagenes); $i++) { 
            if ($request->hasFile('foto_' . ($i + 1))) {
                $foto_galeria = $request->file('foto_' . ($i + 1));
                $nombre = $usuario->id . '-' . ($i+ 1) . '.' . $request->file('foto_' . ($i + 1))->getClientOriginalExtension();
    
                $url = Storage::putFileAs(
                    'fotos_galeria', $foto_galeria, $nombre, 'public'
                );
        
                $usuario = User::updateOrCreate(['usuario' => $datos_usuario->usuario], [ $url_imagenes[$i] => $url]);
            }
        }
    }

    public function actualizar(Request $request){
        $datos_usuario = json_decode($request->usuario);
        $url_imagenes = array("foto_uno_url", "foto_dos_url", "foto_tres_url", "foto_cuatro_url", "foto_cinco_url", "foto_seis_url", "foto_siete_url", "foto_ocho_url", "foto_nueve_url", "foto_diez_url", "foto_once_url", "foto_doce_url");


        $usuario = User::findOrFail($datos_usuario->id);

        $usuario->nombre = $datos_usuario->nombre;
        $usuario->telefono = $datos_usuario->telefono;
        $usuario->altura = $datos_usuario->altura;
        $usuario->busto = $datos_usuario->busto;
        $usuario->cintura = $datos_usuario->cintura;
        $usuario->caderas = $datos_usuario->caderas;
        $usuario->descripcion = $datos_usuario->descripcion;
        $usuario->edad = $datos_usuario->edad;
        $usuario->ciudad_id = $datos_usuario->ciudad_id;
        $usuario->nacionalidad = $datos_usuario->nacionalidad;
        $usuario->vendedor = $datos_usuario->vende;

        if($datos_usuario->clave != null || $datos_usuario->clave != ''){
            $usuario->password = $datos_usuario->clave;
        }

        $usuario->save();

        

        
        if ($request->hasFile('video')) {
            $foto_perfil = $request->file('video');
            $nombre = $usuario->id . '-1.' . $request->file('video')->getClientOriginalExtension();
            
            $url = Storage::putFileAs(
                'videos', $foto_perfil, $nombre, 'public'
            );

            $usuario = User::updateOrCreate(['usuario' => $datos_usuario->usuario], ['video_url' => $url]);
        } 

        if ($request->hasFile('imagen_perfil')) {
            $foto_perfil = $request->file('imagen_perfil');
            $nombre = $usuario->id . '-1.' . $request->file('imagen_perfil')->getClientOriginalExtension();
            
            $url = Storage::putFileAs(
                'fotos_perfil', $foto_perfil, $nombre, 'public'
            );

            $usuario = User::updateOrCreate(['usuario' => $datos_usuario->usuario], ['perfil_url' => $url]);
        }   


        for ($i=0; $i < count($url_imagenes); $i++) { 
            if ($request->hasFile('foto_' . ($i + 1))) {
                $foto_galeria = $request->file('foto_' . ($i + 1));
                $nombre = $usuario->id . '-' . ($i+ 1) . '.' . $request->file('foto_' . ($i + 1))->getClientOriginalExtension();
    
                $url = Storage::putFileAs(
                    'fotos_galeria', $foto_galeria, $nombre, 'public'
                );
        
                $usuario = User::updateOrCreate(['usuario' => $datos_usuario->usuario], [ $url_imagenes[$i] => $url]);
            }
        }
    }

    public function eliminar(Request $request){
        if (!$request->ajax() || \Auth()->user()->tipo_usuario != 1) return redirect('/home');

        $usuario = User::findOrFail($request->id);
        $url_imagenes = array("foto_uno_url", "foto_dos_url", "foto_tres_url", "foto_cuatro_url", "foto_cinco_url", "foto_seis_url", "foto_siete_url", "foto_ocho_url", "foto_nueve_url", "foto_diez_url", "foto_once_url", "foto_doce_url");

        if($usuario->perfil_url != ''){
            Storage::delete($usuario->perfil_url);
        }

        if($usuario->video_url != ''){
            Storage::delete($usuario->video_url);
        }

        foreach($url_imagenes AS $foto){
            if($usuario->$foto != ''){
                Storage::delete($usuario->$foto);
            }
        }

        Aviso::where('user_id', $usuario->id)->delete();
        Publicacion::where('user_id', $usuario->id)->delete();
        Video::where('user_id', $usuario->id)->delete();

        $usuario->delete();
    }

    public function agencia(Request $request){
        if (!$request->ajax() || \Auth()->user()->tipo_usuario != 1) return redirect('/home');

        $usuario = User::findOrFail($request->id);
        $usuario->agencia = $usuario->agencia == 1 ? 0 : 1;
        $usuario->save();
    }

    public function mostrar(Request $request){
        if (!$request->ajax() || \Auth()->user()->tipo_usuario != 1) return redirect('/home');

        $usuario = User::findOrFail($request->id);
        $usuario->visible = $usuario->visible == 1 ? 0 : 1;
        $usuario->save();
    }

    public function calificar(Request $request){
        $datos_calificacion = json_decode($request->calificacion);
        $valoracion = new ValoracionUsuario();
        $valoracion->nombre = $datos_calificacion->nombre_cliente;
        $valoracion->atencion = $datos_calificacion->atencion;
        $valoracion->higiene = $datos_calificacion->higiene;
        $valoracion->fotos = $datos_calificacion->fotos;
        $valoracion->nota = $datos_calificacion->nota;
        $valoracion->user_id = $request->usuario_id;
        $valoracion->rostro = $datos_calificacion->rostro;
        $valoracion->cuerpo = $datos_calificacion->cuerpo;
        $valoracion->trato = $datos_calificacion->trato;
        $valoracion->besos = $datos_calificacion->besos;
        $valoracion->cama = $datos_calificacion->cama;
        $valoracion->sexo_oral = $datos_calificacion->sexo_oral;
        $valoracion->sexo_anal = $datos_calificacion->sexo_anal;
        $valoracion->save();
    }

    public function calificar_cliente(Request $request){
        $datos_calificacion = json_decode($request->calificacion);
        $valoracion = new ValoracionCliente();
        $valoracion->nombre = $datos_calificacion->nombre;
        $valoracion->higiene = $datos_calificacion->higiene;
        $valoracion->respeto = $datos_calificacion->respeto;
        $valoracion->dinero = $datos_calificacion->dinero;
        $valoracion->nota = $datos_calificacion->nota;
        $valoracion->user_id = \Auth::user()->id;
        $valoracion->save();

    }
}
