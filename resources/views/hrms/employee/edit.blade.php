@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection

    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> EDIT EMPLOYEES </span>
    </div>

    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{Session::get('class')}}">
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
        
        <form action="{{ route('employee.store') }}" method="POST">
            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            <div class="form-group form-add-employee col-xl-12">
                <h4 class="pt-1">Employee Information</h4>
                <div class="form-group col-xl-8">
                    <label for="exampleInputPassword1">Employee Name
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" required class="form-control" placeholder="Enter employee name" name="name" value=" {{ $employee->name }} ">
                </div>
                <div class="form-group col-xl-4">
                    <label for="exampleInputEmail1">Employee Code
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" readonly style="cursor: auto" required class="form-control" name="code" value="{{ $employee->code }}">
                </div>
                <div class="form-group col-xl-12">
                    <label for="exampleInputEmail1">Email
                        <span class="text-danger">*<span>
                    </label>
                <input type="text" readonly style="cursor: auto" required class="form-control" name="email" required value=" {{ $employee->user->email }} ">
                </div>
                <div class="form-group col-xl-4">
                    <label for="exampleInputPassword1">Employee Photo</label><br>
                    <label class="btn btn-default btn-file">
                        Browse <input type="file" accept="image/*" name="photo" class="custom-file-input" id="validatedCustomFile" style="display: none;" onchange="$('#name-photo').html($('#validatedCustomFile')[0].files[0].name)">
                    </label>
                    <label id="name-photo"></label>
                </div>
                <div class="form-group col-xl-12">
                    <label for="exampleInputPassword1">Gender
                        <span class="text-danger">*<span>
                    </label>
                    <div class="form-group form-check">
                        <div class="col-xl-3">
                            <input class="form-check-input" type="radio" name="gender" value="Male" @if ($employee->gender == 'Male') checked @endif)>
                            <label class="form-check-label" for="gender1"> 
                                Male
                            </label>
                        </div>
                        <div class="col-xl-3">
                            <input class="form-check-input" type="radio" name="gender" value="Female" @if ($employee->gender == 'Female') checked @endif)>
                            <label class="form-check-label" for="gender2">
                                Female
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xl-4">
                    <label for="exampleInputPassword1">Department</label>
                    <select class="form-control" name="department_id">
                        <option>-</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xl-4">
                    <label for="exampleInputPassword1">Position</label>
                    <select class="form-control" name="position_id">
                        <option>-</option>
                        @foreach($positions as $position)
                            <option value="{{$position->id}}">{{$position->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xl-4">
                    <label for="exampleInputPassword1">Date of Join
                        <span class="text-danger">*<span>
                    </label>
                    <input type="date" class="form-control" name="date_of_join" required value=" {{ $employee->date_of_join }} ">
                </div>
            </div>

            <div class="form-group form-add-employee col-xl-12">
                <h4 class="pt-1">Personal Information</h4>
                <div class="form-group col-xl-12">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" class="form-control"  placeholder="Enter address" name="address" value=" {{ $employee->address }} ">
                </div>
                <div class="form-group col-xl-4">
                    <label for="exampleInputPassword1">Date of Birth</label>
                    <input type="date" class="form-control" name="date_of_birth" value=" {{ $employee->date_of_birth }} "> 
                </div>

                <div class="form-group col-xl-4">
                    <label for="exampleInputEmail1">Phone Number</label>
                    <input type="text" class="form-control" placeholder="Enter phone number" name="phone_number" value=" {{ $employee->phone_number }} ">
                </div>
            </div>

            <div class="form-group form-add-employee col-xl-12">
                <h4 class="pt-1">Bank Information</h4>
                <div class="form-group col-xl-4">
                    <label for="exampleInputPassword1">Account Number<span class="text-danger">*<span></label>
                    <input type="number" class="form-control" placeholder="Enter account number" name="account_number" value=" {{ $employee->account_number }} ">
                </div>
                <div class="form-group col-xl-4">
                    <label for="exampleInputPassword1">Salary<span class="text-danger">*<span></label>
                    <input type="number" min="1000000" step="100000" class="form-control" placeholder="Enter salary" name="salary" required value=" {{ $employee->salary }} ">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
     </div>
    </div>

@endsection
