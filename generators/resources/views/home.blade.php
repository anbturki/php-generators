@extends('layouts.app')

@section('content')

<div class="page-content">
@if(session()->has('success'))

<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Success</strong> {{session('success')}} ...
</div>

@endif
    <a class="btn btn-primary printable" href="{{route('dashboard::index')}}"><i class="fa fa-print"></i> Print</a>

    <section id="generator-maintenance">
        <div class="row">
        @foreach($generators as $g)
                <div class="col-md-3 col-sm-6 col-xs-12 generator-card">
                    <div class="card">
                        <div class="title">
                            {!! $g->callAllNeeded() !!}
                        </div>
                        <div class="caption">
                            <a href="{{route('generators.show',$g->id)}}" class="floating"><span class="fa fa-chevron-right plus"></span></a>
                            <p><span>ID: </span>{{$g->name}}</p>
                            <p><span>Area : </span>{{$g->area}}</p>
                        </div>
                            <div class="actions-btn text-center">
	                            @if($g->need_diesel)
                                    <a href="{{route('diesel.fill',$g->id)}}" class="btn btn-primary modal-btn btn-xs" data-modal-size="modal-sm">Fill Diesel</a>

	                            @endif
								 @if($g->need_maintenance)
								 <a href="{{route('maintenances.create',$g->id)}}" class="  btn btn-primary modal-btn btn-xs">Maintenance</a>
								 @endif
								 @if($g->need_overhaul)
								 <a href="{{route('overhauls.create',$g->id)}}" class="  btn btn-primary modal-btn btn-xs">Overhaul</a>
								 @endif
                    </div>
                </div>
</div>
        @endforeach
        </div>
        {{$generators->links()}}
    </section>


<style type="text/css">
	.generator-card{
		margin: 10px auto
	}
	.actions-btn{
		background-color: #f3f3f3;
		padding: 10px
	}

    .generator-card .card .title{
        min-height:150px;
    }

	.btn-primary {
    color: #fff;
    background-color: #847b9c;
    border-color: #847b9c;
}
</style>
@include('inc.modal')
@include('inc.alert')
</div>
@endsection
