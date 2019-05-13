@extends('hrms.layouts.base')
@section('content')
@section('title')Create Leave Request @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs"> Tạo yêu cầu nghỉ phép</span>
    </div>
    <div class="text-center" id="show-leave-count"></div>
        <div class="panel-body pn">
            <div class="table-responsive">
                <div class="panel-body p25 pb10">
                    @if(session('message'))
                        {{session('message')}}
                    @endif
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success">
                            {{ session::get('flash_message') }}
                        </div>
                    @endif
                    {!! Form::open(['class' => 'form-horizontal', 'method' => 'post']) !!}

                    <div class="form-group">
                        <label class="col-md-2 control-label"> Loại ngày nghỉ </label>
                        <div class="col-md-10">
                            <input type="hidden" value="{!! csrf_token() !!}" id="token">
                            <input type="hidden" value="{{\Auth::user()->id}}" id="user_id">
                            <select class="select2-multiple form-control select-primary leave_type"
                                    name="leave_type" required>
                                <option value="" selected>-- Chọn một ---</option>
                                @foreach($leaves as $leave)
                                    <option value="{{$leave->id}}">{{$leave->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date_from" class="col-md-2 control-label"> Từ ngày </label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar text-alert pr10"></i>
                                </div>
                                <input type="text" id="datepicker1" class="select2-single form-control"
                                    name="dateFrom" required readonly style="cursor: auto" onchange="getvalue()">
                            </div>
                        </div>
                        <label for="date_to" class="col-md-2 control-label"> đến </label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar text-alert pr10"></i>
                                </div>
                                <input type="text" id="datepicker4" class="select2-single form-control"
                                    name="dateTo" required readonly style="cursor: auto" onchange="getvalue()">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="date_request" class="col-md-10 table-responsive" style="float: right;"></div>
                    </div>
                    <div class="form-group">
                        <label for="input002" class="col-md-2 control-label"> Lý do </label>
                        <div class="col-md-10">
                            <textarea type="text" id="textarea1" class="select2-single form-control"
                                name="reason" required>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-2">
                            <input type="submit" class="btn btn-bordered btn-info btn-block" value="Tạo yêu cầu">
                        </div>
                        <div class="col-md-2"><a href="{{route('leave.store')}}" >
                            <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
                
    <script>
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ]
        const weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

        function formatDate(date) {
            return weekday[date.getDay()] + ", " + monthNames[date.getMonth()] + " " + date.getDate() + ", " + date
            .getFullYear();
        }

        function getvalue() {
            d1 = $("#datepicker1").val()
            d2 = $("#datepicker4").val()
            if (d1 !== '' && d2 !== '') {
                str = `<table class="table col-md-10 allcp-form theme-warning tc-checkbox-1 fs13">
                    <tr class='bg-light'>
                        <th class='text-left'>Date</th>
                        <th class='text-center'>Morning</th>
                        <th class='text-center'>Afternoon</th>
                        <th class='text-center'>All Day</th>
                        <th class='text-center'>Remove</th>
                    </tr>`
                for (var d = new Date($("#datepicker1").val()); d <= new Date($("#datepicker4").val()); d.setDate(d.getDate() + 1)) {
                    if (d.getDay() !== 0 && d.getDay() !== 6) {
                        str += "<tr class='bg-light'>"
                        str += "<td class='text-left'>" + formatDate(d) + "</td>"
                        str += "<td class='text-center'><input type='radio' name='date[" + formatDate(d) + "]' value='0'></td>"
                        str += "<td class='text-center'><input type='radio' name='date[" + formatDate(d) + "]' value='1'></td>"
                        str += "<td class='text-center'><input type='radio' name='date[" + formatDate(d) + "]' value='2' checked></td>"
                        str += "<td class='text-center'><button class='br-n' type='button' onclick=\"$(this).parents('tr').html('')\"><span class='glyphicon glyphicon-trash'></span></button></td>"
                        str += "</tr>"
                    }
                }
            str += "</table>"
<<<<<<< HEAD:resources/views/hrms/leave/show_add.blade.php
            $("#date_request").html(str)
=======
            document.getElementById("date_request").innerHTML = str;
>>>>>>> 8841947e0b6ed3479d59e08c880a10ec14047670:resources/views/hrms/leave/create.blade.php
            }
        }

        CKEDITOR.replace( 'textarea1' );
    </script>
    @push('scripts')
        <script src="/assets/js/custom.js"></script>
        <script src="/assets/js/function.js"></script>
    @endpush
@endsection
