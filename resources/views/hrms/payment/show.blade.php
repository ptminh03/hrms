@extends('hrms.layouts.base')
@section('content')
    @section('title') PAYMENTS @endsection
    
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> PAYMENT DETAILS </span>
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
            <table class="table">
                <thead>
                    <tr class="bg-secondary">
                        <th colspan="12">
                            <div class="search-container col-xl-4">
                                <form action="" method="GET">
                                    <input class="search-box" type="text" placeholder="Search by name" name="q" value="{{ request()->q }}">
                                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>

                            <div class="col-xl-4">
                                Year &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $info['year'] }}
                                </span>
                            </div>
    
                            <div class="col-xl-4">
                                Month &nbsp;
                                <span class="badge badge-pill badge-info">
                                    {{ $info['month'] }}
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>

            @if ( !$paymentDetails->isEmpty() )
                <table class="table table-bordered">
                    <tbody>
                        <thead class="bg-light">
                            <th class="text-center">ID</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Employee</th>
                            <th class="text-center">Account Number</th>
                            <th class="text-center">Salary</th>
                            <th class="text-center">Non Paid Leave</th>
                            <th class="text-center">Payment</th>
                        </thead>

                        @foreach($paymentDetails as $payment)
                            <tr>
                                <td class="text-center">{{$payment->id}}</td>
                                <td class="text-center">{{$payment->code}}</td>
                                <td class="text-left">
                                    <a href="{{ route('employee.show', ['id' => $payment->employee_id]) }}">{{$payment->name}}</a>
                                </td>
                                <td class="text-center">{{$payment->account_number}}</td>
                                <td class="text-right">{{number_format($payment->salary, 0, ',', '.')}}</td>
                                <td class="text-center">{{$payment->non_paid}}</td>
                                <td class="text-right">{{number_format($payment->payment, 0, ',', '.')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="paginate">
                    {{ $paymentDetails->appends(['q' => request()->q])->render()  }}
                </div>
            @else
                <div>
                    <h5 class="text-info">No data available</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
