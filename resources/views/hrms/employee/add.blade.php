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

            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')

                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-icon">
                            <a href="/dashboard">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        {{-- <li class="breadcrumb-active">
                             <a href="#"> Chỉnh sửa thông tin</a>
                         </li>--}}
                        <li class="breadcrumb-link">
                            <a href="/dashboard"> Nhân viên </a>
                        </li>
                        <li class="breadcrumb-current-item"> Chỉnh sửa thông tin nhân viên {{$emps->name}} </li>
                    </ol>
                </div>

            @else

                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-icon">
                            <a href="/dashboard">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        <li class="breadcrumb-active">
                            <a href="/dashboard">Bảng điều khiển</a>
                        </li>
                        <li class="breadcrumb-link">
                            <a href="/add-employee"> Nhân viên </a>
                        </li>
                        <li class="breadcrumb-current-item"> Thêm thông tin</li>
                    </ol>
                </div>

            @endif
        </header>
        <!-- -------------- /Topbar -------------- -->

        <!-- -------------- Content -------------- -->
        <section id="content" class="animated fadeIn">

            <div class="mw1000 center-block">
                @if(session('message'))
                    {{session('message')}}
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ session::get('flash_message') }}
                    </div>
                    @endif

                            <!-- -------------- Wizard -------------- -->
                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">

                        <form method="post" action="/add-employee" id="custom-form-wizard">
                            <div class="wizard steps-bg steps-left">

                                <!-- -------------- step 1 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-user pr5"></i> Thông tin cá nhân</h4>
                                <section class="wizard-section">

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Email</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="email" id="email" class="gui-input"
                                                       value="@if($emps && $emps->employee->code){{$emps->employee->code}}@endif" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            @else
                                                <input type="text" name="email" id="email" class="gui-input"
                                                       placeholder="" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label for="photo-upload"><h6 class="mb20 mt40"> Hình ảnh </h6></label>
                                        <label class="field prepend-icon append-button file">
                                            <span class="button">Chọn hình ảnh</span>
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="hidden" value="edit-emp/{{$emps->id}}" id="url">

                                                <input type="file" class="gui-file" name="photo" id="photo_upload"
                                                       value="@if($emps && $emps->photo){{$emps->photo}}@endif"
                                                       onChange="document.getElementById('uploader1').value = this.value;">
                                                <input type="text" class="gui-input" id="uploader1"
                                                       placeholder="Select File">
                                                <label class="field-icon">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </label>
                                            @else
                                                <input type="hidden" value="add-employee" id="url">
                                                <input type="file" class="gui-file" name="photo" id="photo_upload"
                                                       onChange="document.getElementById('uploader1').value = this.value;">
                                                <input type="text" class="gui-input" id="uploader1"
                                                       placeholder="Select File">
                                                <label class="field-icon">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>

                                    <!-- -------------- /section -------------- -->

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Mã số nhân viên</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="emp_code" id="emp_code" class="gui-input"
                                                       value="@if($emps && $emps->employee->code){{$emps->employee->code}}@endif" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            @else
                                                <input type="text" name="emp_code" id="emp_code" class="gui-input"
                                                       placeholder="" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Tên nhân viên </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="emp_name" id="emp_name" class="gui-input"
                                                       value="@if($emps && $emps->employee->name){{$emps->employee->name}}@endif" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            @else
                                                <input type="text" name="emp_name" id="emp_name" class="gui-input"
                                                       placeholder="" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Chuyên môn</h6></label>
                                        @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                            <select class="select2-single form-control" name="department" id="department" readonly required>
                                                <option value="">Select one</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}">{{$department->description}}</option>
                                                @endforeach
                                            </select>
                                            @else
                                            <select class="select2-single form-control" name="department" id="department">
                                                <option value="">Select one</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}">{{$department->description}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Trình độ</h6></label>
                                        @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                            <select class="select2-single form-control" name="position" id="position" readonly required>
                                                <option value="">Select one</option>
                                                @foreach($positions as $position)
                                                    <option value="{{$position->id}}">{{$position->description}}</option>
                                                @endforeach
                                            </select>
                                            @else
                                            <select class="select2-single form-control" name="position" id="position">
                                                <option value="">Select one</option>
                                                @foreach($positions as $position)
                                                    <option value="{{$position->id}}">{{$position->description}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Giới tính </h6></label>
                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="gender" id="gender"
                                                       @if(isset($emps))@if($emps->employee->gender == '0')checked @endif @endif>
                                                <span class="radio"></span>Nam</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="gender" id="gender"
                                                       @if(isset($emps))@if($emps->employee->gender == '1')checked @endif @endif>
                                                <span class="radio"></span>Nữ</label>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker1" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Ngày sinh </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker1" class="gui-input fs13" name="dob"
                                                       value="@if($emps && $emps->employee->date_of_birth){{$emps->employee->date_of_birth}}@endif" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker1" class="gui-input fs13" name="dob" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker4" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Ngày tham gia </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker4" class="gui-input fs13" name="doj"
                                                       value="@if($emps && $emps->employee->date_of_joining){{$emps->employee->date_of_joining}}@endif" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker4" class="gui-input fs13" name="doj" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Số điện thoại </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="number" name="mob_number" id="mobile_phone"
                                                       class="gui-input phone-group" maxlength="10" minlength="10" required
                                                       value="@if($emps && $emps->employee->number){{$emps->employee->number}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            @else
                                                <input type="number" name="mob_number" id="mobile_phone"
                                                       class="gui-input phone-group" maxlength="10" minlength="10" required
                                                       placeholder="mobile number...">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Địa chỉ</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="address" id="address" class="gui-input"
                                                       value="@if($emps && $emps->employee->current_address){{$emps->employee->current_address}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="current address..." name="address"
                                                       id="address" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <!-- -------------- /section -------------- -->
                                </section>
                                <!-- -------------- step 2 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-user-secret pr5"></i> Thông tin nhân viên</h4>
                                <section class="wizard-section">
                                    <!-- -------------- /section -------------- -->
                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Thủ tục tham gia </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="formalities"
                                                       id="formalities"
                                                       @if(isset($emps))@if($emps->employee->formalities == '1')checked @endif @endif>
                                                <span class="radio"></span>Đã hoàn thành</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="formalities" id="formalities"
                                                       @if(isset($emps))@if($emps->employee->formalities == '0')checked @endif @endif>
                                                <span class="radio"></span>Đang chờ xử lý</label>
                                        </div>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Chấp nhận đề nghị </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="offer_acceptance"
                                                       id="offer_acceptance"
                                                       @if(isset($emps))@if($emps->employee->offer_acceptance == '1')checked @endif @endif>
                                                <span class="radio"></span>Đã hoàn thành</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="offer_acceptance"
                                                       id="offer_acceptance"
                                                       @if(isset($emps))@if($emps->employee->offer_acceptance == '0')checked @endif @endif>
                                                <span class="radio"></span>Đang chờ xử lý</label>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Thời gian thử việc </h6></label>

                                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                            <select class="select2-single form-control probation_select" name="prob_period" id="probation_period" >
                                                <option value="">-- Chọn thời gian --</option>
                                                    @if($emps->employee->probation_period == '0')
                                                        <option value="0" selected>0 ngày</option>
                                                        <option value="90">90 ngày</option>
                                                        <option value="180">180 ngày</option>
                                                        <option value="Other">Other</option>
                                                    @elseif($emps->employee->probation_period == '90')
                                                        <option value="0">0 ngày</option>
                                                        <option value="90" selected>90 ngày</option>
                                                        <option value="180">180 ngày</option>
                                                        <option value="Other">Other</option>
                                                    @elseif($emps->employee->probation_period == '180')
                                                        <option value="0">0 ngày</option>
                                                        <option value="90">90 ngày</option>
                                                        <option value="180" selected>180 ngày</option>
                                                        <option value="Other">Other</option>
                                                     @else
                                                        <option value="0">0 ngày</option>
                                                        <option value="90">90 ngày</option>
                                                        <option value="180">180 ngày</option>
                                                        <option value="Other" selected>Other</option>

                                                    @endif
                                            </select>
                                                    <input type="text" class="form-control probation_text hidden" id="probation_text" value={{$emps->employee->probation_period}}>
                                                @else
                                                    <select class="select2-single form-control probation_select" name="prob_period" id="probation_period" >
                                                    <option value="">Select probation period</option>
                                                    <option value="0">0 days</option>
                                                    <option value="90">90 days</option>
                                                    <option value="180">180 days</option>
                                                    <option value="Other">Other</option>
                                                    </select>
                                            <input type="text" class="form-control probation_text hidden" id="probation_text">
                                                @endif


                                    </div>



                                    <div class="section">
                                        <label for="datepicker5" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Confirmation </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker5" class="gui-input fs13" name="doc"
                                                       value="@if($emps && $emps->employee->date_of_confirmation){{$emps->employee->date_of_confirmation}}@endif"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker5" class="gui-input fs13" name="doc"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Vị trí </h6></label>
                                            <select class="select2-single form-control" name="department" id="department">
                                                <option value="">-- Chọn vị trí --</option>
                                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                    @if($emps->employee->department == 'Marketplace')
                                                        <option value="Marketplace" selected>Marketplace</option>
                                                        <option value="Social Media">Social Media</option>
                                                        <option value="IT">IT</option>
                                                    @elseif($emps->employee->department == 'Social Media')
                                                        <option value="Marketplace">Marketplace</option>
                                                        <option value="Social Media" selected>Social Media</option>
                                                        <option value="IT">IT</option>
                                                    @else
                                                        <option value="Marketplace">Marketplace</option>
                                                        <option value="Social Media">Social Media</option>
                                                        <option value="IT" selected>IT</option>
                                                    @endif
                                                @else
                                                    <option value="Marketplace">Marketplace</option>
                                                    <option value="Social Media">Social Media</option>
                                                    <option value="IT">IT</option>
                                                @endif
                                            </select>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Mức lương  </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="salary" id="salary" class="gui-input"
                                                       value="@if($emps && $emps->employee->salary){{$emps->employee->salary}}@endif" readonly>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="e.g 12000" name="salary"
                                                       id="salary" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->


                                </section>

                                <!-- -------------- step 3 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-file-text pr5"></i> Thông tin tài khoản</h4>
                                <section class="wizard-section">


                                    <!-- -------------- /section -------------- -->


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Số tài khoản </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="account_number" id="bank_account_number"
                                                       class="gui-input"
                                                       value="@if($emps && $emps->employee->account_number){{$emps->employee->account_number}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="Bank account number"
                                                       name="account_number" id="bank_account_number" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Tên ngân hàng </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="bank_name" id="bank_name" class="gui-input"
                                                       value="@if($emps && $emps->employee->bank_name){{$emps->employee->bank_name}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-columns"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="name of bank..." name="bank_name"
                                                       id="bank_name" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-columns"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Tên người thụ hưởng </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="account_name" id="account_name" class="gui-input"
                                                       value="@if($emps && $emps->employee->account_name){{$emps->employee->account_name}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-font"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="ifsc code..." name="account_name"
                                                       id="account_name" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-font"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>



                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Status </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="pf_status" id="pf_status"
                                                       @if(isset($emps))@if($emps->employee->pf_status == '1')checked @endif @endif>
                                                <span class="radio"></span>Active</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="pf_status" id="pf_status"
                                                       @if(isset($emps))@if($emps->employee->pf_status == '0')checked @endif @endif>
                                                <span class="radio"></span>Inactive</label>
                                        </div>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                </section>


                                <h4 class="wizard-section-title">
                                    <i class="fa fa-file-text pr5"></i> Nhân viên cũ (nếu có) </h4>
                                <section class="wizard-section">


                                    <div class="section">
                                        <label for="datepicker6" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Ngày rời công ty </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker6" class="gui-input fs13" name="dor"
                                                       value="@if($emps && $emps->employee->date_of_resignation){{$emps->employee->date_of_resignation}}@endif"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker6" class="gui-input fs13" name="dor"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Notice Period </h6></label>
                                            <select class="select2-single form-control" name="notice_period" id="notice_period">
                                                <option value="">Select notice period</option>
                                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                    @if($emps->employee->notice_period == '1')
                                                        <option value="1" selected>1 Month</option>
                                                        <option value="2">2 Months</option>
                                                    @else
                                                        <option value="1">1 Month</option>
                                                        <option value="2" selected>2 Months</option>
                                                    @endif
                                                @else
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Months</option>
                                                @endif
                                            </select>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker7" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Last Working Day </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker7" class="gui-input fs13"
                                                       name="last_working_day"
                                                       value="@if($emps && $emps->employee->last_working_day){{$emps->employee->last_working_day}} @endif"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker7" class="gui-input fs13"
                                                       name="last_working_day"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Full & Final </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                                <input type="radio" value="1" name="full_final" id="full_final"
                                                       @if(isset($emps))@if($emps->employee->full_final == '1')checked @endif @endif>
                                                <span class="radio"></span>Yes</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="full_final" id="full_final"
                                                       @if(isset($emps))@if($emps->employee->full_final == '0')checked @endif @endif>
                                                <span class="radio"></span>No</label>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!-- -------------- /Wizard -------------- -->

                        </form>
                        <!-- -------------- /Form -------------- -->

                    </div>
                    <!-- -------------- /Spec Form -------------- -->

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