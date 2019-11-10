<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Publicacion extends Model
{
    //
    protected $table = 'publicaciones';

    protected $fillable = [
        'img_url'
    ];

    public function getUltimaActualizacionAttribute(){
        return Carbon::parse($this->updated_at)->diffInHours(Carbon::now());
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
