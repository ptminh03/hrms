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
                            <th class="text-center">Year</th>
                            <th class="text-center">Month</th>
                            <th class="text-center">Total Payments</th>
                        </thead>

                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-center">{{$payment->year}}</td>
                                <td class="text-center">{{$payment->month}}</td>
                                <td class="text-right">
                                    <a href="{{ route('payment.show', ['id' => $payment->id]) }}">
                                        {{number_format($payment->total_payments, 0, ',', '.')}}
                                    </a>
                                </td>
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

            <form action="{{route('payment.store')}}" method="POST" class="pt10">
                {!! csrf_field() !!}
                
                <div class="form-group row col-xl-3">
                    <button type="submit" class="btn btn-primary">New Payment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
