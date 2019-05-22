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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="bg-secondary">
                        <th colspan="12">
                            <div class="search-container col-xl-4">
                                <form action="" method="GET">
                                    {!! Form::select('type', $deviceTypes, $request->type, ['class' => 'btn btn-mini search-box h-30']) !!}
                                    <div class="inline-object">
                                        <button class="btn-type" type="submit"><i class="fa fa-search"></i></button>
                                    </div> 
                                </form>
                            </div>
                            
                            <div class="col-xl-4">
                                Total &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $info['total'] }}
                                </span>
                            </div>

                            <div class="col-xl-4">
                                Available &nbsp;
                                <span class="badge badge-pill badge-default">
                                    {{ $info['available'] }}
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
            
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th class="text-center">ID</th>
                        <th class="text-center">Device Type</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td class="text-center">{{ $device->id }}</td>
                            <td class="text-left">
                                <a href="{{ route('device.index', ['type' => $device->device_type_id]) }}">
                                    {{ $device->deviceType->description }}
                                </a>
                            </td>
                            <td class="text-center">{{ $device->generateCode() }}</td>
                            <td class="text-center">
                                @if ($device->status == 0)
                                    <span class="text-success glyphicon glyphicon-ok"></span>
                                @else
                                    <a href="{{ route('employee.show', ['id' => $device->status]) }}">
                                        {{ $device->employee->name }}
                                    </a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($device->status == 0)
                                    <a href="{{ route('device.assign.create', ['id' => $device->id]) }}" class="btn btn-xs btn-info">
                                        <span class="text-default glyphicon glyphicon-plus-sign"></span>
                                    </a>
                                    <form action="{{ route('device.delete', ['id' => $device->id]) }}" method="POST" class="inline-object">
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}
        
                                        <button class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this device ?');">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('device-assign.update', ['id' => $device->id]) }}" method="POST" class="inline-object">
                                        {!! method_field('put') !!}
                                        {!! csrf_field() !!}
                                        <button class="btn btn-xs btn-default" onclick="return confirm('Are you sure to unassign this device ?');">
                                            <span class="glyphicon glyphicon-refresh"></span>
                                        </button>
                                    </form>
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
