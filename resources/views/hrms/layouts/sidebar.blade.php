@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp

<!-- Sidebar Author -->
<div class="sidebar-widget author-widget">
    <div class="media">
        <a href="{{route('employee.myProfile')}}">
            @if(isset(Auth::user()->employee()->photo))
                <img src="{{asset('photos/'.Auth::user()->employee->photo)}}" width="40px" height="30px" class="img-responsive">
            @else
                <img src="/assets/img/avatars/profile_pic.png" class="img-circle">
            @endif
        </a>

        <div class="media-body">
                <a href="{{route('employee.myProfile')}}">
                </a>
                <p>{{Auth::user()->employee->name}}</p>
                <p>{{Auth::user()->employee->code}}
                @if (isset(Auth::user()->employee->department->description))
                    {{" - "}}
                    @if (isset(Auth::user()->employee->position->description))
                        {{Auth::user()->employee->position->description. " "}} 
                    @endif
                        <a href="{{ route('employee.myDepartment') }}">
                        {{Auth::user()->employee->department->description}}
                @endif
        </div>
    </div>
</div>

<!-- Sidebar Menu -->
<ul class="nav sidebar-menu scrollable">
    <!-- Quản lý -->
    <li>
        <a href="{{route('index')}}">
            <span class="glyphicon glyphicon-home"></span>
            <span class="sidebar-title">Home Page</span>
        </a>
    </li>

    <!-- Nghỉ phép -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-calendar"></span>
            <span class="sidebar-title">Nghỉ phép</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('leave.create')}}">
                    <span class="glyphicon glyphicon-tags"></span>Tạo yêu cầu</a>
            </li>
            <li>
                <a href="{{route('leave.myLeave')}}">
                    <span class="glyphicon glyphicon-tags"></span>Lịch sử</a>
            </li>
        </ul>
    </li>

    <!-- Device -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-laptop"></span>
            <span class="sidebar-title">Devices</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{ route('device.index') }}">
                    <span class="glyphicon glyphicon-tags"></span>List of devices</a>
            </li>
            <li>
                <a href="">
                    <span class="glyphicon glyphicon-tags"></span>Yêu cầu thiết bị</a>
            </li>

            <li>
                <a href="">
                    <span class="glyphicon glyphicon-tags"></span>Thiết bị của tôi</a>
            </li>
            @if(Auth::user()->isManager())
                <li>
                    <a href="">
                        <span class="glyphicon glyphicon-tags"></span>Thêm thiết bị</a>
                </li>
            @endif
        </ul>
    </li>

    <!-- Employee -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-user"></span>
            <span class="sidebar-title">Employees</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{ route('employee.myDepartment') }}">
                    <span class="glyphicon glyphicon-tags"></span>My department
                </a>
            </li>
            @if(Auth::user()->isManager())
                <li>
                    <a href="{{ route('employee.create') }}">
                        <span class="glyphicon glyphicon-tags"></span>Add New Employee</a>
                </li>
                
                <li>
                    <a href="{{ route('employee.index') }}">
                        <span class="glyphicon glyphicon-tags"></span>List of employees</a>
                </li>
            @endif
        </ul>
    </li>

    @if(Auth::user()->isManager())
        <!-- Department -->
        <li>
            <a class="accordion-toggle" href="#">
                <span class="fa fa-sitemap"></span>
            <span class="sidebar-title">Departments</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('department.index')}}">
                        <span class="glyphicon glyphicon-tags"></span>List of Departments</a>
                </li>
                <li>
                    <a href="{{route('department.create')}}">
                        <span class="glyphicon glyphicon-tags"></span>Add New Department</a>
                </li>
            </ul>
        </li>
        @endif
    
    <p> &nbsp; </p>
</ul>
<!-- -------------- /Sidebar Menu  -------------- -->
