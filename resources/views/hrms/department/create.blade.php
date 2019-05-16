@extends('hrms.layouts.base')
@section('content')
@section('title') DEPARTMENTS @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> CREATE NEW DEPARTMENT </span>
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

        <form action="{{route('department.store')}}" method="POST">
            {!! csrf_field() !!}
            
            <div class="form-group">
                <label for="exampleInputEmail1">Description
                    <span class="text-danger">*<span>
                </label>
                <input type="text" class="form-control"  placeholder="Description must be not empty and not exist yet." name="description">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>                   
@endsection
