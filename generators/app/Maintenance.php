<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    
    protected $fillable = ['description'];

    public function generator(){
    	return $this->belongsTo('App\Generator');
    }
}
