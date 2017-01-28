@extends('layouts.app')

@section('content')
	<div class="page-content">
	<a class="btn btn-primary printable" href="{{route('maintenances::index')}}"><i class="fa fa-print"></i> Print</a>

	<div id="msg"></div>
        <div class="row">
            <div class="col-md-12">
            @include('inc.search')
            	 <h4 class="remove-btn">
	            	<a href="#"
	            	 class="btn btn-default remove-btn alert-link"
	            	 data-do="removeHock('{{route("maintenances::delete")}}')"
	            	 data-heading="Are you sure ?"
	            	 data-msg="this maintenance will be removed and you cannot restore that agien"
	            	 >Remove</a>


	            	 <span id="item-cont"></span>
            	 </h4>
            @if(session('success'))
            <div class="alert alert-success">
            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            	<strong>Success!</strong> {{session('success')}} ...
            </div>
            @endif
					<div class="generators-table">
					<div class="card">
					    <div class="table-responsive">
					    	<table class="table table-hover table-striped">
					    		<thead>
					    			<tr>
					    				<th>
						                    <div class="checkbox checkbox-primary  checkbox-circle">
						                        <input id="mainChekbox" type="checkbox" name="remove[]">
						                        <label for="mainChekbox"></label>
						                    </div>
					    				</th>
					    				<th>Generator ID</th>
					    				<th>Area</th>
					    				<th>Date</th>
					    				<th>Details</th>
					    				<th>Display</th>
				    				</tr>
					    		</thead>
					    		<tbody>
					    			<?php  $i = 0; ?>
					    			@foreach($maintenances as $m)
					    			<?php $i++ ?>
					    			<tr>
					    				<td>
						                    <div class="checkbox checkbox-primary  checkbox-circle">
						                        <input id="checkbox{{$i}}" type="checkbox" value="{{$m->id}}" name="remove[]" class="removing">
						                        <label for="checkbox{{$i}}"></label>
						                    </div>
						                    </td>
					    				<td><a href="{{route('generators.show',$m->generator->id)}}">{{$m->generator->name}}</a></td>
					    				<td>{{$m->generator->area}}</td>
					    				<td>{{$m->created_at->toDateString()}}</td>
					    				<td>
					    					@if($m->description)
												{{strip_tags(str_limit($m->description,25))}}
					    					@else
					    						<p class="label label-primary">There are no details</p>
					    					@endif
					    				</td>
										<td><a href="{{route('maintenances.show',$m->id)}}" class="modal-btn btn btn-info">Display</a></td>

					    			</tr>
					    			@endforeach
					    		</tbody>
					    	</table>
					    </div>
					    <p class="pg-count"><strong>Total:</strong> {{$maintenances->total()}} | <strong>Current items:</strong> {{$maintenances->count()}}</p>

					</div>
					    <h4 class="remove-btn">
	            	<a href="#"
	            	 class="btn btn-default remove-btn alert-link"
	            	 data-do="removeHock('{{route("generator::delete")}}')"
	            	 data-heading="Are you sure ?"
	            	 data-msg="this generators will be removed and you cannot restore that agien"
	            	 >Remove</a>


	            	 <span id="item-cont"></span>
            	 </h4>

                	{!! $maintenances->links() !!}
					</div>

            </div>
        </div>

    <script>
    	var searchURI = "{{route('maintenances::index')}}";
    </script>
    <style>
    	.table > thead > tr > th{
    		text-align: left;
    	}
    </style>
@include('inc.modal')
@include('inc.alert')
</div>
@endSection
