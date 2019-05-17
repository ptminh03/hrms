@extends('hrms.layouts.base')
@section('content')
    @section('title') EMPLOYEES @endsection

    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> EMPLOYEE PROFILE </span>
    </div>

    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{Session::get('class')}}">
                {{ Session::get('message') }}
            </div>
        @endif
        
        <div class="panel panel-default">
            <h4 class="pt-1">Employee Information</h4>

            <div class="panel-body">
                {{$employee}}
                <br>
                Nút sửa xoá ở bên phải <br>
                Table show email, photo, code, name, gender,department, position, date of join, date of birth, address, phone number<br>
                account number, salary, date of resignated chỉ manager mới thấy
            </div>
        </div>
    </div>
@endsection
