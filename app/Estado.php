<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Estado extends Model
{
    //
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCreadoHaceAttribute(){
        return Carbon::parse($this->created_at)->diffInHours(Carbon::now());
    }
}
