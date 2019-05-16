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

                    <form action=" {{ route('leave.store') }} " method="post" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-2 control-label"> Leave type
                                <span class="text-danger">*<span>
                            </label>

                            <div class="col-md-10">
                                <select class="select2-multiple form-control select-primary leave_type"
                                        name="leave_type_id" required>
                                    <option value="" selected disabled> - </option>
                                    @foreach($leaves as $leave)
                                        <option value="{{$leave->id}}">{{$leave->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date_from" class="col-md-2 control-label"> From
                                <span class="text-danger">*<span>
                            </label>

                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar text-alert pr10"></i>
                                    </div>

                                    <input type="text" id="datepicker1" class="select2-single form-control"
                                        name="dateFrom" required readonly style="cursor: auto" onchange="getvalue()">
                                </div>
                            </div>

                            <label for="date_to" class="col-md-2 control-label"> To
                                <span class="text-danger">*<span>
                            </label>

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
                                <input type="submit" class="btn btn-md btn-info" value="Submit">
                            </div>
                        </div>
                    </form>
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
                        str += "<td class='text-center'><a class='btn btn-xs btn-danger' onclick=\"$(this).parents('tr').html('')\"><span class='glyphicon glyphicon-trash'></span></a></td>"
                        str += "</tr>"
                    }
                }
            str += "</table>"
            $("#date_request").html(str)
            }
        }

        CKEDITOR.replace( 'textarea1' );
    </script>
    @push('scripts')
        <script src="/assets/js/custom.js"></script>
        <script src="/assets/js/function.js"></script>
    @endpush
@endsection
