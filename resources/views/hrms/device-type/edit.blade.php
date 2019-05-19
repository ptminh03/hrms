@extends('hrms.layouts.base')
@section('content')
@section('title') DEVICE TYPES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> EDIT DEVICE TYPES </span>
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

        <form action="{{ route('device-type.update', ['id' => $deviceType->id]) }}" method="POST">
            {!! csrf_field() !!}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label>Prefix
                    <span class="text-danger">*<span>
                </label>
                <input type="text" class="form-control w-25"  placeholder="Prefix must be unique" name="prefix" value="{{ $deviceType->prefix }}" required>
            </div>

            <div class="form-group">
                <label>Description
                    <span class="text-danger">*<span>
                </label>
                <input type="text" class="form-control w-25"  placeholder="Description must be unique" name="description" value="{{ $deviceType->description }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>                   
@endsection
