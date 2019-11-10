<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;

class CiudadController extends Controller
{
    //
    public function index_administrador(Request $request){
        if (!$request->ajax() || \Auth()->user()->tipo_usuario != 1) return redirect('/');
        
        $ciudades = Ciudad::orderBy('nombre', 'asc')->withTrashed()->get();

        return [
            'ciudades' => $ciudades
        ];
    }

    public function index_usuario(Request $request){
        if (!$request->ajax()) return redirect('/');
        
        $ciudades = Ciudad::orderBy('nombre', 'asc')->get();

        return [
            'ciudades' => $ciudades
        ];
    }


    public function crear(Request $request)
    {
        $ciudad = new Ciudad();
        $ciudad->nombre = $request->nombre;
        $ciudad->save();
    }

    public function actualizar(Request $request)
    {
        $ciudad = Ciudad::withTrashed()->findOrFail($request->ciudad_id);
        $ciudad->nombre = $request->nombre;
        $ciudad->save();
    }

    public function borrar(Request $request){
        $ciudad = Ciudad::withTrashed()->findOrFail($request->id);
        $ciudad->deleted_at == null ? $ciudad->delete() :  $ciudad->restore();
    }

}
