<section class="generator-create">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>{{trans('generators.Generator_Name')}}</th>
            <th>{{trans('generators.Generator_Area')}}</th>
            <th>{{trans('generators.Storage_Capacity')}}</th>
            <th>{{trans('generators.Date_of_the_next_maintenance')}}</th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center">
            <td> {{$g->name}} </td>
            <td> {{$g->area}} </td>
            <td> {{$g->storage_capacity}} </td>
            <td> {{$g->nextmaintenance()}} </td>
          </tr>
        </tbody>
      </table>
    </div>

    <form action="{{route('maintenances.store',$g->id)}}" id="create-m" method="POST" role="form">
      <legend>Maintenance Details</legend>
      {!! csrf_field() !!}
      <div class="form-group">
        <label for="create-maintenance">{{trans('generators.Maintenance')}}</label>
        <textarea class="form-control" id="create-maintenance"  rows="10" name="description"></textarea>
      </div>
    
      
    
      <button type="submit" class="btn btn-primary">Save</button>
    </form>

</section>
