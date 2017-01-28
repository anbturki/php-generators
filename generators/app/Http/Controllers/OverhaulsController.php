<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generator;
use App\Overhaul;
use Response;

class OverhaulsController extends Controller
{
    public function index(Request $request){
        if($request->ajax() && $request->has('printable')){
            $overhauls = Overhaul::all();

            return view('print.overhaul-index-print',compact('overhauls'));
        }

        if(!$request->ajax()){

            if($request->has('query')){
                
               return $this->search($request);
            }
            $overhauls = overhaul::paginate(20);

            return view('overhaul-index',['overhauls'=>$overhauls]);

        }

        return $this->searchAjax($request);

    }

    public function create(Generator $generator){

    	return view('overhaul-create',['g'=>$generator]);
    }

    public function store(Request $request,Generator $generator){

        $generator->need_overhaul = 0;
        $generator->update();
        $generator->overhauls()->save(new Overhaul($request->all()));

        return;

    }



    public function show(overhaul $overhaul){
        return view('overhaul-show',compact('overhaul'));
    }




    private function searchAjax(Request $request){
        $query = $request->input('query');
        $overhauls = overhaul::where('description','LIKE',"%$query%")
                     ->orWhere('created_at','LIKE',"%$query%")
                    ->orWhereHas('generator',function($q) use ($query){
                        $q->where('name','LIKE',"%$query%");
                        $q->orWhere('area','LIKE',"%$query%");
                    })->get();
        if(!$overhauls->isEmpty()){
            return view('overhaul-search',compact('overhauls'));
        }

            return Response::json(['status'=>0,'msg'=>'We didn\'t find any result for ' . $query . ' sorry !']);
    }


    private function search(Request $request){

        $query = $request->input('query');
        $overhauls = overhaul::where('description','LIKE',"%$query%")
                     ->orWhere('created_at','LIKE',"%$query%")
                    ->orWhereHas('generator',function($q) use ($query){
                        $q->where('name','LIKE',"%$query%");
                        $q->orWhere('area','LIKE',"%$query%");
                    })
                    ->orWhere('area','LIKE',"%$query%")->paginate(10);


            return view('overhaul-index',['overhauls'=>$overhauls]);


    }


    public function delete(Request $request){
        return Overhaul::destroy($request->deleteData);
    }

    public function searchLog(Request $request,Generator $generator){
                $query = $request->input('query');

        $overhauls = $generator->overhauls()->where('created_at','LIKE',"%$query%")
                                   ->orWhere('description','LIKE',"%$query%")->get();
        if(!$overhauls->isEmpty()){
            return view('overhaul-search-log',compact('overhauls'));
        }

            return Response::json(['status'=>0,'msg'=>'We didn\'t find any result for ' . $query . ' sorry !']);

    }


}

