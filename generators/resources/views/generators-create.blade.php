@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Add New Generator</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('generators.store')}}" method="POST" class="form-horizontal" role="form">
                        {{csrf_field()}}
                        <!-- //Generator Name -->
                        <div class="form-group row @if($errors->has('generator_name')) {{'has-warning'}} @endif">
                          <label for="generator-name" class="col-xs-3 col-form-label">{{trans('generators.Generator_Name')}}</label>
                          <div class="col-xs-9">
                            <input class="form-control" 
                                   type="text" 
                                   name="generator_name"
                                   value="{{old('generator_name')}}" 
                                   id="generator-name" 
                                   placeholder="{{trans('generators.Generator_Name')}}">
                                   @if($errors->has('generator_name'))
                                    <span class="help-block">{{$errors->first('generator_name')}}</span>
                                   @endif
                          </div>
                        </div>

                        <!-- //Generator Area -->
                        <div class="form-group row @if($errors->has('generator_area')) {{'has-warning'}} @endif">
                          <label for="generator-area" class="col-xs-3 col-form-label">{{trans('generators.Generator_Area')}}</label>
                          <div class="col-xs-9">
                            <input  class="form-control" 
                                    type="text" 
                                    name="generator_area"
                                   value="{{old('generator_area')}}" 
                                    id="generator-area"  
                                    placeholder="{{trans('generators.Generator_Area')}}">
                            @if($errors->has('generator_area'))
                              <span class="help-block">{{$errors->first('generator_area')}}</span>
                            @endif
                          </div>
                        </div>

                        <!-- //Generator maintenance -->
                        <div class="form-group row @if($errors->has('maintenance_deuration')) {{'has-warning'}} @endif">
                          <label for="maintenance-deuration" class="col-xs-3 col-form-label">{{trans('generators.Maintenance_Deuration')}} ( Days )</label>
                          <div class="col-xs-9">
                            <input  class="form-control" 
                                    type="number"
                                    name="maintenance_deuration"
                                   value="{{old('maintenance_deuration')}}" 
                                    id="maintenance-deuration"  
                                    placeholder="{{trans('generators.Maintenance_Deuration')}}">
                            @if($errors->has('maintenance_deuration'))
                              <span class="help-block">{{$errors->first('maintenance_deuration')}}</span>
                            @endif
                          </div>
                        </div>

                        
                        <!-- //Generator Storage Capacity -->
                        <div class="form-group row ">
                          <div class="col-xs-12">
                        <h3> {{trans('generators.Diesel_Informations')}} </h3>
                          </div>
                        </div>
                        <!-- //Generator Storage Capacity -->
                        <div class="form-group row @if($errors->has('storage_capacity')) {{'has-warning'}} @endif">
                          <label for="storage-capacity" class="col-xs-3 col-form-label">{{trans('generators.Storage_Capacity')}}</label>
                          <div class="col-xs-9">
                            <input  class="form-control" 
                                    type="number" 
                                    name="storage_capacity"
                                    value="{{old('storage_capacity')}}" 
                                    id="storage-capacity"  
                                    placeholder="{{trans('generators.Storage_Capacity')}}">
                            @if($errors->has('storage_capacity'))
                              <span class="help-block">{{$errors->first('storage_capacity')}}</span>
                            @endif
                          </div>
                        </div>
                        <!-- //Generator Daily Intake -->
                        <div class="form-group row @if($errors->has('dialy_intake')) {{'has-warning'}} @endif">
                          <label for="storage-capacity" class="col-xs-3 col-form-label">{{trans('generators.Daily_Intake')}}</label>
                          <div class="col-xs-9">
                            <input  class="form-control" 
                                    type="number"
                                    name="dialy_intake"
                                    value="{{old('dialy_intake')}}" 
                                    id="storage-intake"  
                                    placeholder="{{trans('generators.Daily_Intake')}}">
                            @if($errors->has('dialy_intake'))
                              <span class="help-block">{{$errors->first('dialy_intake')}}</span>
                            @endif
                          </div>
                        </div>
                        <!-- //Generator Daily Intake -->
                        <div class="form-group row @if($errors->has('minimum')) {{'has-warning'}} @endif">
                          <label for="storage-capacity" class="col-xs-3 col-form-label">Minimum</label>
                          <div class="col-xs-9">
                            <input  class="form-control" 
                                    type="number"
                                    name="minimum"
                                    value="{{old('minimum')}}" 
                                    id="storage-intake"  
                                    placeholder="Minimum">
                            @if($errors->has('minimum'))
                              <span class="help-block">{{$errors->first('minimum')}}</span>
                            @endif
                          </div>
                        </div>
                        <!-- //Generator Description Or More Details -->

                        <!-- //overhauls -->
                        <div class="form-group row ">
                          <div class="col-xs-12">
                        <h3> Overhaul </h3>
                          </div>
                        </div>
                        <!-- //Overhaul Duration -->
                        <div class="form-group row @if($errors->has('overhaul')) {{'has-warning'}} @endif">
                          <label for="overhaul_duration" class="col-xs-3 col-form-label">Overhaul duration</label>
                          <div class="col-xs-9">
                            <input  class="form-control"
                                    type="number"
                                    name="overhaul_duration"
                                    value="{{old('overhaul_duration')}}"
                                    id="overhaul-duration"
                                    placeholder="overhaul duration by hours">
                            @if($errors->has('overhaul_duration'))
                              <span class="help-block">{{$errors->first('overhaul_duration')}}</span>
                            @endif
                          </div>
                        </div>
                        <!-- //Generator Daily Intake -->
                        <div class="form-group row @if($errors->has('last_overhaul')) {{'has-warning'}} @endif">
                          <label for="last-overhaul" class="col-xs-3 col-form-label">Last overhaul</label>
                          <div class="col-xs-9">
                            <input  class="form-control"
                                    type="date"
                                    name="last_overhaul"
                                    value="{{old('last_overhaul')}}"
                                    id="last-overhaul"
                                    placeholder="Enter last overhaul if exists">
                            @if($errors->has('last_overhaul'))
                              <span class="help-block">{{$errors->first('last_overhaul')}}</span>
                            @endif
                          </div>
                        </div>
                        <!-- //status -->
                        <div class="form-group row @if($errors->has('status')) {{'has-warning'}} @endif">
                          <label for="last-overhaul" class="col-xs-3 col-form-label">Status</label>
                          <div class="col-xs-9">
                              <select name="status" id="status" class="form-control">
                                  <option value="1">On</option>
                                  <option value="0">Off</option>
                              </select>
                            @if($errors->has('status'))
                              <span class="help-block">{{$errors->first('status')}}</span>
                            @endif
                          </div>
                        </div>
                        <!-- //Generator Description Or More Details -->
                        <div class="form-group row">
                          <label for="more-info" class="col-xs-12 col-form-label">{{trans('generators.More_Details')}}</label>
                          <div class="col-xs-12">
                            <textarea
                              class="form-control" 
                              id="more-info" rows="8"
                              name="more_info">{{old('more_info')}}</textarea>
                          </div>
                        </div>

                          <div class="form-group row">
                          <div class="col-xs-10 ">
                          <button class="btn btn-primary">Save</button>
                          </div>
                        </div>


                    </form>

                  </div>
                </div>
            </div>
        </div>
    </div>
@endSection
