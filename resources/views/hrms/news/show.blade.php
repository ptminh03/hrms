@extends('hrms.layouts.base')
@section('content')
@section('title') NEWS @endsection
    <div class="panel-heading">
        <span class="text-info panel-title hidden-xs">News Details</span>
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
                                <p><strong>Title</strong></p>
                                <div class="col-sm-12 content-card">
                                    <p><strong>{{ $news->title }}</strong></p> 
                                </div>
                            </div>

                        <div class="form-group">
                            <p><strong>Content</strong></p>
                            <div class="col-sm-12 content-card">
                                {!! $news->content !!}
                            </div>
                        </div>
                    </form>
                    
                    <div class="pull-right">
                        @if ( Auth::user()->employee->id == $news->target_id )
                            <a href="{{ route('news.edit', ['id' => request()->id]) }}" class="btn btn-md btn-info mx-5">Edit</a>
                            <form action="{{ route('news.delete', ['id' => request()->id]) }}" method="POST" class="inline-object mx-5">
                                {!! method_field('delete') !!}
                                {!! csrf_field() !!}

                                <button class="btn btn-md btn-danger" onclick="return confirm('Are you sure to delete this news ?');">
                                    Delete
                                </button>
                            </form>
                        @endif
                        <a href="{{ url()->previous() }}" class="btn btn-md btn-default mx-5">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
    <script>
        CKEDITOR.replace( 'textarea1' );
    </script>
@endsection
