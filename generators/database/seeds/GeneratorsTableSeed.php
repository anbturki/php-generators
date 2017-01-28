<?php

use Illuminate\Database\Seeder;
use DB;
class GeneratorsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$areas = array('Giza','haram','Cairo','October','Shubra','Maadi','Nile City');
    	$storage_c = array('1500','2000','3000','6000','9000','18000','27000');
    	for ($i=0; $i < 50; $i++) { 
    		$area_rand = array_rand($areas);
    		$storage_c_rand = array_rand($storage_c);
    		 $generator = new App\Generator;
    		 $maintenance = new App\Maintenance;

	        $generator->name = 'Generator ' . $i;
	        $generator->area = 'Egypt , ' . $areas[$area_rand] . ' , '. $i;
	        $generator->duration = 15;
	        $generator->storage_capacity = $storage_c[$storage_c_rand];
	        $generator->daily_use = 100;
	        $generator->save();
	        $maintenance->generator_id = $generator->id;
	        $maintenance->save();
    	}
    }
}
