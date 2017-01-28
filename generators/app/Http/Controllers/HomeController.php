<?php

namespace App\Http\Controllers;

use App\Overhaul;
use Illuminate\Http\Request;
use App\Generator;
use App\Maintenance;
use App\Diesel;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax() && $request->has('printable')){
            $generators = Generator::where('need_maintenance','1')
                ->orWhere('need_diesel','1')
                ->orWhere('need_overhaul','1')
                ->get();

            return view('print.dashboard-print',compact('generators'));
        }
        $generators = Generator::where('need_maintenance','1')
            ->orWhere('need_diesel','1')
            ->orWhere('need_overhaul','1')
            ->paginate(12);

        return view('home',compact('generators'));
    }


    public function dummyData(){
      $areas = array('Giza','haram','Cairo','October','Shubra','Maadi','Nile City');
        $storage_c = array('1500','2000','3000','6000','9000','18000','27000');
        for ($i=0; $i < 50; $i++) {
            $area_rand = array_rand($areas);
            $storage_c_rand = array_rand($storage_c);
             $generator = new Generator;
            $generator->name = 'Generator ' . $i;
            $generator->area = 'Egypt , ' . $areas[$area_rand] . ' , '. $i;
            $generator->duration = 15;
            $generator->storage_capacity = $storage_c[$storage_c_rand];
            $generator->daily_use = 100;
            $generator->minimum = 200;
            $generator->save();
            $generator->maintenances()->save(new Maintenance(['description'=>'The default maintenance...']));
            $generator->overhauls()->save(new Overhaul(['description'=>'The first overhaul...']));
            $generator->diesel()->save(new Diesel());
        }
            return redirect('/generators');
    }

}
