<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Publicacion extends JsonResource
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
            'id' => $this->id,
            'titulo' => $this->titulo,
            'resumen' => $this->resumen,
            'imagen' => $this->img_url,
            'creado' => $this->ultimaActualizacion
        ];
    }
}
