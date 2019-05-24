@extends('hrms.layouts.base')
@section('content')
    @section('title') PAYMENTS @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF PAYMENTS </span>
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
            @if ( !$payments->isEmpty() )
                <table class="table table-bordered">
                    <tbody>
                        <thead class="bg-light">
                            <th class="text-center">ID</th>
                            <th class="text-center">Year</th>
                            <th class="text-center">Month</th>
                            <th class="text-center">Total Payments</th>
                        </thead>

                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('payment.show', ['id' => $payment->id]) }}">
                                        {{$payment->id}}
                                    </a>
                                </td>
                                <td class="text-center">{{$payment->year}}</td>
                                <td class="text-center">{{$payment->month}}</td>
                                <td class="text-center">{{$payment->total_payments}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="paginate">
                    {{ $payments->appends(['q' => request()->q, 'type' => request()->type])->render()  }}
                </div>
            @else
                <div>
                    <h5 class="text-info">No data available</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
