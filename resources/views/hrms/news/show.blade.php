@extends('hrms.layouts.base')
@section('content')
@section('title') POLICIES @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs">Edit Policy</span>
    </div>
    <div class="text-center"></div>
        <div class="panel-body pn">
            <div class="table-responsive">
                <div class="panel-body p25 pb10">
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

                    <form action="" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
                        <div class="form-group">
                                <p>Title</p>
                                <label class="col-md-4 control-label">{{ $news->title }}</label>
    
                                <div class="control-label">
                                    {{--  <input type="text" class="form-control"  placeholder="Title must be required" name="title" value="{{ $policy->title }}" required>  --}}
                                </div>
                            </div>

                        <div class="form-group">
                            <p>Content</p>
                            <div class="col-sm-12 content-card">
                                {!! $news->content !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                
    <script>
        CKEDITOR.replace( 'textarea1' );
    </script>
@endsection
