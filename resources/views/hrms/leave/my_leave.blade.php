@extends('hrms.layouts.base')
@section('content')
@section('title')My Leave History @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs"> My Leave Lists </span>
    </div>

    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{ Session::get('class') }}">
                {{ Session::get('message') }}
            </div>
        @endif
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="table-responsive">
            <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                <thead>
                <tr class="bg-light">
                    <th class="text-center">Id</th>
                    <th class="text-center">Leave Type</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Date Request</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Processor</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leaves as $leave)
                    <tr>
                        <td class="text-center">{{$leave->id}}</td>
                        <td class="text-center">{{$leave->leave_type->description}}</td>
                        <td class="text-center">
                            <div class="btn-group text-right">
                                @if($leave->status == 2)
                                    <span class="glyphicon glyphicon-remove"></span>
                                @elseif($leave->status == 1)
                                    <span class="glyphicon glyphicon-ok"></span>
                                @else
                                    <i class="glyphicon glyphicon-option-horizontal"></i>
                                @endif
                            </div>
                        </td>
                        <td class="text-center"> {{ getFormattedDate($leave->created_at) }} </td>
                        <td class="text-center">{{$leave->quantity}}</td>
                        <td class="text-center">
                            @if(isset($leave->process_by) && $leave->process_by != 0)
                                <a href='/wel'>{{$leave->processor->name}}</a>
                            @endif
                        </td>
                        <td class="text-center">
                                <a href="{{route('leave.show', ['id' => $leave->id])}}">
                                    <i class="glyphicon glyphicon-search"></i>
                                </a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    {!! $leaves->render() !!}
                </tr>
                </tbody>
            </table>
        </div>
        {!! Form::close() !!}
    </div>                   
@endsection
