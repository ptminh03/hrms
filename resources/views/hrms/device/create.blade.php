@extends('hrms.layouts.base')
@section('content')
@section('title') DEVICES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> CREATE NEW DEVICES </span>
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

        <form action="{{route('device.store')}}" method="POST">
            {!! csrf_field() !!}
            
            <div class="form-group row">
                <div class="form-group col-xl-3">
                    <label for="department_id">Device Type
                        <span class="text-danger">*<span>
                    </label>
                    <select class="form-control" name="device_type_id">
                        <option disabled selected>-</option>
                        @foreach($deviceTypes as $deviceType)
                            <option value="{{ $deviceType->id }}">{{ $deviceType->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xl-3">
                    <label for="number">Number of device(s)
                        <span class="text-danger">*<span>
                    </label>
                    <select class="form-control" name="number">
                        <option disabled selected>-</option>
                        @for ($i = 1; $i <= 50; $i++)
                            <option value="{{ $i }}">{{ $i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-group row col-xl-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
