<?php

namespace App\Http\Controllers;

use App\Aviso;
use App\Ciudad;
use App\Publicacion;
use App\User;
use Illuminate\Http\Request;
use SEO;
use SEOMeta;
use OpenGraph;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        SEO::setTitle('Las mejores escort de Concepción - PlacerConce.cl');
        SEO::setDescription('Las mejores escort, escorts, prostitutas, putas y damas de compañia de concepcion te esperan');
        SEO::opengraph()->setUrl('https://www.placerconce.cl/');
        SEO::setCanonical('https://www.placerconce.cl/');
        SEOMeta::addKeyword(['escort', 'escorts', 'prostitutas' , 'damas de compañia', 'concepcion', 'escort concepcion', 'escorts en concepcion', 'postitutas en concepcion', 'damas de compañia en concepcion', 'conce']);

        OpenGraph::setDescription('Las mejores escort, escorts, prostitutas, putas y damas de compañia de concepcion te esperan');
        OpenGraph::setTitle('Las mejores escort de Concepción - PlacerConce.cl');
        OpenGraph::setUrl('https://www.placerconce.cl/');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        if(\Auth::user()->tipo_usuario == 1){
            return view('admin.contenido');
        } else {
            return view('usuario.contenido');
        }
        
    }

    public function inicio(){
        return view('inicio');
    }

    public function inicioConcepcion(){
        return view('concepcion');
    }

    public function modelo($id){
        $usuario = User::findOrFail($id);

        return view('modelo')->with(compact('usuario'));
    }

    public function aviso($id){
        $aviso = Aviso::findOrFail($id);
        $usuario = User::findOrFail($aviso->user_id);

        return view('aviso')->with(compact('aviso', 'usuario'));
    }

    public function publicacion($id){
        $publicacion = Publicacion::findOrFail($id);

        return view('publicacion')->with(compact('publicacion'));
    }

    public function ventas(){
        return view('venta');
    }

    public function videos(){
        return view('videos');
    }

    public function valoradas(){
        return view('valoradas');
    }
}
