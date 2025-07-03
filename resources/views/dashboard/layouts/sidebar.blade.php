<!-- resources/views/console/layouts/sidebar.blade.php -->
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
            <a href="{{ route('console') }}" class="m-0 ms-2 block d-flex align-items-center justify-content-center" style="width: 180px;">
                <img src="{{ asset('assets/image/brand/logo.png') }}" alt="main_logo" class="w-100 h-auto me-2" style="max-width: 90px; min-width: 60px;">
                <span class="fw-bold ms-1 align-middle"
                    style="
                        font-size: 0.95rem;
                        letter-spacing: 2px;
                        background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                        text-fill-color: transparent;
                        vertical-align: middle;
                        white-space: nowrap;
                    "
                >CTU</span>
            </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is(patterns: 'console') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Separator -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">User Management</h6>
            </li>

            <!-- Users -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/users*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.users.index') }}">
                    <i class="material-symbols-rounded opacity-5">people</i>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>

            <!-- Roles -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/roles*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.roles.index') }}">
                    <i class="material-symbols-rounded opacity-5">group</i>
                    <span class="nav-link-text ms-1">Roles</span>
                </a>
            </li>




            <!-- Separator -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Content Management
                </h6>
            </li>

            <!-- Categories -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/categories*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.categories.index') }}">
                    <i class="material-symbols-rounded opacity-5">category</i>
                    <span class="nav-link-text ms-1">Categories</span>
                </a>
            </li>

            <!-- Courses -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/courses*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.courses.index') }}">
                    <i class="material-symbols-rounded opacity-5">school</i>
                    <span class="nav-link-text ms-1">Courses</span>
                </a>
            </li>

            <!-- FAQ -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/faqs*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('dashboard.faq.index') }}">
                    <i class="material-symbols-rounded opacity-5">help</i>
                    <span class="nav-link-text ms-1">FAQs</span>
                </a>
            </li>

            <!-- Blog -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/blogs*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('dashboard.blog.index') }}">
                    <i class="material-symbols-rounded opacity-5">article</i>
                    <span class="nav-link-text ms-1">Blog</span>
                </a>
            </li>

            <!-- Contact -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/contacts*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('dashboard.contact.index') }}">
                    <i class="material-symbols-rounded opacity-5">mail</i>
                    <span class="nav-link-text ms-1">Contact Messages</span>
                </a>
            </li>

            <!-- Separator -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
                    Children Universities
                </h6>
            </li>
            <!-- Students -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/students*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.students.index') }}">
                    <i class="material-symbols-rounded opacity-5">group</i>
                    <span class="nav-link-text ms-1">Students</span>
                </a>
            </li>
            <!-- Absences -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/absences') ||
                (Request::is('console/absences/*') && !Request::is('console/absences/generate*'))
                    ? 'active bg-gradient-dark text-white'
                    : 'text-dark' }}"
                    href="{{ route('console.absences.index') }}">
                    <i class="material-symbols-rounded opacity-5">event_busy</i>
                    <span class="nav-link-text ms-1">Absences</span>
                </a>
            </li>

            <!-- Manage Students -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/children-students*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.children-students.index') }}">
                    <i class="material-symbols-rounded opacity-5">group</i>
                    <span class="nav-link-text ms-1">Manage Students</span>
                </a>
            </li>

            <!-- Manage Levels -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/levels*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.levels.index') }}">
                    <i class="material-symbols-rounded opacity-5">layers</i>
                    <span class="nav-link-text ms-1">Manage Levels</span>
                </a>
            </li>

            <!-- Manage Level Courses -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/level-courses*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.level-courses.index') }}">
                    <i class="material-symbols-rounded opacity-5">import_contacts</i>
                    <span class="nav-link-text ms-1">Manage Level Courses</span>
                </a>
            </li>

            <!-- Separator -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Management Account
                </h6>
            </li>

            <!-- Profile -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/profile*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('console.profile.index') }}">
                    <i class="material-symbols-rounded opacity-5">person</i>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            <!-- Settings -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('console/settings*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="">
                    <i class="material-symbols-rounded opacity-5">settings</i>
                    <span class="nav-link-text ms-1">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
