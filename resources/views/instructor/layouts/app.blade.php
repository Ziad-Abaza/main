<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard')</title>
    @include('instructor.layouts.links')
    @livewireStyles
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- Sidebar -->
    @include('instructor.layouts.sidebar')
    <!-- Main Content -->
    <main class="main-content border-radius-lg" style="margin-left: 250px;">
        <!-- Header -->
        @include('instructor.layouts.header')
        <!-- Page Content -->
        <div class="container-fluid py-4">
            <x-notification />
            @yield('content')
        </div>
        <!-- Footer & Scripts -->
        {{-- @include('dashboard.layouts.footer') --}}
    </main>
    @include('instructor.layouts.scripts')
    @livewireScripts
</body>

</html>
