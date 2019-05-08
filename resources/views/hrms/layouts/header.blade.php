<header class="navbar navbar-fixed-top bg-system">
    <div class="navbar-logo-wrapper dark bg-system">
        <a class="navbar-logo-text" href="{{route('index')}}">
            <b> HRM System </b>
        </a>

        <span id="sidebar_left_toggle" class="ad ad-lines"></span>
    </div>
    <ul class="nav navbar-nav navbar-left">
        <li class="hidden-xs">
            <a class="navbar-fullscreen toggle-active" href="#">
                <span class="glyphicon glyphicon-fullscreen"></span>
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown dropdown-fuse">
            <div class="navbar-btn btn-group">
        <li class="dropdown dropdown-fuse">
            <a href="#" class="dropdown-toggle fw600" data-toggle="dropdown">
                <span class="hidden-xs"><name><i class="fa fa-user"></i> {{Auth::user()->employee->name}}</name> </span>
                <span class="fa fa-caret-down hidden-xs mr15"></span>
            </a>
            </a>
                <ul class="dropdown-menu list-group keep-dropdown w250" role="menu">
                    @if(\Route::getFacadeRoot()->current()->uri() != 'change-password')
                    <li class="dropdown-footer text-center">
                        <a href="{{route('auth.change-password')}}" class="btn btn-primary btn-sm btn-bordered">
                            <span class="fa fa-lock pr5"></span> Change Password </a>
                    </li>
                    @endif
                    <li class="dropdown-footer text-center">
                        <a href="{{route('auth.logout')}}" class="btn btn-primary btn-sm btn-bordered">
                            <span class="fa fa-power-off pr5"></span> Logout </a>
                    </li>
                </ul>
        </li>
    </ul>
</header>