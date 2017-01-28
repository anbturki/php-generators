<section class="generator-create">

    <form action="{{route('overhauls::store',$g->id)}}" id="create-m" method="POST" role="form">
      <legend>Overhaul Details</legend>
      {!! csrf_field() !!}
      <div class="form-group">
        <textarea class="form-control" id="create-overhaul"  rows="10" name="description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>

</section>
