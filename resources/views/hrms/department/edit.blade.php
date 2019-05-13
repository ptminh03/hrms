@extends('hrms.layouts.base')
@section('content')
@section('title') DEPARTMENTS @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> EDIT DEPARTMENT </span>
    </div>
    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{Session::get('class')}}" role="alert">
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

        <form action="{{ route('department.update', ['id' => $department->id]) }}" method="POST">
            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="exampleInputEmail1">Description
                    <span class="text-danger">*<span>
                </label>
                <input type="text" class="form-control"  placeholder="Enter description" name="description" value="{{$department->description}}" required>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>                   
@endsection
