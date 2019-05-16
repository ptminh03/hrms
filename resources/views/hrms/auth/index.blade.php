@extends('hrms.layouts.base')

@section('content')
@section('title') HOME PAGE @endsection
    <div class="content">
        <div class="row">
            @foreach($news as $new)
            <div class="border-content">
                <div class="col-sm-12 content-card">
                    <div class="row">
                        <div class="col-md-1">
                            @php ($avatar = asset("assets/img/avatars/$new->photo"))
                            <img src="{{ $avatar }}" class="img-circle" height="50" width="50" alt="Avatar">
                        </div>
                        <div class="user-info col-md-11">
                            <h6 class="tag-name">{{ $new->name }}</h6>
                            <!-- <small>Sep 25, 2015, 8:25 PM</small> -->
                            <small>{{ Carbon\Carbon::parse($new->updated_at)->format('Y-m-d H:i:s') }}</small>
                        </div>
                    </div>
                    <div class="post-content">
                        @if($new->type === 2 || $new->type === 3)
                        <h3>Request announcement</h3>
                        <p>{{ $new->name }} has been approve your request!</p>
                        @else
                        <h3>{{ $new->title }}</h3>
                        <p>{!! $new->content !!}</p>
                        @endif
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
