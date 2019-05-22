@extends('hrms.layouts.base')
@section('content')
    @section('title') DEVICES @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> ASSIGN DEVICE </span>
    </div>
    
    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{ Session::get('class') }}">
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

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="bg-secondary">
                        <th colspan="12">
                            <div class="search-container col-xl-4">
                                <form action="" method="GET">
                                    <input class="search-box" type="text" placeholder="Search by name" name="q" value="{{ request()->q }}">
                                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>

                            <div class="col-xl-4">
                                Device &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $device->generateCode() }}
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
            
        <form action="{{ route('device.assign.store', ['id' => $device->id]) }}" method="POST">
            {!! csrf_field() !!}
            <div class="form-group row">
                <div class="form-group col-xl-12 pt-10">
                    <p></p>
                    <label>Employee
                        <span class="text-danger">*<span>
                    </label>
                    {!! Form::select('employee_id', $employees, false, ['class' => 'btn btn-mini h-30 ml-30']) !!}
                </div>
            </div>
            <div class="form-group row col-xl-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

@endsection
