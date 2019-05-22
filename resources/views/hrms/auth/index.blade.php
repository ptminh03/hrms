@extends('hrms.layouts.base')

@section('content')
@section('title') HOME PAGE @endsection
    <div class="panel-heading">
        <span class="text-info panel-title hidden-xs">Announcement</span>
    </div>

    <div class="content">
        <div class="row">
            @foreach($news as $new)
            <div class="border-content">
                <div class="col-sm-12 content-card mt-30">
                    <div class="row">
                        <div class="col-md-1">
                            @if ( $new->type == 1 )
                                <img src="{{ asset('/photos/'. $new->photo) }}" class="img-circle" height="50" width="50" alt="Avatar">
                            @else
                                <img src="{{ asset('/photos/system.jpg') }}" class="img-circle" height="50" width="50" alt="System">
                            @endif
                        </div>
                        <div class="user-info col-md-11">
                            <h6 class="tag-name">
                                @if($new->author !== null)
                                    <a href="{{ route('employee.show', ['id' => $new->id]) }}">
                                        {{ $new->name }}
                                    </a>
                                @else
                                    System
                                @endif
                            </h6>
                            <small>{{ Carbon\Carbon::parse($new->updated_at)->format('Y-m-d H:i:s') }}</small>
                        </div>
                    </div>
                    <div class="post-content">
                        @switch($new->type)
                            @case(1)
                                <h3>{{ $new->title }}</h3>
                                <p>{!! $new->content !!}</p>
                                @break
                            @case(2)
                                <h3>Leave Announcement</h3>
                                <p>
                                    <a href="{{ route('employee.show', ['id' => $new->id]) }}">
                                        {{ $new->name }}
                                    </a> 
                                    has been 
                                    @if ($new->leaveStatus() == 1) 
                                        <span class="text-success"> approved </span>
                                    @else 
                                        <span class="text-danger"> denied </span>
                                    @endif 
                                    your
                                    <a href="{{ route('leave.show', ['id' => $new->target_id]) }}"> 
                                        Leave request
                                    </a> 
                                    !
                                </p>
                                @break
                            @case(3)
                                <h3>Device Announcement</h3>
                                <p>
                                    <a href="{{ route('employee.show', ['id' => $new->deviceAssign->assign->id]) }}">
                                        {{ $new->deviceAssign->assign->name }}
                                    </a> has been
                                    @if ( $new->status == 1 ) 
                                        <span class="text-success">assign</span> device <b>{{ $new->deviceAssign->deviceWithTrashed->generateCode() }}</b> to you 
                                    @else 
                                        <span class="text-danger">unassign</span> device <b>{{ $new->deviceAssign->deviceWithTrashed->generateCode() }}</b> from you 
                                    @endif
                                </p>
                                @break
                        @endswitch
                    </div>
                </div>        
            </div>
            @endforeach

            <div class="paginate">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection
