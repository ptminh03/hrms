@extends('hrms.layouts.base')
@section('content')
@section('title') DEPARTMENTS @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF DEPARTMENT </span>
    </div>
    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{Session::get('class')}}">
                {{ Session::get('message') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr class="bg-light">
                    <th class="text-center">ID</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td class="text-center">{{$department->id}}</td>
                        <td class="text-center">
                            <a href="{{ route('employee.department', ['id' => $department->id]) }}">
                                {{$department->description}}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('department.edit', ['id' => $department->id]) }}" class="btn btn-xs btn-info">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a href="{{ route('department.delete', ['id' => $department->id]) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this department ?');">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
            <div class="paginate">
                {{ $departments->links() }}
            </div>
        </div>
    </div>                   
@endsection
