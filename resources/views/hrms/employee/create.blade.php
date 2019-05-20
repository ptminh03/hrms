@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection

    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> CREATE NEW EMPLOYEE </span>
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
        
        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="form-group form-add-employee col-xl-12">
                <h4 class="pt-1">Employee Information</h4>
                <div class="form-group col-xl-8">
                    <label>Employee Name
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" required class="form-control" placeholder="Enter employee name" name="name">
                </div>
                <div class="form-group col-xl-4">
                    <label>Employee Code
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" readonly style="cursor: auto" required class="form-control" name="code" value="{{$newCode}}">
                </div>
                <div class="form-group col-xl-12">
                    <label>Email
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" required class="form-control" placeholder="Enter email" name="email" required>
                </div>
                <div class="form-group col-xl-4">
                    <label>Employee Photo</label><br>
                    <label class="btn btn-default btn-file">
                        Browse <input type="file" accept="image/*" name="photo" class="custom-file-input" id="validatedCustomFile" style="display: none;" onchange="$('#name-photo').html($('#validatedCustomFile')[0].files[0].name)">
                    </label>
                    <label id="name-photo"></label>
                </div>
                <div class="form-group col-xl-12">
                    <label>Gender
                        <span class="text-danger">*<span>
                    </label>
                    <div class="form-group form-check">
                        <div class="col-xl-3">
                            <input class="form-check-input" type="radio" name="gender" value="Male" checked>
                            <label class="form-check-label" for="gender1">
                                Male
                            </label>
                        </div>
                        <div class="col-xl-3">
                            <input class="form-check-input" type="radio" name="gender" value="Female">
                            <label class="form-check-label" for="gender2">
                                Female
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xl-4">
                    <label>Department</label>
                    <select class="form-control" name="department_id">
                        <option value="">-</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xl-4">
                    <label>Position</label>
                    <select class="form-control" name="position_id">
                        <option value="">-</option>
                        @foreach($positions as $position)
                            <option value="{{$position->id}}">{{$position->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xl-4">
                    <label>Date of Join
                        <span class="text-danger">*<span>
                    </label>
                    <input type="date" class="form-control" name="date_of_join" required>
                </div>
            </div>

            <div class="form-group form-add-employee col-xl-12">
                <h4 class="pt-1">Personal Information</h4>
                <div class="form-group col-xl-12">
                    <label>Address</label>
                    <input type="text" class="form-control"  placeholder="Enter address" name="address">
                </div>
                <div class="form-group col-xl-4">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control" name="date_of_birth"> 
                </div>

                <div class="form-group col-xl-4">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" placeholder="Enter phone number" name="phone_number">
                </div>
            </div>

            <div class="form-group form-add-employee col-xl-12">
                <h4 class="pt-1">Bank Information</h4>
                <div class="form-group col-xl-4">
                    <label>Account Number<span class="text-danger">*<span></label>
                    <input type="text" class="form-control" placeholder="Enter account number" name="account_number">
                </div>
                <div class="form-group col-xl-4">
                    <label>Salary<span class="text-danger">*<span></label>
                    <input type="number" min="1000000" step="100000" class="form-control" placeholder="Enter salary" name="salary" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
     </div>
    </div>

@endsection
