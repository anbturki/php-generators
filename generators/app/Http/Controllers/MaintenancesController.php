<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generator;
use App\Maintenance;
use Response;

class MaintenancesController extends Controller
{
    public function index(Request $request){
        if($request->ajax() && $request->has('printable')){
            $maintenances = Maintenance::all();

            return view('print.maintenance-index-print',compact('maintenances'));
        }

        if(!$request->ajax()){

            if($request->has('query')){
                
               return $this->search($request);
            }
            $maintenances = Maintenance::paginate(20);

            return view('maintenance-index',['maintenances'=>$maintenances]);

        }

        return $this->searchAjax($request);

    }

    public function create(Generator $generator){

    	return view('maintenance-create',['g'=>$generator]);
    }

    public function store(Request $request,Generator $generator){

        $generator->need_maintenance = 0;
        $generator->update();
        $generator->maintenances()->save(new Maintenance($request->all()));

        return;

    }



    public function show(Maintenance $maintenance){
        return view('maintenance-show',compact('maintenance'));
    }




    private function searchAjax(Request $request){
        $query = $request->input('query');
        $maintenances = Maintenance::where('description','LIKE',"%$query%")
                     ->orWhere('created_at','LIKE',"%$query%")
                    ->orWhereHas('generator',function($q) use ($query){
                        $q->where('name','LIKE',"%$query%");
                        $q->orWhere('area','LIKE',"%$query%");
                    })->get();
        if(!$maintenances->isEmpty()){
            return view('maintenance-search',compact('maintenances'));
        }

            return Response::json(['status'=>0,'msg'=>'We didn\'t find any result for ' . $query . ' sorry !']);
    }


    private function search(Request $request){

        $query = $request->input('query');
        $maintenances = Maintenance::where('description','LIKE',"%$query%")
                     ->orWhere('created_at','LIKE',"%$query%")
                    ->orWhereHas('generator',function($q) use ($query){
                        $q->where('name','LIKE',"%$query%");
                        $q->orWhere('area','LIKE',"%$query%");
                    })
                    ->orWhere('area','LIKE',"%$query%")->paginate(10);


            return view('maintenance-index',['maintenances'=>$maintenances]);


    }


    public function delete(Request $request){
        return Maintenance::destroy($request->deleteData);
    }

    public function searchLog(Request $request,Generator $generator){
                $query = $request->input('query');

        $maintenances = $generator->maintenances()->where('created_at','LIKE',"%$query%")
                                   ->orWhere('description','LIKE',"%$query%")->get();
        if(!$maintenances->isEmpty()){
            return view('maintenance-search-log',compact('maintenances'));
        }

            return Response::json(['status'=>0,'msg'=>'We didn\'t find any result for ' . $query . ' sorry !']);

    }


}

