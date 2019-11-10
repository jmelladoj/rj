<?php

namespace App\Http\Controllers;

use App\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicacionController extends Controller
{
    //
    public function index(Request $request){
        if (!$request->ajax() || \Auth()->user()->tipo_usuario != 1) return redirect('/home');
         
        $publicaciones = Publicacion::orderBy('created_at', 'desc')->get();

        return ['publicaciones' => $publicaciones];
    }

    public function crear_administrador(Request $request)
    {   
        $publicacion = new Publicacion();
        $publicacion->titulo = $request->titulo;
        $publicacion->resumen = $request->resumen;
        $publicacion->contenido = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $request->contenido);
        $publicacion->user_id = \Auth::user()->id;
        $publicacion->save();


        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre = 'publicacion-' . $publicacion->id . '.' . $request->file('imagen')->getClientOriginalExtension();
            
            $url = Storage::putFileAs(
                'publicaciones', $imagen, $nombre, 'public'
            );

            Publicacion::updateOrCreate(['id' => $publicacion->id], ['img_url' => $url]);

        }   
    }

    public function borrar(Request $request){
        Publicacion::findOrFail($request->id)->delete();
    }

}
