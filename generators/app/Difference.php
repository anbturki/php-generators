<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Difference extends Model
{
    public function generator(){
        return $this->belongsTo(Generator::class);
    }
}
