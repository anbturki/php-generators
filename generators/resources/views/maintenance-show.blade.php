<h1 class="text-center">{{$maintenance->created_at->toDateString()}}</h1>
<p class="text-center">
@if($maintenance->description)
	{!! $maintenance->description !!}

@else
<strong class="text-primary">There are no details</strong>
@endif
</p>