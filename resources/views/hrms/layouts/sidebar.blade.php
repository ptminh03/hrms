@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp

<!-- Sidebar Author -->
<div class="sidebar-widget author-widget">
    <div class="media">
        <a href="{{route('employee.showMyProfile')}}">
            @if(isset(Auth::user()->employee()->photo))
                <img src="{{asset('photos/'.Auth::user()->employee->photo)}}" width="40px" height="30px" class="img-responsive">
            @else
                <img src="/assets/img/avatars/profile_pic.png" class="img-circle">
            @endif
        </a>

        <div class="media-body">
                <a href="{{route('employee.showMyProfile')}}">
                </a>
                <p>{{Auth::user()->employee->name}}</p>
                <p>{{Auth::user()->employee->code}} -
                @if(Auth::user()->employee->position->description != 'None')
                    {{Auth::user()->employee->position->description}}
                @endif
                    {{Auth::user()->employee->department->description}}</p>
        </div>
    </div>
</div>

<!-- Sidebar Menu -->
<ul class="nav sidebar-menu scrollable">
    <!-- Quản lý -->
    <li>
        <a href="{{route('index')}}">
            <span class="glyphicon glyphicon-home"></span>
            <span class="sidebar-title">Trang chủ</span>
        </a>
    </li>

    <!-- Nghỉ phép -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-calendar"></span>
            <span class="sidebar-title">Nghỉ phép</span>
            <span class="fa fa-caret-square-o-left"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('leave.showAdd')}}">
                    <span class="glyphicon glyphicon-tags"></span>Tạo yêu cầu</a>
            </li>
            <li>
                <a href="{{route('leave.showMyLeave')}}">
                    <span class="glyphicon glyphicon-tags"></span>Lịch sử</a>
            </li>
        </ul>
    </li>

    {{--  <!-- Chuyên môn -->
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-sitemap"></span>
            <span class="sidebar-title">Chuyên môn</span>
            <span class="fa fa-caret-square-o-left"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('employee.department')}}">
                    <span class="glyphicon glyphicon-tags"></span>Thành viên</a>
            </li>
        </ul>
    </li>  --}}

    <!-- Thiết bị -->
    <li>
        <a class="accordion-toggle" href="/dashboard">
            <span class="fa fa-laptop"></span>
            <span class="sidebar-title">Thiết bị</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="">
                    <span class="glyphicon glyphicon-tags"></span>Yêu cầu thiết bị</a>
            </li>

            <li>
                <a href="">
                    <span class="glyphicon glyphicon-tags"></span>Thiết bị của tôi</a>
            </li>
        </ul>
    </li>

    <!-- Nhân viên -->
    <li>
        <a class="accordion-toggle" href="/dashboard">
            <span class="fa fa-child"></span>
            <span class="sidebar-title">Nhân viên</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="">
                    <span class="glyphicon glyphicon-tags"></span>Danh sách nhân viên</a>
            </li>
            @if(Auth::user()->isManager())
                <li>
                    <a href="{{route('employee.showAdd')}}">
                        <span class="glyphicon glyphicon-tags"></span>Thêm nhân viên</a>
                </li>
                <li>
                    <a href="{{route('employee.showDepartment')}}">
                        <span class="glyphicon glyphicon-tags"></span>Thành viên</a>
                </li>
            @endif
        </ul>
    </li>

        {{--  <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="fa fa-group"></span>
                <span class="sidebar-title">Quản lý nhóm</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('add-team')}}">
                        <span class="glyphicon glyphicon-book"></span> Thêm mới </a>
                </li>
                <li>
                    <a hre="{{route('team-listing')}}">
                        <span class="glyphicon glyphicon-modal-window"></span> Danh sách nhóm </a>
                </li>
            </ul>
        </li>

        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="fa fa-graduation-cap"></span>
                <span class="sidebar-title">Roles</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('add-role')}}">
                        <span class="glyphicon glyphicon-book"></span> Add Role </a>
                </li>
                <li>
                    <a href="{{route('role-list')}}">
                        <span class="glyphicon glyphicon-modal-window"></span> Role Listings </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="fa fa fa-laptop"></span>
                <span class="sidebar-title">Assets</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('add-asset')}}">
                        <span class="glyphicon glyphicon-shopping-cart"></span> Add Asset </a>
                </li>
                <li>
                    <a href="{{route('asset-listing')}}">
                        <span class="glyphicon glyphicon-calendar"></span> Asset Listings </a>
                </li>
                <li>
                    <a href="{{route('assign-asset')}}">
                        <span class="fa fa-desktop"></span> Assign Asset </a>
                </li>
                <li>
                    <a href="{{route('assignment-listing')}}">
                        <span class="fa fa-clipboard"></span> Assignment Listings </a>
                </li>
            </ul>
        </li>
    <li>
        <a class="accordion-toggle" href="/dashboard">
            <span class="fa fa-calendar"></span>
            <span class="sidebar-title">Nghỉ phép</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('apply-leave')}}">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Tạo yêu cầu </a>
            </li>
            <li>
                <a href="{{route('my-leave-list')}}">
                    <span class="glyphicon glyphicon-calendar"></span> Danh sách nghỉ phép của bạn </a>
            </li>

            @if(Auth::user()->isManager())
                <li>
                    <a href="{{route('add-leave-type')}}">
                        <span class="fa fa-desktop"></span> Thêm kiểu nghỉ phép </a>
                </li>
                <li>
                    <a href="{{route('leave-type-listing')}}">
                        <span class="fa fa-clipboard"></span> Danh sách kiểu nghỉ phép </a>
                </li>
            @endif
            @if(Auth::user()->isManager())
                <li>
                    <a href="{{route('total-leave-list')}}">
                        <span class="fa fa-clipboard"></span> Danh sách yêu cầu nghỉ phép </a>
                </li>
            @endif
        </ul>
    </li>

    @if(Auth::user()->isManager())
        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="fa fa-arrow-circle-o-up"></span>
                <span class="sidebar-title">Thăng cấp nhân viên</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="/promotion">
                        <span class="glyphicon glyphicon-book"></span> Tạo yêu cầu </a>
                </li>
                <li>
                    <a href="/show-promotion">
                        <span class="glyphicon glyphicon-modal-window"></span> Danh sách </a>
                </li>
            </ul>
        </li>

        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="fa fa-money"></span>
                <span class="sidebar-title">Chi phí</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('add-expense')}}">
                        <span class="glyphicon glyphicon-book"></span> Thêm mới </a>
                </li>
                <li>
                    <a href="{{route('expense-list')}}">
                        <span class="glyphicon glyphicon-modal-window"></span> Danh sách </a>
                </li>
            </ul>
        </li>

        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="fa fa fa-trophy"></span>
                <span class="sidebar-title">Awards</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="/add-award">
                        <span class="fa fa-adn"></span> Add Award </a>
                </li>
                <li>
                    <a href="/award-listing">
                        <span class="glyphicon glyphicon-calendar"></span> Award Listings </a>
                </li>
                <li>
                    <a href="/assign-award">
                        <span class="fa fa-desktop"></span> Awardees </a>
                </li>
                <li>
                    <a href="/awardees-listing">
                        <span class="fa fa-clipboard"></span> Awardees Listings </a>
                </li>
            </ul>
        </li>
    @endif


    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa fa-gavel"></span>
            <span class="sidebar-title">Trainings</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            @if(Auth::user()->isManager())
                <li>
                    <a href="/add-training-program">
                        <span class="fa fa-adn"></span> Add Training Program </a>
                </li>
            @endif
            <li>
                <a href="/show-training-program">
                    <span class="glyphicon glyphicon-calendar"></span> Program Listings </a>
            </li>
            @if(Auth::user()->isManager())
                <li>
                    <a href="/add-training-invite">
                        <span class="fa fa-desktop"></span> Training Invite </a>
                </li>
            @endif
            <li>
                <a href="/show-training-invite">
                    <span class="fa fa-clipboard"></span> Invitation Listings </a>
            </li>
        </ul>
    </li>
    @if(Auth::user()->isManager())
        <li>
            <a class="accordion-toggle" href="#">
                <span class="fa fa-clock-o"></span>
                <span class="sidebar-title"> Attendance </span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('attendance-upload')}}">
                        <span class="glyphicon glyphicon-book"></span> Upload Sheets</a>
                </li>

            </ul>
        </li>

        <li>
            <a class="accordion-toggle" href="#">
                <span class="fa fa-tree"></span>
                <span class="sidebar-title">Holiday</span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="/add-holidays">
                        <span class="glyphicon glyphicon-book"></span> Add Holiday </a>
                </li>
                <li>
                    <a href="/holiday-listing">
                        <span class="glyphicon glyphicon-modal-window"></span> Holiday Listings </a>
                </li>
            </ul>
        </li>

    @endif

    <li>
        <a href="/create-meeting">
            <span class="fa fa-calendar-o"></span>
            <span class="sidebar-title"> LỊCH HỌP </span>
        </a>
    </li>

    <!-- @if(Auth::user()->isManager())
        <li>
            <a href="/create-event">
                <span class="fa fa-calendar-o"></span>
                <span class="sidebar-title"> Event  &nbsp Invitation </span>
            </a>
        </li>
    @endif -->
    <li>

        <a href="/download-forms">
            <span class="fa fa-book"></span>
            <span class="sidebar-title">Download Forms</span>

        </a>
    </li>

    <li>
        <a href="/hr-policy">
            <span class="fa fa-gavel"></span>
            <span class="sidebar-title"> Company Policy </span>
        </a>
    </li>  --}}
    
    <p> &nbsp; </p>
</ul>
<!-- -------------- /Sidebar Menu  -------------- -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        /*var $icon = $('.sidebar-menu li a span.fa-caret-square-o-left');
        var $li = $icon.parent().parent();
        $li.on('click', function (event){
            $e = $(event.target);
            $a = $e.children();
            $lastSpan = $a.children().last();
            console.log($a);
            if($a.hasClass('menu-open')) {
                $lastSpan.addClass('fa-caret-square-o-left').removeClass('fa-caret-square-o-down');
            } else {
                $lastSpan.addClass('fa-caret-square-o-down').removeClass('fa-caret-square-o-left');
            }
        });*/
    });
</script>
