<div class="printable-page">
<h3>Count: {{$generators->count()}}</h3>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Generator</th>
			<th>Area</th>
			<th>Needs</th>
		</tr>
	</thead>
	<tbody>
    @foreach($generators as $g)
        <tr>
            <td>{{$g->name}}</td>
            <td>{{$g->area}}</td>
            <td>{!! $g->callAllNeeded() !!}</td>
        </tr>
        @endforeach
	</tbody>
</table>
</div>
<style>
    .table > thead > tr > th{
        text-align: left;
    }
    .printable-page{
        font-size: 20px;
    }
</style>
