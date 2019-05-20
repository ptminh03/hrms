@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection

    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> EMPLOYEE PROFILE </span>
    </div>

    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{Session::get('class')}}">
                {{ Session::get('message') }}
            </div>
        @endif
        
        <div class="panel panel-default">
            <h4 class="pt-1">Employee Information</h4>

            <div class="panel-body">
                <div class="col-xl-4">
                    <img class="img-circle" src="{{ asset('/photos/'. $employee->photo) }}" alt="No image" width="250px" height="250px">
                </div>
                <div class="col-xl-8">
                    <div class="col-xl-6">
                        <label class="col-xl-6">Name:</label>{{$employee->name}}
                    </div>

                    <div class="col-xl-6">
                        <label class="col-xl-6">Code:</label>{{$employee->code}}
                    </div>

                    <div class="col-xl-6">
                        <label class="col-xl-6">Gender:</label>{{$employee->gender}}
                    </div>

                    <div class="col-xl-6">
                        <label class="col-xl-6">Birthday:</label>{{$employee->date_of_birth}}
                    </div>

                    <div class="col-xl-6">
                        <label class="col-xl-6">Department:</label>
                        @if ( !empty($employee->department->name) )
                            {{ $employee->department->name }}
                        @else
                        -
                        @endif
                    </div>

                    <div class="col-xl-6">
                        <label class="col-xl-6">Position:</label>
                        @if ( !empty($employee->position->name) )
                            {{ $employee->position->name }}
                        @else
                            -
                        @endif
                    </div>

                    <div class="col-xl-6">
                        <label class="col-xl-6">Phone:</label>{{$employee->phone_number}}
                    </div>

                    <div class="col-xl-6">
                        <label class="col-xl-6">Date join:</label>{{$employee->date_of_join}}
                    </div>
                    
                    @if(Auth::user()->isManager())
                        <div class="col-xl-6">
                            <label class="col-xl-6">Account:</label>{{$employee->account_number}}
                        </div>
                        <div class="col-xl-6">
                            <label class="col-xl-6">Salary:</label>{{$employee->salary}}
                        </div>
                        <div class="col-xl-6">
                            <label class="col-xl-6">Resignation:</label>{{$employee->date_of_resignation}}
                        </div>
                    @endif
                    <div class="col-xl-12">
                        <label class="col-xl-3">Address:</label>{{$employee->address}}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="pull-right">
                    <button class="btn btn-danger">Delete</button>
                    <button class="btn btn-success">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
