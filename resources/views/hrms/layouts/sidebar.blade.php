@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp

<!-- Sidebar Author -->
<div class="sidebar-widget author-widget">
    <div class="media text-center">
        <a href="{{route('employee.show', ['id' => Auth::user()->employee->id]) }}">
            <img src="{{ asset('/photos/'. Auth::user()->employee->photo) }}" width="" height="150px" class="img-circle">
        </a>

        <a href="{{route('employee.myProfile')}}">
            <p class="p-20 margintop-10">{{Auth::user()->employee->name}}</p>
        </a>
        <p class="p-15">{{Auth::user()->employee->code}}
        @if (isset(Auth::user()->employee->department->name))
            {{" - "}}
            @if (isset(Auth::user()->employee->position->name))
                {{Auth::user()->employee->position->name. " "}} 
            @endif
            <a href="{{ route('employee.myDepartment') }}">
            {{Auth::user()->employee->department->name}}
        @endif
    </div>
</div>

<!-- Sidebar Menu -->
<ul class="nav sidebar-menu scrollable text-uppercase">
    <!-- Home Page -->
    <li>
        <a href="{{route('index')}}">
            <span class="glyphicon glyphicon-home"></span>
            <span class="sidebar-title">Home Page</span>
        </a>
    </li>

    <!-- Leave -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-calendar"></span>
            <span class="sidebar-title">Leave</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            <li>
                <a href="{{ route('leave.create') }}"> Create Request </a>
            </li>

            <li>
                <a href="{{ route('leave.myLeave') }}"> My Leave </a>
            </li>

            @if(Auth::user()->isManager())
                <li>
                    <a href="{{ route('leave.request.history') }}"> Requests History </a>
                </li>

                <li>
                    <a href="{{ route('leave.request.pending') }}"> Requests Pending </a>
                </li>
            @endif
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
            @if(Auth::user()->isManager())
                <li>
                    <a href="{{ route('device.index') }}"> List of devices </a>
                </li>
                <li>
                    <a href="{{ route('device.create') }}"> Create New Device</a>
                </li>
                <li>
                    <a href="{{ route('device.status') }}"> Status of devices </a>
                </li>
            @endif

            <li>
                <a href="{{ route('device.myDevice') }}"> My Device </a>
            </li>
        </ul>
    </li>

    @if(Auth::user()->isManager())
        <!-- Device Type -->
        <li>
            <a class="accordion-toggle" href="#">
                <span class="glyphicon glyphicon-list-alt"></span>
                <span class="sidebar-title">Device Types</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{ route('device-type.create') }}"> Create New Type</a>
                </li>
                <li>
                    <a href="{{ route('device-type.index') }}"> List of Device Types</a>
                </li>
            </ul>
        </li>
    @endif

    <!-- Employee -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-user"></span>
            <span class="sidebar-title">Employees</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            @if(Auth::user()->isManager())
                <li>
                    <a href="{{ route('employee.index') }}"> List of employees </a>
                </li>
                
                <li>
                    <a href="{{ route('employee.create') }}"> Create New Employee </a>
                </li>
            @endif

            <li>
                <a href="{{ route('employee.myDepartment') }}"> My department </a>
            </li>

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
                    <a href="{{route('department.index')}}"> List of Departments </a>
                </li>
                <li>
                    <a href="{{route('department.create')}}"> Create New Department </a>
                </li>
            </ul>
        </li>

        <!-- Position -->
        <li>
            <a class="accordion-toggle" href="#">
                <span class="fa fa-bullseye"></span>
            <span class="sidebar-title">Positions</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('position.index')}}"> List of Positions </a>
                </li>
                <li>
                    <a href="{{route('position.create')}}"> Create New Position </a>
                </li>
            </ul>
        </li>
    @endif
    
    <!-- Policy -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="glyphicon glyphicon-lock"></span>
        <span class="sidebar-title">Policy</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('policy.index')}}"> List of Policies </a>
            </li>

            @if(Auth::user()->isManager())
                <li>
                    <a href="{{route('policy.create')}}"> Create New Policy </a>
                </li>
            @endif
        </ul>
    </li>

    @if( Auth::user()->isManager() )
    <!-- News -->
        <li>
            <a class="accordion-toggle" href="#">
                <span class="glyphicon glyphicon-pencil"></span>
            <span class="sidebar-title">News</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('news.index')}}"> List of News </a>
                </li>
            
                <li>
                    <a href="{{route('news.create')}}"> Create New News </a>
                </li>
            </ul>
        </li>
    @endif

    @if( Auth::user()->isManager() )
    <!-- Salary -->
        <li>
            <a class="accordion-toggle" href="#">
                <span class="glyphicon glyphicon-pencil"></span>
            <span class="sidebar-title">Payments</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('payment.create')}}"> Create New Payment </a>
                </li>

                <li>
                    <a href="{{route('payment.index')}}"> List of Payment </a>
                </li>
            </ul>
        </li>
    @endif

    <p> &nbsp; </p>
</ul>
<!-- -------------- /Sidebar Menu  -------------- -->
