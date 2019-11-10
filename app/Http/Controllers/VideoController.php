<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    //
    public function indexUser($id){
        $videos = Video::where('user_id', $id)->orderBy('titulo', 'asc')->get();

        return [
            'videos' => $videos
        ];
    }

    public function indexUserAuth(){
        $videos = Video::where('user_id', \Auth::user()->id)->orderBy('titulo', 'asc')->get();

        return [
            'videos' => $videos
        ];
    }

    public function crear_administrador(Request $request)
    {   
        if ($request->hasFile('video')) {

            $video = new Video();
            $video->titulo = $request->titulo;
            $video->video_url = Storage::disk('public')->putFile('videos_usuarios', $request->file('video'));
            $video->user_id = $request->usuario_id;
            $video->save();
        } 
    }

    public function crear_usuario(Request $request)
    {   
        if ($request->hasFile('video')) {

            $video = new Video();
            $video->titulo = $request->titulo;
            $video->video_url = Storage::disk('public')->putFile('videos_usuarios', $request->file('video'));
            $video->user_id = \Auth::user()->id;
            $video->save();
        } 
    }

    public function eliminar(Request $request){
        $video = Video::findOrFail($request->id);
        
        Storage::delete($video->video_url);

        $video->delete();
    }
}
