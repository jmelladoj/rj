<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'nombre','telefono', 'edad', 'usuario', 'sexo', 'ciudad_id', 'nacionalidad', 'password','altura', 'busto', 'cintura', 'caderas', 'descripcion', 'tipo_usuario', 'perfil_url', 'foto_uno_url', 'foto_dos_url', 'foto_tres_url', 'foto_cuatro_url', 'foto_cinco_url', 'foto_seis_url', 'foto_siete_url', 'foto_ocho_url', 'foto_nueve_url', 'foto_diez_url', 'foto_once_url', 'foto_doce_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFotosAttribute(){
        $fotos = array();

        if($this->foto_uno_url != null) array_push($fotos, $this->foto_uno_url);
        if($this->foto_dos_url != null) array_push($fotos, $this->foto_dos_url);
        if($this->foto_tres_url != null) array_push($fotos, $this->foto_tres_url);
        if($this->foto_cuatro_url != null) array_push($fotos, $this->foto_cuatro_url);
        if($this->foto_cinco_url != null) array_push($fotos, $this->foto_cinco_url);
        if($this->foto_seis_url != null) array_push($fotos, $this->foto_seis_url);
        if($this->foto_siete_url != null) array_push($fotos, $this->foto_siete_url);
        if($this->foto_ocho_url != null) array_push($fotos, $this->foto_ocho_url);
        if($this->foto_nueve_url != null) array_push($fotos, $this->foto_nueve_url);
        if($this->foto_diez_url != null) array_push($fotos, $this->foto_diez_url);
        if($this->foto_once_url != null) array_push($fotos, $this->foto_once_url);
        if($this->foto_doce_url != null) array_push($fotos, $this->foto_doce_url);
        
        return $fotos;
    }

    public function getCiudadAttribute(){
        switch ($this->ciudad_id) {
            case 1:
                return "Concepción";
                break;
            case 2:
                return "Chillán";
                break;
            case 3:
                return "Los Ángeles";
                break;
            default:
                return "Desconocido";
                break;
        }
    }

    public function getLinkWhatsappAttribute(){
        return 'https://api.whatsapp.com/send?phone=56' . $this->telefono . '&text=Cont%C3%A1cto%20desde%20placerconce.cl'; 
    }

    public function getCelularAttribute(){
        return '+56 ' . $this->telefono;
    }

    public function getUltimaActualizacionAttribute(){
        
        return Carbon::parse($this->updated_at)->diffInHours(Carbon::now());
    }

    public function getNotaAttribute(){
        $calificaciones = $this->hasMany(ValoracionUsuario::class, 'user_id');

        return $calificaciones->count() > 0 ? (int) $calificaciones->avg('nota') : 0;
    }

    public function getVideoAttribute(){
        $videos = $this->HasMany(Video::class, 'user_id');

        if($this->video_url == null || $this->video_url == '' || $videos->count() == 0){
            return 0;
        } else {  
            return 1;
        }
    }
}
