@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF EMPLOYEES </span>
    </div>
    
    <div class="panel-body pn">
        {{-- <div class="search-container">
            <form action="" method="POST">
                <input class="search-box" type="text" placeholder="Employee name">
                <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div> --}}

        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-secondary">
                        <th colspan="12">
                            <div class="search-container col-xl-4">
                                <form action="" method="POST">
                                    <input class="search-box" type="text" placeholder="Employee name">
                                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                                <select class="btn btn-mini">
                                    <option selected>All</option>
                                    <option>Current</option>
                                    <option>Resignated</option>
                                </select>
                            </div>

                            <div class="col-xl-4">
                                Current member &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $employees->current }}
                                </span>
                            </div>
    
                            <div class="col-xl-4">
                                Resignated &nbsp;
                                <span class="badge badge-pill badge-light">
                                    {{ $employees->resigned }}
                                </span>
                            </div>
                        </th>
                    </tr>

                    <tr class="bg-light">
                        <th class="text-center">Code</th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Date of Join</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td class="text-center">{{$employee->code}}</td>
                            <td class="text-left">
                                <a href="{{ route('employee.show', ['id' => $employee->id]) }}">{{$employee->name}}</a>
                            </td>
                            <td class="text-center">
                                @if(isset($employee->department))
                                    <a href="{{ route('employee.department', ['id' => $employee->department->id]) }}">
                                        {{$employee->department->description}}
                                    </a>
                                @else
                                    <i class="glyphicon glyphicon-option-horizontal"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(isset($employee->position))
                                    {{$employee->position->description}}
                                @else
                                    <i class="glyphicon glyphicon-option-horizontal"></i>
                                @endif
                            </td>
                            <td class="text-center">{{$employee->date_of_join}}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-xs text-success">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a href="#" class="btn btn-xs text-danger" onclick="return confirm('Are you sure to delete this employee ?');">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
@endsection
