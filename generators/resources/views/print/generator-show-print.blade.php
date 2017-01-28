<div class="printable-page">
    <h2 class="text-center">Generator Information</h2>
    <table class="table  table-bordered">
        <thead>
        <tr>
            <th>Generator ID</th>
            <th>Area</th>
            <th>Created at</th>
            <th>Last update</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$generator->name}}</td>
            <td>{{$generator->area}}</td>
            <td>{{$generator->created_at->toDateString()}}</td>
            <td>{{$generator->updated_at->toDateString()}}</td>
        </tr>
        </tbody>
    </table>
    <br>

    <br>
    <h2 class="text-center">Generator Status</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Turned on at</th>
            <th>Turned off at</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$generator->turned_on->format('d-m-Y h:m A')}}</td>
            <td>{{$generator->turned_off->format('d-m-Y h:m A')}}</td>
            <td>{{($generator->status)?'Working':'Not working'}}</td>
        </tr>
        </tbody>
    </table>
    <br>
    <h2 class="text-center">Maintenance</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Maintenance every</th>
            <th>Count</th>
            <th>Last maintenance</th>
            <th>Next maintenance</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$generator->duration}} Days</td>
            <td>{{$generator->maintenances->count()}}</td>
            <td>{{$generator->lastMaintenance()}}</td>
            <td>{{$generator->nextMaintenance()}}</td>
        </tr>
        </tbody>
    </table>
    <br>
    <h2 class="text-center">Overhaul</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Overhauling every</th>
            <th>Count</th>
            <th>Last overhauling</th>
            <th>Next overhauling</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$generator->overhaul}} Hours </td>
            <td>{{$generator->maintenances->count()}}</td>
            <td>{{$generator->lastMaintenance()}}</td>
            <td>{{$generator->nextMaintenance()}}</td>
        </tr>
        </tbody>
    </table>
    <br>
    <h2 class="text-center">Diesel</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Storage capacity</th>
            <th>Daily use</th>
            <th colspan="2" class="text-center" style="text-align: center">Remaining</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$generator->storage_capacity}} </td>
            <td>{{$generator->daily_use}}</td>
            <td class="text-center">{{round($generator->calcUsedAtWorkingAndRemaining())}}</td>
            <td class="text-center">{{round($generator->remainingDieselPercent())}}%</td>
        </tr>
        </tbody>
    </table>
    <br>
    <h2 class="text-center">Maintenance log</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Date</th>
            <th>More details</th>
        </tr>
        </thead>
        <tbody>
        @foreach($generator->maintenances as $m )
            <tr>
                <td>{{$m->created_at->toDateString()}}</td>
                <td width="60%">{{ strip_tags($m->description) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>

    <h2 class="text-center">Overhaul log</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Date</th>
            <th>More details</th>
        </tr>
        </thead>
        <tbody>
        @foreach($generator->overhauls as $o )
            <tr>
                <td>{{$o->created_at->toDateString()}}</td>
                <td width="60%">{{ strip_tags($o->description) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <h2 class="text-center">Differences</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Date</th>
            <th>Differences</th>
        </tr>
        </thead>
        <tbody>
        @foreach($generator->differences as $diff )
            <tr>
                <td>{{$diff->created_at->toDateString()}}</td>
                <td>{{ strip_tags($diff->difference) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <hr>
@if($generator->more_info)
        <div>
            <h1>Generator details</h1>
            <hr>
            {{strip_tags($generator->more_info)}}
        </div>
    @endif
</div>

<style>
    .table > thead > tr > th{
        text-align: left;
    }
    .printable-page{
        font-size: 20px;
    }
</style>

