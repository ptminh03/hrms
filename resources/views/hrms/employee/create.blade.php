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
        
        <form action="{{ route('employee.store') }}" method="POST">
            <input type="hidden" value="{!! csrf_token() !!}" name="_token">

            <div class="panel panel-default">
                <h4 class="pt-1">Employee Information</h4>

                <div class="panel-body form-group">
                    <label for="exampleInputEmail1">Email
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" required class="form-control" placeholder="Enter email" name="email" required>
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Employee Photo</label>
                    <input type="file" name="photo" class="custom-file-input" id="validatedCustomFile">
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputEmail1">Employee Code
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" required class="form-control"  placeholder="Enter employee code" name="code" value="{{$newCode}}">
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Employee Name
                        <span class="text-danger">*<span>
                    </label>
                    <input type="text" required class="form-control" placeholder="Enter employee name" name="name">
                </div>

                <div class="panel-body">
                    <label for="exampleInputPassword1">Gender
                        <span class="text-danger">*<span>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Male" checked>
                        <label class="form-check-label" for="gender1">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Female">
                        <label class="form-check-label" for="gender2">
                            Female
                        </label>
                    </div>
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Department</label>
                    <select class="form-control" name="department_id">
                        <option></option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->description}}</option>
                        @endforeach    
                    </select>
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Position</label>
                    <select class="form-control" name="position_id">
                        <option></option>
                        @foreach($positions as $position)
                            <option value="{{$position->id}}">{{$position->description}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Date of Join
                        <span class="text-danger">*<span>
                    </label>
                    <input type="date" class="form-control" name="date_of_join" required>
                </div>
            </div>

            <div class="panel panel-default">
                <h4 class="pt-1">Personal Information</h4>

                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Date of Birth</label>
                    <input type="date" class="form-control" name="date_of_birth"> 
                </div>
                
                <div class="panel-body form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" class="form-control"  placeholder="Enter address" name="address">
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputEmail1">Phone Number</label>
                    <input type="text" class="form-control"  placeholder="Enter phone number" name="address">
                </div>
            </div>
            
            <div class="panel panel-default">
                <h4 class="pt-1">Bank Information</h4>
                
                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Account Number</label>
                    <input type="number" class="form-control" placeholder="Enter account number" name="account_number">
                </div>

                <div class="panel-body form-group">
                    <label for="exampleInputPassword1">Salary
                        <span class="text-danger">*<span>
                    </label>
                    <input type="number" min="1000000" step="100000" class="form-control" placeholder="Enter salary" name="salary" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
     </div>   
    </div>
                    
@endsection
