<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Teacher')
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
                Elementary Teacher
            </small>

        </div>


        <nav class="sidebar-menu">

            <div class="sidebar-heading">
                Overview
            </div>

            <a
                href="{{
                    route(
                        'teacher.dashboard'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'teacher.dashboard'
                    )
                    ? 'active'
                    : ''
                }}"
            >
                <i class="bi bi-grid"></i>
                Dashboard
            </a>


            <a
                href="{{
                    route(
                        'teacher.classes.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'teacher.classes.*'
                    )
                    ? 'active'
                    : ''
                }}"
            >
                <i class="bi bi-journal-bookmark"></i>
                My Classes
            </a>

        </nav>

    </aside>


    <main class="main-content">

        <header class="topbar">

            <strong>
                @yield(
                    'page-title',
                    'Teacher'
                )
            </strong>


            <div
                class="d-flex
                align-items-center gap-3"
            >

                <i class="bi bi-bell"></i>

                <div class="text-end">

                    <div class="fw-semibold">
                        {{
                            auth()->user()->name
                        }}
                    </div>

                    <small class="text-muted">
                        Teacher
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

            @if (session('success'))

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


            @if (session('error'))

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