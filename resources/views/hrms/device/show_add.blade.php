@php
    dd($deviceTypes);
@endphp

@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">
    <header id="topbar" class="alt">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="breadcrumb-icon">
                    <a href="{{route('index')}}">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-link">
                    <a href="{{route('device.showAdd')}}">
                        Thêm thiết bị
                    </a>
                </li>
            </ol>
        </div>
    </header>

    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        {!! Form::open(['class' => 'form-horizontal', 'method' => 'post']) !!}
            <div class="form-group">
                <label class="col-md-2 control-label"> Loại ngày nghỉ </label>
                <div class="col-md-10">
                    <input type="hidden" value="{!! csrf_token() !!}" id="token">
                    <input type="hidden" value="{{\Auth::user()->id}}" id="user_id">
                    <select class="select2-multiple form-control select-primary leave_type"
                            name="device_type_id" required>
                        <option value="" selected>-- Chọn một ---</option>
                        @foreach($devices as $device)
                            <option value="{{$device->device_type_id}}">{{$device->type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        {!! Form::close() !!}
    </section>
</div>
@endsection