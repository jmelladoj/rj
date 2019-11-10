<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Aviso extends Model
{
    protected $table = 'avisos';

    protected $fillable = [
        'titulo','contenido', 'user_id'
    ];

    //
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUltimaActualizacionAttribute(){
        return Carbon::parse($this->updated_at)->diffInHours(Carbon::now());
    }
}
