@extends('hrms.layouts.base')
@section('content')
    @section('title')Add Employee @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs"> Add New Employee </span>
    </div>
    <div class="panel-body pn">
        <form action="/employees/add" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="{!! csrf_token() !!}" name="_token">

            <div class="form-group">
                <label for="exampleInputPassword1">Employee Photo</label>
                <input type="file" name="photo" class="custom-file-input" id="validatedCustomFile">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Employee Code
                    <span class="text-danger">*<span>
                </label>
                <input type="text" required class="form-control"  placeholder="Enter Employee Code" name="code">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Employee Name
                    <span class="text-danger">*<span>
                </label>
                <input type="text" required class="form-control" placeholder="Enter Employee Name" name="name">
            </div>

            <label for="exampleInputPassword1">Gender
                <span class="text-danger">*<span>
            </label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" value="0" checked>
                <label class="form-check-label" for="gender1">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" value="1">
                <label class="form-check-label" for="gender2">
                    Female
                </label>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Department
                    <span class="text-danger">*<span>
                </label>
                <select class="form-control" name="department_id" required>
                    <option></option>
                    @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->description}}</option>
                    @endforeach    
            </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Position
                    <span class="text-danger">*<span>
                </label>
                <select class="form-control" name="position_id">
                    <option></option>
                    @foreach($positions as $position)
                        <option value="{{$position->id}}">{{$position->description}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Date of Join
                    <span class="text-danger">*<span>
                </label>
                <input type="date" class="form-control" placeholder="Enter Employee Name" name="date_of_join" required>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Date of Birth</label>
                <input type="date" class="form-control" placeholder="Enter Employee Name" name="date_of_birth"> 
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Address</label>
                <input type="text" class="form-control"  placeholder="Enter Addeess" name="address">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Phone Number</label>
                <input type="text" class="form-control"  placeholder="Enter Addeess" name="address">
            </div>
            
            <div class="form-group">
                <label for="exampleInputPassword1">Account Number</label>
                <input type="number" class="form-control" placeholder="Enter Account Number" name="account_number">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Salary
                    <span class="text-danger">*<span>
                </label>
                <input type="number" min="1000000" step="100000" class="form-control" placeholder="Enter Salary" name="salary" required>
            </div>
            
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        
    </div>
                    
@endsection
