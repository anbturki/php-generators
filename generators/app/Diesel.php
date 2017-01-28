<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diesel extends Model
{

    public function generator(){
    	return $this->belongsto(Generator::class);
    }
}
