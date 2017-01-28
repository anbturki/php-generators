<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Overhaul extends Model
{
    protected $fillable = ['description'];
//    protected $dates = ['created_at'];
    public function generator(){
        return $this->belongsTo(Generator::class);
    }


}
