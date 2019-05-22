@extends('hrms.layouts.base')
@section('content')
    @section('title') DEVICES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> MY DEVICES </span>
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
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th class="text-center">ID</th>
                        <th class="text-center">Device Type</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Assigner</th>
                        <th class="text-center">Assign At</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($deviceAssigns as $deviceAssign)
                        <tr>
                            <td class="text-center">{{ $deviceAssign->id }}</td>
                            <td class="text-left">
                                <a href="{{ route('device.index', ['type' => $deviceAssign->device->device_type_id]) }}">
                                    {{ $deviceAssign->device->deviceType->description }}
                                </a>
                            </td>
                            <td class="text-center">{{ $deviceAssign->device->generateCode() }}</td>
                            <td class="text-center">
                                <a href="{{ route('employee.show', ['id' => $deviceAssign->assign->id]) }}">
                                    {{ $deviceAssign->assign->name }}
                                </a>
                            </td>
                            <td class="text-center">{{ date_format(date_create($deviceAssign->created_at), 'Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate">
                {{ $deviceAssigns->links() }}
            </div>
        </div>
    </div>
@endsection
