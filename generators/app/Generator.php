<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Config;

class Generator extends Model
{

    protected $dates = ['created_at','updated_at','turned_off','turned_on'];

    public function maintenances(){
    	return $this->hasMany('App\Maintenance');
    }
    public function differences(){
    	return $this->hasMany('App\Difference');
    }

    public function diesel(){
        return $this->hasOne(Diesel::class);
    }

    public function overhauls(){
        return $this->hasMany(Overhaul::class);
    }


        public function getCreatedAtAttribute($value)
    {

        return Carbon::createFromTimestamp(strtotime($value));
    }

    


    public function lastMstamp(){

        $created = $this->maintenances()->orderBy('created_at','DESC')->first();
        if($created){

            return $created->created_at;
        }

        return;

    }

    

    public function lastMaintenance(){

    	if($this->lastMstamp()){
            return $this->lastMstamp()->toDateString();
        }

        return;
    }


    public function nxtMstamp(){

	$created = $this->maintenances()->orderBy('created_at','DESC')->first();
	if($created){
        return $created->created_at->addDays($this->duration);
    }

    return;

    }



    public function nextMaintenance(){
        if($this->nxtMstamp() && $this->nxtMstamp()->subDay()->isToday() && $this->need_maintenance == 0){
                $this->need_maintenance = 1;
                $this->update();
        }

      if($this->nxtMstamp())
        {
        return    $this->nxtMstamp()->toDateString();
        }

        return "Unknown";

    }

    public function getOverMaintenance(){
        $now = Carbon::now();
        if($this->nxtMstamp() && $this->nxtMstamp() < $now){
            return $this->nxtMstamp()->diffForHumans();
        }

        return $this->nextMaintenance();
    }






     public function delete()
    {
        // delete all associated maintenances
        $this->maintenances()->delete();
        // delete all associated diesel
        $this->diesel()->delete();
        // delete all associated overhauls
        $this->overhauls()->delete();

        // delete the generator
        return parent::delete();
    }



    public function callAllNeeded(){

        if($this->need_maintenance && $this->need_diesel && $this->need_overhaul){
            return "<h4>Maintenance</4><h4>Diesel</4><h4>Overhaul</h4>";
        }elseif($this->need_diesel){
            return "<h4>Diesel</4>";
        }elseif($this->need_maintenance){
            return "<h4>Maintenance</4>";
        }elseif($this->need_overhaul){
            return "<h4>Overhaul</4>";
        }

        return;
    }


    //Diesel

 /*
  * Get Difference Between Turned On And Turned Off
  * And Check If The Turned On Is The Last Status
  * And Get Difference Between Turned On And Now
  */
    public function diffBetweenTurnedOnAndNow(){
        $diff = $this->turned_off->diffInSeconds($this->turned_on,false);
        if($diff > 0){
            return $this->turned_on->diffInMinutes(Carbon::now(),false);
        }
        return 0;
    }


//  Getting How Much Of Diesel Used In A Minute
    public function convertDailyUsedOfDiesel(){
        $dieselUsedInMinutes = ($this->daily_use / 24) / 60;
        return $dieselUsedInMinutes;
    }


//  Calculation How Much Of Diesel Used In A Minute
    public function calcHowManyDieselUsedAtWorking(){
        return $this->diffBetweenTurnedOnAndNow() * $this->convertDailyUsedOfDiesel();
    }

//    Getting How Many Of Diesel Used From Turned On A Generator Until Now And How Much Remaining Of Diesel
    public function calcUsedAtWorkingAndRemaining(){
        return $this->diesel->remaining - $this->calcHowManyDieselUsedAtWorking();
    }

    // Check If The Diesel less Than Minimum Point And Change The Status Of Needed Diesel To Alert Theme In Dashboard
    public function checkIfDieselLessThanMinimum(){
        $remainng_diesel = $this->calcUsedAtWorkingAndRemaining();
        if($remainng_diesel <= $this->minimum && $this->need_diesel != 1){
            $this->need_diesel = 1;
            $this->update();
        }
        if($this->need_diesel == 1){
            return true;
        }
        return false;
    }

//    public function dieselRemainingInInt(){}

//    Check If Diesel Tank Is Empty
    public function checkIfDieselTankIsEmpty(){
        if($this->calcUsedAtWorkingAndRemaining() <= 0){
            return true;
        }
        return false;
    }

    //Convert Diesel To Percent
    public function remainingDieselPercent(){
        if(!$this->checkIfDieselTankIsEmpty()){
            return ($this->calcUsedAtWorkingAndRemaining() / $this->storage_capacity) * 100;
        }

        return 0;
    }

    //End diesel

    //Overhauls Dummy
    /*public function addOver(){
        $over = new Overhaul();
        $this->overhauls()->save($over);
    }*/

//    Overhauls

    // get the last one of overhauls
    public function overhaulLastOne(){
        $created = $this->overhauls()->orderBy('created_at','DESC')->first();
        return $created;
    }

    public function overhaulNextOne(){

        $lastOne = $this->overhaulLastOne();
        if($lastOne){
            $days = $this->overhaul / 24;
            return $lastOne['created_at']->addDays($days);
        }
        return false;

    }


//    change need overhaul status
    public function overhaulChangeStatus(){
        if($this->overhaulNextOne() && $this->overhaulNextOne() <= Carbon::now() || $this->overhaulNextOne()->isToday() && $this->need_overhaul ==0 ){
            $this->need_overhaul = 1;
            $this->update();
        }
    }


}
