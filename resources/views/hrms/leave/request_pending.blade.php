@extends('hrms.layouts.base')
@section('content')
    @section('title') LEAVE REQUESTS @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF REQUESTS PENDING </span>
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
                                    <input class="search-box" type="text" placeholder="Search by name" name="q" value="{{ $request->q }}">
                                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>

                            <div class="col-xl-4 margintop-6">
                                Total &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $info['total'] }}
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>

            @if ( !$leaves->isEmpty() )
                <table class="table table-bordered">
                    <tbody>
                        <thead class="bg-light">
                            <th class="text-center">ID</th>
                            <th class="text-center">Leave Type</th>
                            <th class="text-center">Employee</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Date Request</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Action</th>
                        </thead>

                        @foreach($leaves as $leave)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('leave.show', ['id' => $leave->id]) }}">{{$leave->id}}</a>
                                </td>
                                <td class="text-center">{{$leave->leave_type->description}}</td>
                                <td class="text-left">
                                    <a href="{{ route('employee.show', ['id' => $leave->employee->id]) }}">{{$leave->employee->name}}</a>
                                </td>
                                <td class="text-center">
                                    @if(isset($leave->employee->department))
                                        <a href="{{ route('employee.department', ['id' => $leave->employee->department->id]) }}">
                                            {{$leave->employee->department->name}}
                                        </a>
                                    @else
                                        <i class="glyphicon glyphicon-option-horizontal"></i>
                                    @endif
                                </td>
                                <td class="text-center"> {{ getFormattedDate($leave->created_at) }} </td>
                                <td class="text-center"> {{$leave->quantity}} </td>
                                <td class="text-center">
                                    <form action="{{ route('leave.update', ['id' => $leave->id]) }}" method="POST" class="inline-object">
                                        {!! method_field('put') !!}
                                        {!! csrf_field() !!}
                                        <input name="status" type="hidden" value="1">

                                        <button class="btn btn-xs btn-success">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                    </form>

                                    <form action="{{ route('leave.update', ['id' => $leave->id]) }}" method="POST" class="inline-object">
                                        {!! method_field('put') !!}
                                        {!! csrf_field() !!}
                                        
                                        <input name="status" type="hidden" value="2">
                                        <button class="btn btn-xs btn-danger">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="paginate">
                    {{ $leaves->appends(['q' => request()->q])->render()  }}
                </div>
            @else
                <div>
                    <h5 class="text-info">No data available</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
