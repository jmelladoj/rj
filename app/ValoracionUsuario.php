<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValoracionUsuario extends Model
{
    //
    public function getFechaAttribute(){
        return $this->created_at->format('d-m-Y');
    }
}
