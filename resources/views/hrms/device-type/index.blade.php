@extends('hrms.layouts.base')
@section('content')
    @section('title') DEVICE TYPES @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> DEVICE TYPES </span>
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
                            </div>

                            <div class="col-xl-4">
                                Total &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $info['total'] }}
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>

            @if ( !$deviceTypes->isEmpty() )
                <table class="table table-bordered">
                    <tbody>
                        <thead class="bg-light">
                            <th class="text-center">ID</th>
                            <th class="text-center">Prefix</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Quantity of Device</th>
                            <th class="text-center">Action</th>
                        </thead>

                        @foreach($deviceTypes as $deviceType)
                            <tr>
                                <td class="text-center">{{$deviceType->id}}</td>
                                <td class="text-center">{{$deviceType->prefix}}</td>
                                <td class="text-center">{{$deviceType->description}}</td>
                                <td class="text-center">{{$deviceType->devices_count}}</td>
                                <td class="text-center">
                                    <a href=" {{ route('device-type.edit', ['id' => $deviceType->id]) }} " class="btn btn-xs btn-info">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <form action="{{ route('device-type.delete', ['id' => $deviceType->id]) }}" method="POST" class="inline-object">
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}

                                        <button class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this device type ?');">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="paginate">
                    {{ $deviceTypes->appends(['q' => request()->q, 'type' => request()->type])->render()  }}
                </div>
            @else
                <div>
                    <h5 class="text-info">No data available</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
