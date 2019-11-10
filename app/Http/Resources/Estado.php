<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Estado extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'estado_url' => $this->estado_url,
            'nombre' => $this->usuario->nombre,
            'perfil_url' => $this->usuario->perfil_url,
            'creado' => $this->creadoHace
        ];
    }
}
