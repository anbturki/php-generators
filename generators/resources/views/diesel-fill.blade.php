<form action="{{route('diesel.fill.store',$generator->id)}}" method="post" class="form-inline text-center" role="form">
    {{csrf_field()}}
	<div class="form-group">
		<label class="sr-only" for="">label</label>
		<input type="number" class="form-control" name="diesel" id="" placeholder="Enter Liters">
	</div>

	<button type="submit" class="btn btn-primary">Fill Up Now</button>
</form>
