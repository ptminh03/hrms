@extends('hrms.layouts.base')
@section('content')
    @section('title')Employee List @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs"> Danh sách thành viên </span>
    </div>
    <div class="panel-body pn">

        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
        @endif
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="table-responsive">
            <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                <thead>
                <tr class="bg-light">
                    <th class="text-center">Employee</th>
                    @if (url()->current() == route('employee.showEmployees'))
                        <th class="text-center">Department</th>
                    @endif
                    <th class="text-center">Position</th>
                    <th class="text-center">Join Date</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td class="text-center">{{$employee->name}} - {{$employee->code}}</td>
                    @if (url()->current() == route('employee.showEmployees'))
                        <th class="text-center">{{$employee->department->description}}</th>
                    @endif
                    <td class="text-center">{{$employee->position->description}}</td>
                    <td class="text-center">{{getFormattedDate($employee->date_of_join)}}</td>
                    <td class="text-center">{{$employee->user->email}}</td>
                    <td class="text-center">
                        <a href="{{route('employee.showProfile', ['profile' => $employee->id])}}">
                            <i class="glyphicon glyphicon-search"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
            </tr>
            </tbody>
            </table>
        </div>
            {!! Form::close() !!}
    </div>
                    
@endsection
