@php
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('hrms.layouts.base')
@section('content')
    @section('title') POLICES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF POLICES </span>
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

        <div class="mt40">
            <div class="panel-group accordion" id="accordion1">

                @foreach($policies as $policy)
                <div class="panel">
                    <div class="panel-heading">
                        <a class="accordion-toggle accordion-icon link-unstyled collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion-{{ $policy->id }}">
                            {{$policy->id}}. {{ $policy->title }}
                        </a>
                    </div>
                    <div class="collapse policy-content" id="accordion-{{ $policy->id }}">
                        <div class="card card-body">
                            {!! $policy->content !!}
                        </div>

                        @if(Auth::user()->isManager())
                            <div>
                                <a href="{{ route('policy.edit', ['id' => $policy->id]) }}" class="btn btn-xs btn-info">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <form action="{{ route('policy.delete', ['id' => $policy->id]) }}" method="POST" class="inline-object">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
    
                                    <button class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this policy ?');">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
                            </div>
                        @endif
                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
