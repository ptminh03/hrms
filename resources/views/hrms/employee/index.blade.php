@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF EMPLOYEES </span>
    </div>
    <div class="panel-body pn">
        <div>
            <div class="col-md-4 search-container">
                <form action="" method="POST">
                    <input class="search-box" type="text" placeholder="Employee name">
                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="col-md-8">
                test
            </div>
        </div>

        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
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
                                <a href="#" class="text-muted disabled">
                                        <i class="glyphicon glyphicon-option-horizontal"></i>
                                </a>
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
            <tr>
            </tr>
            </tbody>
            </table>

            <div class="paginate">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
                    
@endsection
