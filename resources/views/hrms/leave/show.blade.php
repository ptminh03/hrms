@extends('hrms.layouts.base')

@section('content')
    @section('title') LEAVE REQUESTS @endsection

    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> REQUESTS DETAILS </span>
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

        
        <div class="pull-right pb30">
            @if ( Auth::user()->isManager() )
                <form action="{{ route('leave.update', ['id' => request()->id]) }}" method="POST" class="inline-object mx-5">
                    {!! method_field('put') !!}
                    {!! csrf_field() !!}
                    <input name="status" type="hidden" value="1">
                    <button class="btn btn-md btn-success">Approve</button>
                </form>

                <form action="{{ route('leave.update', ['id' => request()->id]) }}" method="POST" class="inline-object mx-5">
                    {!! method_field('put') !!}
                    {!! csrf_field() !!}
                    
                    <input name="status" type="hidden" value="2">
                    <button class="btn btn-md btn-danger">Deny</button>
                </form>
            @endif

            <a href="{{ url()->previous() }}" class="btn btn-md btn-default mx-5">Back</a>
        </div>

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
                @if ($leaves->reason)
                    {!! $leaves->reason !!}
                @else
                    <i class="text-muted">Empty reason.</i>
                @endif
            </div>
        </div>
    </div>
@endsection