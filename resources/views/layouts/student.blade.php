<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Student') | K-12 LMS
    </title>


    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


@php

    $user = auth()->user();

    $studentName =
        $user->name
        ?? 'Student';

    $studentNameParts =
        preg_split(
            '/\s+/',
            trim($studentName)
        );

    $studentInitials = '';

    if (!empty($studentNameParts)) {

        $studentInitials =
            strtoupper(
                mb_substr(
                    $studentNameParts[0],
                    0,
                    1
                )
            );

        if (count($studentNameParts) > 1) {

            $studentInitials .=
                strtoupper(
                    mb_substr(
                        end($studentNameParts),
                        0,
                        1
                    )
                );

        }

    }

    if (!$studentInitials) {
        $studentInitials = 'ST';
    }

@endphp



<div class="k12-app">


    <div class="k12-sidebar-overlay"></div>



    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside class="k12-sidebar">


        <div class="k12-sidebar-brand">


            <div class="k12-sidebar-logo">

                <i class="bi bi-book-fill"></i>

            </div>


            <div>

                <h2>
                    K-12 LMS
                </h2>

                <small>
                    Elementary Student
                </small>

            </div>


        </div>



        <div class="k12-sidebar-section">
            OVERVIEW
        </div>


        <a
            href="{{ url('/student/dashboard') }}"
            class="
                k12-sidebar-link
                {{ request()->is('student/dashboard') ? 'active' : '' }}
            "
        >

            <i class="bi bi-house-fill"></i>

            <span>
                Dashboard
            </span>

        </a>


        <a
            href="{{ url('/student/subjects') }}"
            class="
                k12-sidebar-link
                {{ request()->is('student/subjects*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-book-fill"></i>

            <span>
                My Subjects
            </span>

        </a>


        <a
            href="{{ url('/student/grades') }}"
            class="
                k12-sidebar-link
                {{ request()->is('student/grades*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-award-fill"></i>

            <span>
                My Grades
            </span>

        </a>


        <a
            href="{{ url('/student/assignments') }}"
            class="
                k12-sidebar-link
                {{ request()->is('student/assignments*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-clipboard-check"></i>

            <span>
                Assignments
            </span>

        </a>


        <a
            href="{{ url('/student/quizzes') }}"
            class="
                k12-sidebar-link
                {{ request()->is('student/quizzes*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-question-square"></i>

            <span>
                Quizzes
            </span>

        </a>


        <a
            href="{{ url('/student/lessons') }}"
            class="
                k12-sidebar-link
                {{ request()->is('student/lessons*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-file-earmark-text"></i>

            <span>
                Lessons
            </span>

        </a>


        <a
            href="{{ url('/student/announcements') }}"
            class="
                k12-sidebar-link
                {{ request()->is('student/announcements*') ? 'active' : '' }}
            "
        >

            <i class="bi bi-megaphone-fill"></i>

            <span>
                Announcements
            </span>

        </a>


    </aside>



    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <div class="k12-main">


        <header class="k12-topbar">


            <div class="k12-topbar-left">


                <button
                    type="button"
                    class="k12-sidebar-toggle"
                    data-sidebar-toggle
                >

                    <i class="bi bi-list"></i>

                </button>


                <div class="k12-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        placeholder="Search anything..."
                    >

                </div>


            </div>



            <div class="k12-topbar-profile">


                <button
                    type="button"
                    class="k12-notification-button"
                >

                    <i class="bi bi-bell"></i>

                </button>


                <div class="k12-avatar">

                    {{ $studentInitials }}

                </div>


                <div>

                    <div class="k12-profile-name">

                        {{ $studentName }}

                    </div>

                    <div class="k12-profile-role">
                        Student
                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ url('/logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="k12-logout-button"
                    >

                        <i class="bi bi-box-arrow-right"></i>

                        Logout

                    </button>

                </form>


            </div>


        </header>



        <main class="k12-content">


            @if (session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                >

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif



            @if (session('error'))

                <div
                    class="alert alert-danger alert-dismissible fade show"
                >

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif



            @yield('content')


        </main>


    </div>


</div>


</body>

</html>