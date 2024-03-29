@extends('hrms.layouts.base')
@section('content')
@section('title') POSITIONS @endsection
    <div class="panel-heading">
        <span class="panel-title hidden-xs text-primary"> EDIT POSITION </span>
    </div>
    <div class="panel-body pn">
        @if(Session::has('message'))
            <div class="alert {{Session::get('class')}}" role="alert">
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

        <form action="{{ route('position.update', ['id' => $position->id]) }}" method="POST">
            {!! csrf_field() !!}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label>Name
                    <span class="text-danger">*<span>
                </label>
                <input type="text" class="form-control w-25"  placeholder="Name must be unique" name="name" value="{{ $position->name }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>                   
@endsection
