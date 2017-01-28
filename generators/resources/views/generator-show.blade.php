@extends('layouts.app')


@section('content')
<div class="page-content">
	@if(session('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong> {{session('success')}}...
		</div>
	@endif
	@if(session('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Error!</strong> {{session('error')}}...
		</div>
	@endif
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Validation!</strong> {{$error}}...
            </div>
        @endforeach
	@endif

<div id="msg"></div>
    <a class="btn btn-primary printable" href="{{route('generators.show',$generator->id)}}"><i class="fa fa-print"></i> Print</a>
<hr>
<div class="row">
<!-- Generator Info -->
<div class="col-md-3 mr-b">

<div class="card">
	<h3 class="card-title">Generator Info</h3>
	<div class="panel-card">

	<p><strong>ID : </strong> {{$generator->name}} </p>
	<p><strong>Area : </strong> {{$generator->area}} </p>
	<p><strong>Created At : </strong>
		@if($generator->created_at->isToday())
			Today
		@else
			{{$generator->created_at->toDateString()}}
		@endif
	 </p>
	<p>
		<strong>Last Update : </strong>
		@if($generator->updated_at->isToday())
			Today
		@else
			{{$generator->updated_at->toDateString()}}
		@endif
	</p>
	<a href="{{route('generators.edit',$generator->id)}}" class="btn btn-primary modal-btn">Update </a> </p>
	</div>
</div>

</div>
<div class="col-md-3 mr-b">

<div class="card">
	<h3 class="card-title">Generator Status</h3>
	<div class="panel-card">
		<p><strong>Status : </strong> <label class="label label-{{($generator->status)?'primary':'danger'}}">{{($generator->status)?'Working':'Not working'}}</label> </p>
<p>
		<strong>Turned on at : </strong>
	@if($generator->turned_on->isToday())
		<span class="label label-info">Today at {{$generator->turned_on->format('g:i A')}}</span>
	@else
		<span class="label label-info">{{$generator->turned_on->format('d-m-y g:i A')}}</span>
	@endif
	<label class="text-primary">{{$generator->turned_on->diffForHumans()}}</label>

</p>
	<p>
		<strong>Turned off at : </strong>
		@if($generator->turned_off->isToday())
			<span class="label label-primary">Today at {{$generator->turned_off->format('g:i A') }}</span>
		@else
			<span class="label label-primary">{{$generator->turned_off->format('d-m-y g:i A')}}</span>
		@endif
		<label class="text-primary">{{$generator->turned_off->diffForHumans()}}</label>

	</p>
		<a href="{{route('generator::status',$generator->id)}}"
			   class="btn btn-{{$generator->status?'success':'primary'}} ">{{$generator->status?'Turn Off':'Turn On'}}</a>

	</div>
</div>

</div>
<!-- maintenaces Information -->
<div class="col-md-3 mr-b">

		<div class="card">
			<h3 class="card-title">Maintenances Info</h3>
			@if(!$generator->maintenances->isEmpty())
			<div class="panel-card">
		<p><strong>Maintenance every : </strong> {{$generator->duration}}  days</p>

		<p><strong>Count : </strong> {{$generator->maintenances->count()}} </p>
	<p><strong>Last Maintenance : </strong>
		@if($generator->lastMstamp() && $generator->lastMstamp()->isToday())
			Today
		@else
	 		{{$generator->lastMaintenance()}}
		@endif
	  </p>
	<p><strong>Next Maintenace : </strong>
		@if($generator->nxtMstamp()  && $generator->nxtMstamp()->isToday())
			Today
		@else
			{{$generator->getOverMaintenance()}}
		@endif
	 </p>
	<p>{{($generator->nxtMstamp())? $generator->nxtMstamp()->diffForHumans() : 'Not Found'}} </p>
	<p><a href="{{route('maintenances.create',$generator->id)}}" class="btn btn-info btn-sm modal-btn">Maintenance</a></p>
</div>
				@else
		<div class="text-center">
			<label class="label label-danger">Unknown</label>
			<p><a href="{{route('maintenances.create',$generator->id)}}" class="btn btn-info btn-lg modal-btn">Maintenance</a></p>

		</div>
			@endif
		</div>
	<br>

</div>
<!-- Overhauls Information -->
		<div class="col-md-3 mr-b">

			<div class="card">
				<h3 class="card-title">Overhaul</h3>
				@if(!$generator->overhauls->isEmpty())
				<div class="panel-card">
					<p><strong>Count : </strong>{{$generator->overhauls->count()}}</p>
					<p><strong>Overhaul Every : </strong>{{$generator->overhaul}} Hours</p>
					<p><strong>Last Overhaul : </strong>
						@if($generator->overhaulLastOne()['created_at']->isToday())
							Today
						@else
						{{$generator->overhaulLastOne()['created_at']->toDateString()}}
						@endif
					</p>
					<p><strong>Next Overhaul : </strong>
						@if($generator->overhaulNextOne()->isToday())
							Today
						@else
							{{$generator->overhaulNextOne()->toDateString()}}
						@endif
					</p>
					<p>{{$generator->overhaulNextOne()->diffForHumans()}} </p>
					<p><a href="{{route('maintenances.create',$generator->id)}}" class="btn btn-info btn-sm modal-btn">Overhaul</a></p>
				</div>
					@else
					<div class="text-center">
						<label class="label label-danger">Unknown</label>
						<p><a href="{{route('overhauls.create',$generator->id)}}" class="btn btn-info btn-lg modal-btn">Overhaul</a></p>

					</div>
					@endif
			</div>


		</div>
		</div>
	{{--diesel--}}
		<div class="col-md-3 mr-b">
			<div class="card">
				<h3 class="card-title">Diesel Info</h3>
				<div class="panel-card">
					<p><strong>Storage Capacity : </strong> {{$generator->storage_capacity}} </p>
					<p><strong>Daily use : </strong> {{$generator->daily_use}} </p>
					<p><strong>Minimum in the tank : </strong> {{$generator->minimum}} </p>

					<div>
					<div class="myProgress">
						<div class="myBar" style="width: {{round($generator->remainingDieselPercent())}}%">{{round($generator->remainingDieselPercent())}}%</div>
					</div>

						@if(!$generator->checkIfDieselTankIsEmpty())
							<label class="label label-primary">{{round($generator->calcUsedAtWorkingAndRemaining())}}</label>

						@else
							<label class="label label-danger">Empty</label>
						@endif

					</div>
					<br>
					<p><a href="{{route('diesel.fill',$generator->id)}}" class="btn btn-info modal-btn" data-modal-size="modal-sm">Fill Diesel</a></p>

				</div>
			</div>
		</div>

	@if(!$generator->maintenances->isEmpty())
	<!-- maintenaces Log -->
		<div class="col-md-3 mr-b">
			@if($generator->maintenances->count() > 20)
				@include('inc.search')

			@endif
			<div class="card  generators-table">
				<h3 class="card-title">Maintenances Log</h3>

				<div class="main-log">

					<ul class="list-unstyled list-group">
						@foreach($generator->maintenances()->orderBy('created_at','DESC')->get() as $m)
							<li class="list-group-item">
								<div><strong>
										<a href="{{route('maintenances.show',$m->id)}}" class="modal-btn">{{$m->created_at->toDateString()}}</a>
									</strong></div>
								  {!! str_limit(strip_tags($m->description),25)!!}
							</li>
						@endforeach

					</ul>

				</div>
			</div>

		</div>
	@endif
	@if(!$generator->overhauls->isEmpty())
	<!-- maintenaces Log -->
		<div class="col-md-3 mr-b">
			@if($generator->overhauls->count() > 20)
				@include('inc.search')

			@endif
			<div class="card  generators-table">
				<h3 class="card-title">Overhauls Log</h3>

				<div class="main-log">

					<ul class="list-unstyled list-group">
						@foreach($generator->overhauls()->orderBy('created_at','DESC')->get() as $o)
							<li class="list-group-item">
								<div><strong>
										<a href="{{route('overhauls.show',$o->id)}}" class="modal-btn">{{$o->created_at->toDateString()}}</a>
									</strong></div>
								  {!! str_limit(strip_tags($o->description),25)!!}
							</li>
						@endforeach

					</ul>

				</div>
			</div>

		</div>
	@endif
	@if(!$generator->differences->isEmpty())
	<!-- differences Log -->
		<div class="col-md-3 mr-b">
			<div class="card  generators-table">
				<h3 class="card-title">Differences</h3>

				<div class="main-log">
				<?php $i=0; ?>
                            <div class="checkbox checkbox-primary text-center  checkbox-circle" style="margin:10px 0">
                                <input id="mainChekbox" type="checkbox" name="remove[]">
                                <label for="mainChekbox">Select all</label>
                            </div>

						@foreach($generator->differences()->orderBy('created_at','DESC')->get() as $diff)
				            <?php $i++; ?>
						<ul class="list-unstyled">
						    <li class="list-group-item">
						    <span class="badge badge-btn pull-left">
                                <div class="checkbox checkbox-primary  checkbox-circle">
                                    <input id="checkbox{{$i}}" type="checkbox" value="{{$diff->id}}"
                                           name="remove[]" class="removing">
                                    <label for="checkbox{{$i}}"></label>
                                </div>
                            </span>
						    {{$diff->created_at->format('d-m-Y h:i A')}} <span class="badge">{{number_format($diff->difference)}}</span>
						    </li>
						</ul>
						@endforeach
                                            </div>
                				</div>

                                            <h4 class="remove-btn">
                                                <a href="#"
                                                   class="btn btn-default remove-btn alert-link"
                                                   data-do="removeHock('{{route("diff::delete")}}')"
                                                   data-heading="Are you sure ?"
                                                   data-msg="this generators will be removed and you cannot restore that agien"
                                                ><i class="fa fa-trash"></i></a>


                                                <span id="item-cont"></span>
                                            </h4>

		</div>
	@endif
   <div class="col-md-4">
		 <div class="card">
			 <h4 class="card-title">Enter a values to get difference</h4>

		 <form class="form-horizontal" style="padding:10px" id="diff-form">

		                   <div class="form-group">
		                     <label for="old" class="col-sm-2 control-label">Old</label>
		                     <div class="col-sm-10">
		                       <input type="number" class="form-control diff-val" id="old" placeholder="Enter an old value">
		                     </div>
		                   </div>
		                   <div class="form-group">
		                     <label for="new" class="col-sm-2 control-label">New</label>
		                     <div class="col-sm-10">
		                       <input type="number" class="form-control diff-val" id="new" placeholder="Enter a new value">
		                     </div>
		                   </div>
		                   <div class="form-group">
		                     <label for="new" class="col-sm-2 control-label">Difference</label>
		                     <div class="col-sm-10 text-center">
                               <label class="label label-primary" id="diff-label">0</label>
		                     </div>
		                   </div>

		                   <div class="form-group">
		                     <div class="col-sm-offset-2 col-sm-4">
		                       <button type="button" class="btn btn-default" data-url="{{route('diff::store',$generator->id)}}" id="diff-btn">Save</button>
		                     </div>
		                   </div>
		                 </form>
</div>
	 </div>
	 @if($generator->more_info)
   <div class="col-md-8">
		 <div class="card">
			 <h3 class="card-title">More details</h3>
			 <div style="padding:10px;overflow:hidden">
			    {!! $generator->more_info !!}
			 </div>
        </div>
	 </div>
	 @endif
</div>
    <script>
    	var searchURI = "{{route('maintenances::saerch',$generator->id)}}";
    </script>
<!-- <style type="text/css">
	.input-group-btn{
		display: none;
	}
</style>
 -->

	<style>
		.list-group-item:first-child{
			border-radius: 0;
			border:none;
		}.list-group-item:last-child{
			border-bottom:none;
		}
		.mr-b{
			margin-bottom: 20px;
		}
		.mr-b .card{
			height: 280px;
			overflow-x: hidden;
			overflow-y: auto;
		}
		.badge-btn{
		    background:none;
		}
	</style>
 @include('inc.modal')
@include('inc.alert')
</div>
@endsection
