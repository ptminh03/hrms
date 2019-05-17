@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> MY DEPARTMENT </span>
    </div>
    <div class="panel-body pn">

        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th colspan="12">
                            <div class="col-xl-4">
                                Department &nbsp;
                                <span class="badge badge-pill badge-primary">
                                    {{ $department->name }}
                                </span>
                            </div>

                            <div class="col-xl-4">
                                Total &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $department->count }}
                                </span>
                            </div>
                        </th>
                    </tr>

                    <tr class="bg-light">
                        <th class="text-center">Code</th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Date of Join</th>
                        <th class="text-center">Email</th>
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
                                @if(isset($employee->position))
                                    {{$employee->position->name}}
                                @else
                                    <i class="glyphicon glyphicon-option-horizontal"></i>
                                @endif
                            </td>
                            <td class="text-center">{{getFormattedDate($employee->date_of_join)}}</td>
                            <td class="text-left">{{$employee->user->email}}</td>
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
