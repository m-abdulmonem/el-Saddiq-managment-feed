@include("site.layouts.head")
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        @if(request()->segment(1) !== "daily")
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        @else
            <ul class="navbar-nav">
                <li class="nav-item" style="letter-spacing: 13px">
                    <h5>MA-ERP</h5>
                </li>
            </ul>
        @endif
        <ul class="navbar-nav " style="margin-right: auto !important;">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge notify-count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notify-list">
{{--                    <span class="dropdown-header"><span class="notify-count">0</span> Notifications</span>--}}

{{--                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("dashboard.index") }}" style="cursor: pointer"><i class="fas fa-tachometer-alt"></i> @lang("home.open_dashboard")</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route("dailies.daily") }}" style="cursor: pointer"><i class="fas fa-folder-open"></i> @lang("home.open_daily")</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-calculator" style="cursor: pointer"><i class="fas fa-calculator"></i> @lang("home.open_calculator")</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    @if(!session("error-404"))
        @if(request()->segment(1) !== "daily")
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url("/") }}" class="brand-link">
            <img src="{{ admin_assets("img/MAAdminLogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">MA Admin</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ image(profile("picture"),true) }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a class="d-block">{{ profile("name") }}</a>
                    <a href="{{ url("profile/edit") }}" class="d-block"><b>@</b>{{ profile("username") }}</a>
                    <a href="{{ url("logout") }}" title="logout" class="logout"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <i class="fa fa-sign-out-alt"></i></a>
                    <form action="{{ route("logout") }}" id="logout-form" method="POST" class="d-none">@csrf</form>
                </div>
            </div>

            @include("site.layouts.navbar")

        </div>
        <!-- /.sidebar -->
    </aside>
        @else
            <style>
                .content-wrapper, .main-footer, .main-header {
                    margin-left: 0 !important;
                    margin-right: 0;
                }
            </style>
        @endif
    @else
        <style>
            .content-wrapper, .main-footer, .main-header {
                margin-left: 0 !important;
                margin-right: 0;
            }
        </style>
    @endif
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
