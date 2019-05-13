@extends('hrms.layouts.base')
@section('content')
    @section('title') DEVICES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF DEVICES </span>
    </div>
    <div class="panel-body pn">

        @if(Session::has('message'))
            <div class="alert {{ Session::get('class') }}">
                {{ Session::get('message') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th class="text-center">ID</th>
                        <th class="text-center">Device Type</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td class="text-center">{{$device->id}}</td>
                            <td class="text-left">{{$device->deviceType->description}}</td>
                            <td class="text-center">{{$device->code}}</td>
                            <td class="text-center">
                                @if($device->status == 2)
                                    <a href="#" class="text-danger disabled">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                @elseif($device->status == 1)
                                    <a href="#" class="text-success disabled">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </a>
                                @else
                                    <a href="#" class="text-muted disabled">
                                        <i class="glyphicon glyphicon-option-horizontal"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate">
                {{ $devices->links() }}
            </div>
        </div>
    </div>
@endsection
