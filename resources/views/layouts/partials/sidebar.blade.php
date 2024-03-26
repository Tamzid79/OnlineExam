<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand">
            <span class="align-middle text-capitalize">{{ $user->role }} Panel</span>
        </a>

        <ul class="sidebar-nav">

            @if ($user->role == 'admin')
                <li class="sidebar-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('admin/courses*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.courses.index') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Courses</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('admin/categories*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.categories.index') }}">
                        <i class="align-middle" data-feather="align-justify"></i> <span
                            class="align-middle">Categories</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('admin/questions*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.questions.index') }}">
                        <i class="align-middle" data-feather="help-circle"></i> <span class="align-middle">Question
                            Bank</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('admin/exams*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.exams.index') }}">
                        <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Exams</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('admin/students*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.students.index') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Students</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">All Users</span>
                    </a>
                </li>
            @elseif ($user->role == 'teacher')
                <li class="sidebar-item {{ Request::is('teacher/dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('teacher.dashboard') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('teacher/categories*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('teacher.categories.index') }}">
                        <i class="align-middle" data-feather="align-justify"></i> <span
                            class="align-middle">Categories</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('teacher/questions*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('teacher.questions.index') }}">
                        <i class="align-middle" data-feather="help-circle"></i> <span class="align-middle">Question
                            Bank</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('teacher/exams*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('teacher.exams.index') }}">
                        <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Exams</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('teacher/students*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('teacher.students.index') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Students</span>
                    </a>
                </li>
            @else
                <li class="sidebar-item {{ Request::is('/') ? 'active' : '' }}">
                    <a class="sidebar-link" href="/">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('my-results') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{route('myResults')}}">
                        <i class="align-middle" data-feather="list"></i> <span class="align-middle">My Results</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('change-password') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{route('changePassword')}}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                    </a>
                </li>
            @endif

        </ul>

    </div>
</nav>
