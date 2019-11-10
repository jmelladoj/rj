<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aviso;

class AvisoController extends Controller
{
    //
    public function indexUser($id){        
        $avisos = Aviso::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return [
            'avisos' => $avisos
        ];
    }

    public function indexUserAuth(){        
        $avisos = Aviso::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return [
            'avisos' => $avisos
        ];
    }

    public function crear_administrador(Request $request)
    {    
        $aviso = new Aviso();
        $aviso->titulo = $request->titulo;
        $aviso->contenido = $request->contenido;
        $aviso->user_id = $request->usuario_id;
        $aviso->save();
    }

    public function crear_usuario(Request $request)
    {    
        $aviso = new Aviso();
        $aviso->titulo = $request->titulo;
        $aviso->contenido = $request->contenido;
        $aviso->user_id = \Auth::user()->id;
        $aviso->save();
    }

    public function eliminar(Request $request){        
        Aviso::findOrFail($request->id)->delete();
    }
}
