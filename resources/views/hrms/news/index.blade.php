@extends('hrms.layouts.base')
@section('content')
    @section('title') NEWS @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF NEWS </span>
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
                                    <input class="search-box" type="text" placeholder="Search by title" name="q" value="{{ request()->q }}">
                                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
        <div>
            
        @if ( !$news->isEmpty() )
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-center">ID</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Author</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($news as $new)
                            <tr>
                                <td class="text-center">{{ $new->id }}</td>
                                <td class="text-left">
                                    <a href="{{ route('news.show', ['id' => $new->id]) }}">
                                        {{ $new->showTitle() }}
                                    </a>
                                </td>

                                <td class="text-left">
                                    <a href="{{ route('employee.show', ['id' => $new->employee->id]) }}">
                                        {{ $new->employee->name }}
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('news.edit', ['id' => $new->id]) }}" 
                                        @if ( Auth::id() != $new->target_id )
                                            class="btn btn-xs btn-default" disabled>
                                        @else
                                            class="btn btn-xs btn-info">
                                        @endif
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>

                                    <form action="{{ route('news.delete', ['id' => $new->id]) }}" method="POST" class="inline-object">
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}
                                        
                                        <button
                                            @if ( Auth::id() != $new->target_id )
                                                class="btn btn-xs btn-default" disabled 
                                            @else
                                                class="btn btn-xs btn-danger" 
                                            @endif 
                                                onclick="return confirm('Are you sure to delete this device ?');">
                                                <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="paginate">
                    {{ $news->appends(['q' => request()->q])->render() }}
                </div>
            </div>
        @else
            <div>
                <h5 class="text-info">No data available</h5>
            </div>
        @endif
    </div>
@endsection
