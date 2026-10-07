<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Student')
        | K-12 LMS
    </title>

    @vite([
        'resources/js/app.js'
    ])

</head>

<body>

<div class="app-wrapper">

    <aside class="sidebar">

        <div class="sidebar-brand">

            <i class="bi bi-house-door-fill me-2"></i>

            K-12 LMS

            <small>
                Elementary Student
            </small>

        </div>


        <nav class="sidebar-menu">

            <div class="sidebar-heading">
                Overview
            </div>


            <a
                href="{{ route('student.dashboard') }}"
                class="{{
                    request()->routeIs(
                        'student.dashboard'
                    )
                    ? 'active'
                    : ''
                }}"
            >
                <i class="bi bi-grid"></i>
                Dashboard
            </a>


            <a
                href="{{ route('student.subjects.index') }}"
                class="{{
                    request()->routeIs(
                        'student.subjects.*'
                    )
                    ? 'active'
                    : ''
                }}"
            >
                <i class="bi bi-journal-bookmark"></i>
                My Subjects
            </a>


            <a
                href="{{ route('student.grades.index') }}"
                class="{{
                    request()->routeIs(
                        'student.grades.*'
                    )
                    ? 'active'
                    : ''
                }}"
            >
                <i class="bi bi-award"></i>
                My Grades
            </a>


            <a
                href="{{ route('student.announcements.index') }}"
                class="{{
                    request()->routeIs(
                        'student.announcements.*'
                    )
                    ? 'active'
                    : ''
                }}"
            >
                <i class="bi bi-megaphone"></i>
                Announcements
            </a>

        </nav>

    </aside>


    <main class="main-content">

        <header class="topbar">

            <strong>
                @yield(
                    'page-title',
                    'Student'
                )
            </strong>


            <div class="d-flex align-items-center gap-3">

                <i class="bi bi-bell"></i>

                <div class="text-end">

                    <div class="fw-semibold">
                        {{ auth()->user()->name }}
                    </div>

                    <small class="text-muted">
                        Student
                    </small>

                </div>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        class="btn btn-sm btn-outline-danger"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </header>


        <section class="page-content">

            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach(
                        $errors->all()
                        as $error
                    )

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            @yield('content')

        </section>

    </main>

</div>

@stack('scripts')

</body>
</html>