<h3>Count: {{$generators->count()}}</h3>
<div class="printable-page">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{trans('generators.Generator_Area')}}</th>
                <th>{{trans('generators.Storage_Capacity')}}</th>
                <th>Diesel</th>
                <th>Maintenance at</th>
                <th>Overhaul at</th>
                <th>Status</th>
                <th>Turned On At</th>
                <th>Turned Off At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($generators as $g)
                <tr>
                    <td>{{$g->name}}</td>
                    <td> {{$g->area}} </td>
                    <td>{{$g->storage_capacity}}L</td>
                    <td>
                        @if($g->checkIfDieselTankIsEmpty())
                            Empty
                        @else
                            {{round($g->calcUsedAtWorkingAndRemaining())}}
                        @endif
                             | {{round($g->remainingDieselPercent())}}%
                    </td>
                    <td>{{$g->nextMaintenance()}}</td>
                    <td>
                        @if($g->overhaulNextOne())
                            {{$g->overhaulNextOne()->toDateString()}}
                        @else
                            Unknown
                        @endif

                    </td>
                    <td>{{$g->status?"Working":"Not working"}}</td>
                    <td>{{$g->turned_on->format('d-m-y g:i A')}}</td>
                    <td>{{$g->turned_off->format('d-m-y g:i A')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .table > thead > tr > th{
        text-align: left;
    }
    @page{
        margin: 0;
    }
</style>

