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
                    Leave
                </li>
                <li class="breadcrumb-current-item">
                    <a href="{{route('leave.myLeave')}}"> My leave </a>
                </li>
                <li class="breadcrumb-current-item">
                    Leave details
                </li>
            </ol>
        </div>
    </header>


    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title hidden-xs"> My Leave Lists </span>
                                <div class="pull-right">
                                    <button class="btn btn-success">abc</button>
                                    <button class="btn btn-danger">def</button>
                                </div>
                            </div>
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Date Leave</th>
                                                <th class="text-center">Session</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($leaveDetails as $leaveDetail)
                                            <tr>
                                                <td class="text-center">{{$leaveDetail->id}}</td>
                                                <td class="text-center">{{getFormattedDate($leaveDetail->date_leave)}}</td>
                                                <td class="text-center">
                                                    @if($leaveDetail->session_id == 0)
                                                        Morning
                                                    @elseif($leaveDetail->session_id == 1)
                                                        Afternoon
                                                    @else
                                                        All day
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <p>Reason:</p>
                                    <div class="col-sm-12 content-card">
                                        {!! $leaves->reason !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection