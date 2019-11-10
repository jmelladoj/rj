<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'nombre' => $this->nombre,
            'telefono' => $this->celular,
            'edad' => $this->edad,
            'busto' => $this->busto,
            'cintura' => $this->cintura,
            'caderas' => $this->caderas,
            'perfil_url' => $this->perfil_url,
            'ciudad' => $this->ciudad,
            'whatsapp' => $this->linkWhatsapp,
            'actualizado' => $this->ultimaActualizacion,
            'nota' => $this->nota,
            'video' => $this->video
        ];
    }
}
