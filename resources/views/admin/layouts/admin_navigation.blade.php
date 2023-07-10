<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="ti-home"></i><span class="badge badge-pill badge-primary float-right">2</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('users.index') }}" class=" waves-effect">
                        <i class="ti-user"></i>
                        <span>Users Details</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('banners.index') }}" class=" waves-effect">
                        <i class="far fa-image"></i>
                        <span>Banner Images</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('employee.index') }}" class=" waves-effect">
                        <i class='fas fa-users'></i>
                        <span>Employee Details</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
