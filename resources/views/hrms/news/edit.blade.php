@extends('hrms.layouts.base')
@section('content')
@section('title') NEWS @endsection
    <div class="panel-heading">
        <span class="text-primary panel-title hidden-xs">Edit News</span>
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

                    <form action=" {{ route('news.update', ['id' => $news->id]) }} " method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
                        <div class="form-group">
                                <label class="col-md-2 control-label"> Title
                                    <span class="text-danger">*<span>
                                </label>
    
                                <div class="col-md-10">
                                    <input type="text" class="form-control"  placeholder="Title must be required" name="title" value="{{ $news->title }}" required>
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="input002" class="col-md-2 control-label"> Content </label>
                            <div class="col-md-10">
                                <textarea type="text" id="textarea1" class="select2-single form-control" name="content">
                                    {!! $news->content !!}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>

                            <div class="col-md-2">
                                <input type="submit" class="btn btn-md btn-info" value="Submit">
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
