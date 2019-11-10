<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Aviso extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'usuario' => $this->usuario->nombre,
            'perfil_url' => $this->usuario->perfil_url,
            'actualizado' => $this->ultimaActualizacion
        ];
    }
}
