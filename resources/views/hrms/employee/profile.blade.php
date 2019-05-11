<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title> HRMS </title>
    <meta name="keywords" content="HTML5, Bootstrap 3, Admin Template, UI Theme"/>
    <meta name="description" content="Alliance - A Responsive HTML5 Admin UI Framework">
    <meta name="author" content="ThemeREX">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
          type='text/css'>


    <!-- -------------- Icomoon -------------- -->
    {!! Html::style('/assets/fonts/icomoon/icomoon.css') !!}

            <!-- -------------- CSS - theme -------------- -->
    {!! Html::style('/assets/skin/default_skin/css/theme.css') !!}

            <!-- -------------- CSS - allcp forms -------------- -->
    {!! Html::style('/assets/allcp/forms/css/forms.css') !!}

    {!! Html::style('/assets/custom.css') !!}

            <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="/assets/img/favicon.png">

    <!-- -------------- IE8 HTML5 support  -------------- -->
    <!--[if lt IE 9]>
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js') !!}
    <![endif]-->

</head>

<body class="forms-wizard">
<!-- -------------- Body Wrap  -------------- -->
<div id="main">

    <!-- -------------- Header  -------------- -->
    @include('hrms.layouts.header')
            <!-- -------------- /Header  -------------- -->

    <!-- -------------- Sidebar  -------------- -->
    <aside id="sidebar_left" class="nano nano-light affix">

        <!-- -------------- Sidebar Left Wrapper  -------------- -->
        <div class="sidebar-left-content nano-content">

            <!-- -------------- Sidebar Header -------------- -->
            <header class="sidebar-header">


                @include('hrms.layouts.sidebar')

                        <!-- -------------- Sidebar Hide Button -------------- -->
                <div class="sidebar-toggler">
                    <a href="/dashboard">
                        <span class="fa fa-arrow-circle-o-left"></span>
                    </a>
                </div>
                <!-- -------------- /Sidebar Hide Button -------------- -->

            </header>
        </div>
        <!-- -------------- /Sidebar Left Wrapper  -------------- -->

    </aside>

    <!-- -------------- Main Wrapper -------------- -->
    <section id="content_wrapper">

        <!-- -------------- Topbar -------------- -->
        <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="{{route('index')}}">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-link">
                        @if(Auth::id() == $employee->id)
                            <a href="{{route('employee.showMyDetails')}}">Thông tin cá nhân</a>
                        @else
                            <a href="{{route('employee.showProfile', ['profile' => $employee->id ])}}">Thông tin nhân viên</a>
                        @endif
                    </li>
                </ol>
            </div>
        </header>
        <!-- -------------- /Topbar -------------- -->

        <!-- -------------- Content -------------- -->
         <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                                <span class="panel-title hidden-xs"> 
                                    @if(Auth::id() == $employee->id)
                                        Thông tin cá nhân
                                    @else
                                        Thông tin nhân viên
                                    @endif
                                </span>
                        </div>
                        <div class="panel-body pn">
                            <!-- Info -->
                            <p>{{$employee}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
    </section>
        <!-- -------------- /Content -------------- -->

    </section>

</div>

<!-- -------------- /Body Wrap  -------------- -->

<!-- Notification modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /Notification Modal -->
<style>
    /*page demo styles*/
    .wizard .steps .fa,
    .wizard .steps .glyphicon,
    .wizard .steps .glyphicon {
        display: none;
    }
</style>

@php
<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->

{!! Html::script('/assets/js/jquery/jquery-1.11.3.min.js') !!}
{!! Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js') !!}

        <!-- -------------- HighCharts Plugin -------------- -->
{!! Html::script('/assets/js/plugins/highcharts/highcharts.js') !!}

        <!-- -------------- MonthPicker JS -------------- -->
{!! Html::script('/assets/allcp/forms/js/jquery-ui-monthpicker.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery-ui-datepicker.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.spectrum.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.stepper.min.js') !!}


        <!-- -------------- Plugins -------------- -->
{!! Html::script('/assets/allcp/forms/js/jquery.validate.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.steps.min.js') !!}

        <!-- -------------- Theme Scripts -------------- -->
{!! Html::script('/assets/js/utility/utility.js') !!}
{!! Html::script('/assets/js/demo/demo.js') !!}
{!! Html::script('/assets/js/main.js') !!}
{!! Html::script('/assets/js/demo/widgets_sidebar.js') !!}
{!! Html::script('/assets/js/custom_form_wizard.js') !!}

{!!  Html::script ('/assets/js/pages/forms-widgets.js')!!}
@push('scripts')
<script src="/assets/js/custom_form_wizard.js"></script>
@endpush

        <!-- -------------- Select2 JS -------------- -->
<script src="/assets/js/plugins/select2/select2.min.js"></script>
<script src="/assets/js/function.js"></script>



<!-- -------------- /Scripts -------------- -->
</body>

</html>