@extends('hrms.layouts.base')
@section('content')
@section('title') POSITIONS @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> LIST OF POSITIONS </span>
    </div>
    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{Session::get('class')}}">
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
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($positions as $position)
                    <tr>
                        <td class="text-center">{{$position->id}}</td>
                        <td class="text-center">{{$position->name}}</td>
                        <td class="text-center">
                            <a href="{{ route('position.edit', ['id' => $position->id]) }}" class="btn btn-xs btn-info">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a href="{{ route('position.delete', ['id' => $position->id]) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this position ?');">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
            <div class="paginate">
                {{ $positions->links() }}
            </div>
        </div>
    </div>                   
@endsection
