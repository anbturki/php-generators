@extends('layouts.app')
@section('content')
    <div class="page-content">
    @if(!$generators->isEmpty())
        <a class="btn btn-primary printable" href="{{route('generators.index')}}"><i class="fa fa-print"></i> Print</a>

        <div id="msg"></div>
        <div class="row">
            <div class="col-md-12">
                @if($generators->count() >= 10)
                    @include('inc.search')
                @endif
                <h4 class="remove-btn">
                    <a href="#"
                       class="btn btn-default remove-btn alert-link"
                       data-do="removeHock('{{route("generator::delete")}}')"
                       data-heading="Are you sure ?"
                       data-msg="this generators will be removed and you cannot restore that agien"
                    ><i class="fa fa-trash"></i></a>


                    <span id="item-cont"></span>
                </h4>
                @if(session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Success!</strong> {{session('success')}} ...
                    </div>
                @endif
                <div class="generators-table">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox checkbox-primary  checkbox-circle">
                                            <input id="mainChekbox" type="checkbox" name="remove[]">
                                            <label for="mainChekbox"></label>
                                        </div>
                                    </th>
                                    <th class="pull-left">ID</th>
                                    <th>{{trans('generators.Generator_Area')}}</th>
                                    <th>{{trans('generators.Storage_Capacity')}}</th>
                                    <th>Diesel</th>
                                    <th>Maintenance at</th>
                                    <th>Overhaul at</th>
                                    <th>{{trans('generators.Maintenance')}}</th>
                                    <th>Status</th>
                                    <th>Turned On At</th>
                                    <th>Turned Off At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  $i = 0; ?>
                                @foreach($generators as $g)
                                    <?php
                                    $g->checkIfDieselLessThanMinimum();
//                                    $g->overhaulChangeStatus();
                                    $i++;
                                    ?>
                                    <tr class="text-center">
                                        <td>
                                            <div class="checkbox checkbox-primary  checkbox-circle">
                                                <input id="checkbox{{$i}}" type="checkbox" value="{{$g->id}}"
                                                       name="remove[]" class="removing">
                                                <label for="checkbox{{$i}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-left"><a
                                                    href="{{route('generators.show',$g->id)}}" class="text-muted"><strong>{{$g->name}}</strong></a></td>
                                        <td> {{$g->area}} </td>
                                        <td>

                                                <label class="label label-primary">{{$g->storage_capacity}} <strong>
                                                        L</strong></label>
                                        </td>
                                        <td>
                                                @if($g->checkIfDieselTankIsEmpty())
                                                    <label class="label label-danger">Empty</label>
                                                @else
                                                <label class="label label-default">
                                                    {{round($g->calcUsedAtWorkingAndRemaining())}}
                                                </label>

                                            @endif
                                            <div class="myProgress">
                                                <div class="myBar"
                                                     style="width:{{round($g->remainingDieselPercent())}}%">
                                                    {{round($g->remainingDieselPercent())}}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                                <label class="label label-primary">
                                                    @if($g->nxtMstamp() && $g->nxtMstamp()->isToday())
                                                        Today
                                                    @else
                                                        {{$g->getOverMaintenance()}}
                                                    @endif

                                                </label>

                                        </td>
                                        <td>
                                            @if($g->overhaulNextOne())
                                                {{$g->overhaulNextOne()->toDateString()}}
                                            @else
                                                <label class="label label-danger">Unknown</label>
                                            @endif

                                        </td>

                                        <td><a href="{{route('maintenances.create',$g->id)}}"
                                               class="btn btn-info btn-xs modal-btn">Maintenance</a></td>
                                        <td><a href="{{route('generator::status',$g->id)}}"
                                               class="btn btn-{{$g->status?'success':'primary'}} btn-xs">{{$g->status?'Turn Off':'Turn On'}}</a>
                                        </td>
                                        <td>
                                            @if($g->turned_on->isToday())
                                                <span class="label label-info">Today at {{$g->turned_on->format('g:i A')}}</span>
                                            @else
                                                <span class="label label-info">{{$g->turned_on->format('d-m-y g:i A')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($g->turned_off->isToday())
                                                <span class="label label-primary">Today at {{$g->turned_off->format('g:i A')}}</span>
                                            @else
                                                <span class="label label-primary">{{$g->turned_off->format('d-m-y g:i A')}}</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="pg-count"><strong>Total:</strong> {{$generators->total()}} | <strong>Current
                                items:</strong> {{$generators->count()}}</p>

                    </div>
                    <h4 class="remove-btn">
                        <a href="#"
                           class="btn btn-default remove-btn alert-link"
                           data-do="removeHock('{{route("generator::delete")}}')"
                           data-heading="Are you sure ?"
                           data-msg="this generators will be removed and you cannot restore that agien"
                        ><i class="fa fa-trash"></i></a>


                        <span id="item-cont"></span>
                    </h4>

                    {!! $generators->links() !!}
                </div>

            </div>
        </div>

        <script>
            var searchURI = "{{route('generators.index')}}";
        </script>
        @include('inc.modal')
        @include('inc.alert')
    @else
        <div class="text-center">
            <h1>Add New generator</h1>
            <a class="btn btn-primary btn-lg" href="{{ route('generators.create') }}">Add Generator</a>
        </div>

    @endif

    <style>
        .table{
            margin-bottom: 0;
        }
    </style>
</div>
    @endSection
