@extends('hrms.layouts.base')

@section('content')

    <section id="content" class="animated fadeIn">

        <div class="row" >

            <!-- -------------- FAQ Left Column -------------- -->
            <div class="col-md-12">
                <div class="box box-success">
                <div class="panel bg-gradient">

                    <div class="mt40">
                        <h2 class="text-muted mb20 mtn"> Policies </h2>
                        <div class="panel-group accordion" id="accordion1">

                            @foreach($policies as $index => $policy)
                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion-{{ $index }}">
                                        {{$index + 1}}. {{ $policy->title }}
                                    </a>
                                </div>
                                <div class="collapse policy-content" id="accordion-{{ $index }}">
                                    <div class="card card-body">
                                        {!! $policy->content !!}
                                    </div>
                                    <div>
                                        <div class="btn-container">
                                            <button class="btn btn-warning">Edit</button>
                                            <button class="btn btn-error">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- -------------- FAQ Right Column -------------- -->
        </div>
    </section>
    <!-- -------------- /Content -------------- -->
    </section>
@endsection