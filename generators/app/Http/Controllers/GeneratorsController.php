<?php

namespace App\Http\Controllers;

use App\Difference;
use App\Overhaul;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Generator;
use App\Maintenance;
use App\Diesel;
use Response;
class GeneratorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('printable')){
            $generators = Generator::orderBy('need_maintenance','DESC')
                ->orderBy('need_diesel','DESC')
                ->orderBy('need_overhaul','DESC')
                ->orderBy('status','DESC')
                ->get();

            return view('print.generator-index-print',compact('generators'));
        }

        if(!$request->ajax()){

            if($request->has('query')){
                
               return $this->search($request);
            }
            $generators = Generator::orderBy('need_maintenance','DESC')
                                    ->orderBy('need_diesel','DESC')
                                    ->orderBy('need_overhaul','DESC')
                                    ->orderBy('status','DESC')
                                    ->paginate(10);

            return view('generators',['generators'=>$generators]);

        }

        return $this->searchAjax($request);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('generators-create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'generator_name'        =>'required|min:5',
            'generator_area'        =>'required',
            'maintenance_deuration' =>'required|integer|min:0',
            'storage_capacity'      =>'required|integer|min:0',
            'dialy_intake'          =>'required|integer|min:0',
            'overhaul_duration'     =>'min:0|integer',
            'last_overhaul'         =>'date',
            'status'     =>'boolean',
        ]);
        

        $generator = new Generator;
        $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img><a>';
        $allowedTags.='<li><ol><ul><span><div><br><ins><del><div>';
        $sContent = strip_tags(stripslashes($request->input('more_info')),$allowedTags);

        $generator->name = $request->input('generator_name');
        $generator->area = $request->input('generator_area');
        $generator->duration = $request->input('maintenance_deuration');
        $generator->storage_capacity = $request->input('storage_capacity');
        $generator->daily_use = $request->input('dialy_intake');
        $generator->overhaul = $request->input('overhaul_duration');
        $generator->status = $request->status;
        $generator->turned_on = Carbon::now();
        $generator->turned_off = Carbon::now();
        $generator->more_info = $sContent;
        if($request->minimum){$generator->minimum = $request->input('minimum');}
        $generator->save();
        $generator->maintenances()->save(new Maintenance(['description'=>'The default maintenance...']));
        $overhaul = new Overhaul;
        $overhaul->created_at = new Carbon($request->last_overhaul);
        $generator->overhauls()->save($overhaul);
        $diesel = new Diesel;
        $diesel->remaining = $generator->storage_capacity;
        $generator->diesel()->save($diesel);

        return redirect()->route('generators.show',$generator->id)->with('success','Generator have been stored..');
    }


    public function show(Generator $generator,Request $request)
    {
        if($request->ajax() && $request->has('printable')){
            return view('print.generator-show-print',compact('generator'));
        }
        return view('generator-show',compact(['generator']));
    }

    public function edit(Generator $generator,Request $request)
    {
        if($request->ajax()){
          return view('generator-edit',compact('generator'));
        }

        return back();
    }

    public function update(Request $request, Generator $generator)
    {

        $this->validate($request,[
            'name'        =>'required|min:5',
            'area'        =>'required',
            'minimum'     => 'min:0|integer',
            'duration' =>'required|integer|min:0',
            'overhaul_duration' =>'integer|min:0',
            'storage_capacity'      =>'required|integer|min:0',
            'daily_use'          =>'required|integer'
        ]);


        $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img><a>';
        $allowedTags.='<li><ol><ul><span><div><br><ins><del><div>';
        $sContent = strip_tags(stripslashes($request->input('more_info')),$allowedTags);

        $generator->name = $request->input('name');
        $generator->area = $request->input('area');
        $generator->duration = $request->input('duration');
        $generator->storage_capacity = $request->input('storage_capacity');
        $generator->daily_use = $request->input('daily_use');
        $generator->more_info = $sContent;
        $generator->minimum = $request->input('minimum');
        if($request->has('overhaul_duration')):$generator->overhaul = $request->input('overhaul_duration');endif;
        $generator->update();
        return "the generator has been updated";
    }

   

    private function searchAjax(Request $request){
        $query = $request->input('query');
        $generators = Generator::where('name','LIKE',"%$query%")
                    ->orWhere('created_at','LIKE',"%$query%")
                    ->orWhere('created_at','LIKE',"%$query%")
                    ->orWhereHas('maintenances',function($q) use ($query){
                        $q->where('created_at','LIKE',"%$query%");
                    })
                    ->orWhere('area','LIKE',"%$query%")->get();

        if(!$generators->isEmpty()){
            return view('generator-search',compact('generators'));
        }

            return Response::json(['status'=>0,'msg'=>'We didn\'t find any result for ' . $query . ' sorry !']);
    }


    private function search(Request $request){

        $query = $request->input('query');
        $generators = Generator::where('name','LIKE',"%$query%")
                    ->orWhere('created_at','LIKE',"%$query%")
                    ->orWhereHas('maintenances',function($q) use ($query){
                        $q->where('created_at','LIKE',"%$query%");
                    })
                    ->orWhere('area','LIKE',"%$query%")->paginate(10);


            return view('generators',['generators'=>$generators]);


    }

    public function fillDiesel(Generator $generator){
        return view('diesel-fill',compact('generator'));
    }


    public function fillDieselStore(Generator $generator,Request $request){
        if($request->has('diesel')){
            $this->validate($request,[
               'diesel'=>'min:0|integer'
            ]);
           $generator->diesel->remaining .=  $request->diesel;
            if($generator->diesel->remaining > $generator->sorage_capacity){
                return back()->with('error','Diesel overflow the storage capacity,Try again with the correct quantity.');
            }
        }else{
            $generator->diesel->remaining = $generator->storage_capacity;
        }

        $generator->diesel->update();
        $generator->need_diesel = 0;
        $generator->turned_on = Carbon::now();
        $generator->update();
        return back()->with('success','The Generator has been filled');
    }


    public function delete(Request $request){
    $g = Generator::find($request->deleteData);
    foreach ($g as $v) {
        $v->delete();
    }

    return;

    }

    public function status(Generator $generator){

        $generator->status = !$generator->status;
        $generator->diesel->remaining = $generator->calcUsedAtWorkingAndRemaining();
        if($generator->status){
            $generator->turned_on = Carbon::now();
        }else{
            $generator->turned_off = Carbon::now();
        }
        $generator->update();
        $generator->diesel->update();
        return back();
    }

    public function storeDiff(Request $request,Generator $generator){
        $this->validate($request,['diff'=>'required']);
        $diff = new Difference;
        $diff->difference = $request->diff;
        $generator->differences()->save($diff);
        return "Done";
    }

    public function deleteDiff(Request $request){
        return Difference::destroy($request->deleteData);
    }



}
