<form action="{{route('generators.update',$generator->id)}}" id="generator-update" method="POST" class="form-horizontal" role="form">
    {{csrf_field()}}
    <!-- //Generator Name -->
    <div class="form-group row">
      <label for="name" class="col-xs-3 col-form-label">{{trans('generators.Generator_Name')}}</label>
      <div class="col-xs-9">
        <input class="form-control" 
               type="text" 
               name="name"
               value="{{$generator->name}}" 
               id="name" 
               placeholder="{{trans('generators.Generator_Name')}}">
      </div>
    </div>

    <!-- //Generator Area -->
    <div class="form-group row">
      <label for="area" class="col-xs-3 col-form-label"}">{{trans('generators.Generator_Area')}}</label>
      <div class="col-xs-9">
        <input  class="form-control" 
                type="text" 
               	name="area" 
               	value="{{$generator->area}}" 
                id="area"  
                placeholder="{{trans('generators.Generator_Area')}}">
      </div>
    </div>
        <!-- //Overhaul Duration -->
        <div class="form-group row @if($errors->has('overhaul')) {{'has-warning'}} @endif">
            <label for="overhaul_duration" class="col-xs-3 col-form-label">Overhaul duration</label>
            <div class="col-xs-9">
                <input  class="form-control"
                        type="number"
                        name="overhaul_duration"
                        value="{{$generator->overhaul}}"
                        id="overhaul-duration"
                        placeholder="overhaul duration by hours">
                @if($errors->has('overhaul_duration'))
                    <span class="help-block">{{$errors->first('overhaul_duration')}}</span>
                @endif
            </div>
        </div>

    <!-- //Generator maintenance -->
    <div class="form-group row">
      <label for="duration" class="col-xs-3 col-form-label"}">{{trans('generators.Maintenance_Deuration')}}</label>
      <div class="col-xs-9">
        <input  class="form-control" 
                type="text"
                name="duration"
               	value="{{$generator->duration}}" 
                id="duration"  
                placeholder="{{trans('generators.Maintenance_Deuration')}}">
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
      <label for="storage_capacity" class="col-xs-3 col-form-label"}">{{trans('generators.Storage_Capacity')}}</label>
      <div class="col-xs-9">
        <input  class="form-control" 
                type="text" 
               	name="storage_capacity" 
               	value="{{$generator->storage_capacity}}" 
                id="storage_capacity"  
                placeholder="{{trans('generators.Storage_Capacity')}}">
      </div>
    </div>

    <!-- //Generator Daily Intake -->
    <div class="form-group row @if($errors->has('dialy_intake')) {{'has-warning'}} @endif">
      <label for="daily_use" class="col-xs-3 col-form-label"}">{{trans('generators.Daily_Intake')}}</label>
      <div class="col-xs-9">
        <input  class="form-control" 
                type="text" 
                name="daily_use"
                value="{{$generator->daily_use}}" 
                id="daily_use"  
                placeholder="{{trans('generators.daily_use')}}">
      </div>
    </div>
    <!-- //Generator minimum -->
    <div class="form-group row @if($errors->has('minimum')) {{'has-warning'}} @endif">
      <label for="daily_use" class="col-xs-3 col-form-label"}">Minimum in the tank</label>
      <div class="col-xs-9">
        <input  class="form-control" 
                type="text" 
                name="minimum"
               	value="{{$generator->minimum}}" 
                id="daily_use"  
                placeholder="Minimum in the tank">
      </div>
    </div>

    <!-- //Generator Description Or More Details -->
    <div class="form-group row">
      <label for="more-info" class="col-xs-3 col-form-label"}">{{trans('generators.More_Details')}}</label>
      <div class="col-xs-9">
        <textarea 
          class="form-control" 
          id="more-info" rows="8"
          name="more_info">{{$generator->more_info}}</textarea>
      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="update-generator-btn">Save changes</button>
      </div>

</form>

