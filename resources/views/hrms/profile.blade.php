@extends('hrms.layouts.base')

@section('content')

    <section id="content" class="animated fadeIn">

        <div class="row">

            <div class="col-md-4">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <span class="panel-title">{{isset($detail->name)?$detail->name:''}}</span>
                        </div>
                        <div class="panel-body pn pb5 text-center">
                            <hr class="short br-lighter">
                            <img src="{{isset($detail->photo) ? '/photos/'.$detail->photo : '/assets/img/avatars/profile_pic.png'}}" width="80px" height="80px" class="img-circle img-thumbnail" alt="User Image">

                        </div>
                        <p class="text-center no-margin">{{isset($detail->userrole->role->name)?$detail->department->description:''}}</p>
                        <p class="small text-center no-margin"><span class="text-muted">Bộ phận:</span> {{isset($detail->department) ? $detail->department:'' }}</p>
                        <p class="small text-center no-margin"><span class="text-muted">Mã số nhân viên:</span> {{isset($detail->code) ? $detail->code:''}}</p>


                    </div>
                </div>

                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Thông tin tài khoản</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Số tài khoản</strong></td>
                                        <td>{{isset($detail->account_number) ? $detail->account_number:''}}</td>

                                    </tr>
                                    
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-bank"></i></td>
                                        <td><strong>Tên ngân hàng</strong></td>
                                        <td>{{isset($detail->bank_name) ? $detail->bank_name: ''}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-code"></i></td>
                                        <td><strong>Tên chủ tài khoản</strong></td>
                                        <td>{{isset($detail->account_name) ? $detail->account_name: ''}} </td>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="box box-success">
                    <div class="panel">

                        <div class="panel-heading">
                            <span class="panel-title">Thông tin cá nhân</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">


                            <div class="box-body no-padding">

                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                                        </td>
                                        <td><strong>Ngày sinh</strong></td>
                                        <td>{{isset($detail->date_of_birth) ? $detail->date_of_birth:'' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-genderless"></i>
                                        </td>
                                        <td><strong>Giới tính</strong></td>
                                        <td>{{getGender($detail->gender)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-mobile-phone"></i>
                                        </td>
                                        <td><strong>Số điện thoại</strong></td>
                                        <td>{{isset($detail->number)? $detail->number:''}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Trình độ chuyên môn</strong></td>
                                        <td>{{isset($detail->qualification) ? $detail->qualification:''}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Địa chỉ tạm trú</strong></td>
                                        <td>{{isset($detail->current_address)? $detail->current_address:''}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Địa chỉ thường trú</strong></td>
                                        <td>{{isset($detail->permanent_address) ? $detail->permanent_address:''}}</td>
                                    </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-3 pull-right">
                <div class="small-box bg-black">
                    <div class="inner datebar" align="center">
                        <p style="color:ghostwhite">{{\Carbon\Carbon::now()->format('l, jS \\of F, Y')}}</p>
                        <h3 style="color: ghostwhite" id="clock"></h3>
                        <br/>
                    </div>
                </div>
            </div>

            {{--  @if($events)
            <div class="col-md-3 pull-right">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title"> Events </span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">
                                @foreach (array_chunk($events, 3, true) as $results)
                                    <table class="table">
                                        @foreach($results as $event)
                                             <tr>
                                                <td>
                                                    <div class='fc-event' data-event="primary">
                                                        <div class="fc-event-desc blink" id="blink">
                                                            <span class="label label-info pull-right">  {{$event->name}} </span></a>
                                                        </div>
                                                    </div>
                                                    <a href="{{route('create-event')}}" > <span class="label label-success pull-right">{{ \Carbon\Carbon::createFromTimestamp(strtotime($event->date))}}</span></a>
                                                </td>
                                             </tr>
                                        @endforeach
                                    </table>
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif  --}}
            <div class="col-md-5">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Thông tin nhân viên</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-key"></i></td>
                                        <td><strong>Mã số nhân viên</strong></td>
                                        <td>{{$detail->code}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-briefcase"></i></td>
                                        <td><strong>Bộ phận</strong></td>
                                        <td>{{$detail->department}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-cubes"></i></td>
                                        <td><strong>Chỉ định</strong></td>
                                        <td>{{$detail->department->description}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-calendar"></i></td>
                                        <td><strong>Ngày tham gia</strong></td>
                                        <td>{{$detail->date_of_joining}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Mức lương</strong></td>
                                        <td>{{$detail->salary}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
                    </div>
            </div>

        </div>

    </section>

@endsection
<script type="text/javascript">
    function startTime() {
        var today = new Date(),
                curr_hour = today.getHours(),
                curr_min = today.getMinutes(),
                curr_sec = today.getSeconds();
        curr_hour = checkTime(curr_hour);
        curr_min = checkTime(curr_min);
        curr_sec = checkTime(curr_sec);
        document.getElementById('clock').innerHTML = curr_hour + ":" + curr_min + ":" + curr_sec;
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    setInterval(startTime, 500);
</script>
