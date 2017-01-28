<h1 class="text-center">{{$overhaul->created_at->toDateString()}}</h1>
<p class="text-center">
@if($overhaul->description)
	{!! $overhaul->description !!}

@else
<strong class="text-primary">There are no details</strong>
@endif
</p>