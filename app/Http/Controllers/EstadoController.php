<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;
use App\User;
use Illuminate\Support\Facades\Storage;

class EstadoController extends Controller
{
    //
    public function indexUser(){       
        $estados = Estado::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return ['estados' => $estados];
    }
    public function crearVideoEstado(Request $request){
        $usuario = User::find(\Auth::user()->id);
        $num_estados = Estado::get('user_id', $usuario->id)->count();

        $video = $request->file('video');
        $nombre = $usuario->id . '-' . ($num_estados + 1) . '.webm';
        
        $url = Storage::putFileAs(
            'videos_estado', $video, $nombre, 'public'
        );

        $estado = new Estado();
        $estado->estado_url = $url;

        if($request->usuario_id != 0){
            $estado->user_id = $request->usuario_id;
        } else {
            $estado->user_id = \Auth::user()->id;
        }

        $estado->save();
    }
}
