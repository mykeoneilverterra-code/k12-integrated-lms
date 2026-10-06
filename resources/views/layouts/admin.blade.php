<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield(
            'title',
            'Admin'
        )
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

            <i
                class="bi bi-house-door-fill me-2"
            ></i>

            K-12 LMS

            <small>
                Elementary Administration
            </small>

        </div>


        <nav class="sidebar-menu">

            <div class="sidebar-heading">
                Overview
            </div>

            <a
                href="{{
                    route(
                        'admin.dashboard'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.dashboard'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-grid"></i>
                Dashboard
            </a>


            <div class="sidebar-heading">
                Academic Setup
            </div>

            <a
                href="{{
                    route(
                        'admin.school-years.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.school-years.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-calendar3"></i>
                School Years
            </a>

            <a
                href="{{
                    route(
                        'admin.grade-levels.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.grade-levels.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-layers"></i>
                Grade Levels
            </a>

            <a
                href="{{
                    route(
                        'admin.sections.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.sections.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-diagram-3"></i>
                Sections
            </a>

            <a
                href="{{
                    route(
                        'admin.subjects.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.subjects.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-book"></i>
                Subjects
            </a>

            <a
                href="{{
                    route(
                        'admin.curriculum.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.curriculum.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-journal-text"></i>
                Curriculum Blueprint
            </a>


            <div class="sidebar-heading">
                People
            </div>

            <a
                href="{{
                    route(
                        'admin.teachers.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.teachers.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i
                    class="bi bi-person-workspace"
                ></i>
                Teachers
            </a>

            <a
                href="{{
                    route(
                        'admin.students.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.students.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-people"></i>
                Students
            </a>


            <div class="sidebar-heading">
                Enrollment
            </div>

            <a
                href="{{
                    route(
                        'admin.enrollments.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.enrollments.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-person-check"></i>
                Enrollments
            </a>

            <a
                href="{{
                    route(
                        'admin.class-assignments.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'admin.class-assignments.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-person-video3"></i>
                Class Assignments
            </a>

        </nav>

    </aside>


    <main class="main-content">

        <header class="topbar">

            <div>

                <strong>
                    @yield(
                        'page-title',
                        'Admin'
                    )
                </strong>

            </div>


            <div
                class="d-flex
                align-items-center
                gap-3"
            >

                <i class="bi bi-bell"></i>

                <div class="text-end">

                    <div class="fw-semibold">
                        {{
                            auth()->user()->name
                        }}
                    </div>

                    <small class="text-muted">
                        Administrator
                    </small>

                </div>

                <form
                    method="POST"
                    action="{{
                        route('logout')
                    }}"
                >

                    @csrf

                    <button
                        class="btn
                        btn-sm
                        btn-outline-danger"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </header>


        <section class="page-content">

            @if (
                session('success')
            )

                <div
                    class="alert
                    alert-success
                    alert-dismissible
                    fade show"
                >

                    {{
                        session('success')
                    }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            @if (
                session('error')
            )

                <div
                    class="alert
                    alert-danger"
                >
                    {{
                        session('error')
                    }}
                </div>

            @endif


            @yield('content')

        </section>

    </main>

</div>


@stack('scripts')

</body>

</html>