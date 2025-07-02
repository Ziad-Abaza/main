<!-- resources/views/dashboard/layouts/sidebar.blade.php -->
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a href="{{ route('dashboard') }}" class="m-0 ms-2 block d-flex align-items-center justify-content-center" style="width: 180px;">
                <img src="{{ asset('assets/image/brand/brand-logo.png') }}" alt="main_logo" class="w-100 h-auto">
            </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('dashboard') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Separator -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Content Management
                </h6>
            </li>

            <!-- Courses -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('dashboard/courses*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('dashboard.courses.index') }}">
                    <i class="material-symbols-rounded opacity-5">school</i>
                    <span class="nav-link-text ms-1">Courses</span>
                </a>
            </li>

            <!-- Students -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('dashboard/students*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('dashboard.students.index') }}">
                    <i class="material-symbols-rounded opacity-5">group</i>
                    <span class="nav-link-text ms-1">Students</span>
                </a>
            </li>

        <!-- Enrollments -->
        <li class="nav-item">
            <a class="nav-link text-dark {{ Request::is('dashboard/enrollments*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                href="{{ route('dashboard.enrollments.index') }}">
                <i class="material-symbols-rounded opacity-5">how_to_reg</i>
                <span class="nav-link-text ms-1">Enrollments</span>
            </a>
        </li>

        <!-- Separator for Absences -->
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
                Attendance Management
            </h6>
        </li>

        <!-- Absences -->
        <li class="nav-item">
            <a class="nav-link text-dark {{
                Request::is('dashboard/absences') ||
                (Request::is('dashboard/absences/*') && !Request::is('dashboard/absences/generate*'))
                    ? 'active bg-gradient-dark text-white' : 'text-dark'
            }}" href="{{ route('dashboard.absences.index') }}">
                <i class="material-symbols-rounded opacity-5">event_busy</i>
                <span class="nav-link-text ms-1">Absences</span>
            </a>
        </li>

        <!-- Generate QR -->
        <li class="nav-item">
            <a class="nav-link text-dark {{
                Request::is('dashboard/absences/generate*')
                    ? 'active bg-gradient-dark text-white' : 'text-dark'
            }}" href="{{ route('dashboard.absences.generate') }}">
                <i class="material-symbols-rounded opacity-5">qr_code_2</i>
                <span class="nav-link-text ms-1">Generate QR</span>
            </a>
        </li>

            <!-- Separator -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
                    {{ config('app.name') }} Settings
                </h6>
            </li>

            <!-- Profile -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('dashboard/profile*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{route('dashboard.profile.index')}}">
                    <i class="material-symbols-rounded opacity-5">person</i>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
