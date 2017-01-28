<h3>Count: {{$overhauls->count()}} <strong class="text-center">Overhauls</strong></h3>
<div class="printable-page">
    <table class="table table-bordered table-striped">
        <thead>
        <th>Generator ID</th>
        <th>Area</th>
        <th>Date</th>
        <th>Details</th>
        </tr>
        </thead>
        <tbody>
        @foreach($overhauls as $m)
            <tr>
                <td>{{$m->generator->name}}</td>
                <td>{{$m->generator->area}}</td>
                <td>{{$m->created_at->toDateString()}}</td>
                <td>
                       {{strip_tags($m->description)}}
                </td>
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
