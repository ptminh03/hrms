@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF EMPLOYEES </span>
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
                                    
                                    <div>
                                        {!! Form::select('type', ['' => 'current', 'resignated' => 'resignated', 'all' => 'all'], $request->type, ['class' => 'btn btn-mini']) !!}
                                    </div>
                                </form>
                            </div>

                            <div class="col-xl-4">
                                Current member &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $info['current'] }}
                                </span>
                            </div>
    
                            <div class="col-xl-4">
                                Resignated &nbsp;
                                <span class="badge badge-pill badge-light">
                                    {{ $info['resigned'] }}
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>

            @if ( !$employees->isEmpty() )
                <table class="table table-bordered">
                    <tbody>
                        <thead class="bg-light">
                            <th class="text-center">Code</th>
                            <th class="text-center">Employee</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Position</th>
                            <th class="text-center">Date of Join</th>
                            <th class="text-center">Action</th>
                        </thead>

                        @foreach($employees as $employee)
                            <tr>
                                <td class="text-center">{{$employee->code}}</td>
                                <td class="text-left">
                                    <a href="{{ route('employee.show', ['id' => $employee->id]) }}">{{$employee->name}}</a>
                                </td>
                                <td class="text-center">
                                    @if(isset($employee->department))
                                        <a href="{{ route('employee.department', ['id' => $employee->department->id]) }}">
                                            {{$employee->department->name}}
                                        </a>
                                    @else
                                        <i class="glyphicon glyphicon-option-horizontal"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($employee->position))
                                        {{$employee->position->name}}
                                    @else
                                        <i class="glyphicon glyphicon-option-horizontal"></i>
                                    @endif
                                </td>
                                <td class="text-center">{{$employee->date_of_join}}</td>
                                <td class="text-center">
                                    <a href=" {{ route('employee.edit', ['id' => $employee->id]) }} " class="btn btn-xs btn-info">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <form action="{{ route('employee.delete', ['id' => $employee->id]) }}" method="POST" class="inline-object">
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}

                                        <button class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this employee ?');">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="paginate">
                    {{ $employees->appends(['q' => request()->q, 'type' => request()->type])->render()  }}
                </div>
            @else
                <div>
                    <h5 class="text-info">No data available</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
