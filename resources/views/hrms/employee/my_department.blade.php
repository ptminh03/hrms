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
                                    {{ $department->description }}
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
                        <th class="text-center">Employee</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Join Date</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td class="text-left">{{$employee->name}} - {{$employee->code}}</td>
                            <td class="text-center">
                                    @if(isset($employee->position))
                                        {{$employee->position->description}}
                                    @else
                                        <a href="#" class="text-muted disabled">
                                            <i class="glyphicon glyphicon-option-horizontal"></i>
                                        </a>
                                    @endif
                            </td>
                            <td class="text-center">{{getFormattedDate($employee->date_of_join)}}</td>
                            <td class="text-left">{{$employee->user->email}}</td>
                            <td class="text-center">
                                <a href="{{route('employee.show', ['id' => $employee->id])}}">
                                    <i class="glyphicon glyphicon-search"></i>
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
