@extends('hrms.layouts.base')
@section('content')
    @section('title') DEVICES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> STATUS OF DEVICES </span>
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
                                {{-- <form action="" method="GET">
                                    <input class="search-box" type="text" placeholder="Search by name" name="q" value="{{ $request->q }}">
                                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                </form> --}}
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
                        <th class="text-center">{{'#'}}</th>
                        <th class="text-center">Device Type</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Available</th>
                    </tr>
                </thead>

                <tbody>
                    @php $i = 0; @endphp
                    @foreach($countDevices as $countDevice)
                        @php $i++; @endphp
                        <tr>
                            <td class="text-center">{{$i}}</td>
                            <td class="text-center">{{$countDevice->prefix}}</td>
                            <td class="text-left">
                                <a href="{{ route('device.index', ['type' => $countDevice->id]) }}">
                                    {{$countDevice->description}}
                                </a>
                            </td>
                            <td class="text-center">{{ $countDevice->devices_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate">
                {{ $countDevices->links() }}
            </div>
        </div>
    </div>
@endsection
