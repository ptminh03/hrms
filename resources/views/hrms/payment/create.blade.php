@extends('hrms.layouts.base')
@section('content')
@section('title') PAYMENTS @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> CREATE NEW PAYMENT </span>
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

        <form action="{{route('payment.store')}}" method="POST">
            {!! csrf_field() !!}
            
            <div class="form-group row">
                <div class="form-group col-xl-3">
                    <label for="department_id">Month
                        <span class="text-danger">*<span>
                    </label>
                    <select class="form-control" name="month">
                        <option disabled selected>-</option>
                        
                        @foreach ( $months as $key => $value )
                            <option value="{{$key}}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xl-3">
                    <label for="number">Year
                        <span class="text-danger">*<span>
                    </label>
                    <select class="form-control" name="year">
                        <option disabled selected>-</option>
                        @foreach ( $years as $key => $value )
                            <option value="{{$value}}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row col-xl-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
