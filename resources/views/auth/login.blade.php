<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | K-12 LMS</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="login-page">

<div class="login-shell">

    {{-- =====================================================
        LEFT SIDE
    ====================================================== --}}
    <section class="login-hero">

        <div class="login-brand">

            <div class="login-brand-icon">
                <i class="bi bi-book-fill"></i>
            </div>

            <div>
                <div class="login-brand-name">
                    K-12 LMS
                </div>

                <div class="login-brand-subtitle">
                    Elementary Learning<br>
                    Management System
                </div>
            </div>

        </div>


        <div class="login-hero-content">

            <h1>
                A Brighter<br>
                Tomorrow<br>
                Through Learning
            </h1>

            <p>
                A safe, simple, and powerful learning platform
                for students, teachers, and administrators.
            </p>

        </div>


        <div class="login-school-art">

            <div class="login-cloud cloud-one"></div>
            <div class="login-cloud cloud-two"></div>

            <div class="login-school">

                <div class="school-roof"></div>

                <div class="school-clock">
                    <i class="bi bi-clock-fill"></i>
                </div>

                <div class="school-body">

                    <div class="school-windows">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="school-door"></div>

                </div>

            </div>

            <div class="login-tree tree-left">
                <div></div>
            </div>

            <div class="login-tree tree-right">
                <div></div>
            </div>

        </div>

    </section>


    {{-- =====================================================
        RIGHT SIDE
    ====================================================== --}}
    <section class="login-form-side">

        <div class="login-card">

            <div class="login-eyebrow">
                WELCOME BACK
            </div>

            <h2>
                Sign in to K-12 LMS
            </h2>

            <p class="login-description">
                Access your classroom, resources, activities,
                grades, and learning tools all in one place.
            </p>


            {{-- ROLE DISPLAY --}}
            <div class="login-role-grid">

                <div class="login-role-card admin-role">

                    <div class="login-role-icon">
                        <i class="bi bi-person-gear"></i>
                    </div>

                    <span>Admin</span>

                </div>


                <div class="login-role-card teacher-role">

                    <div class="login-role-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <span>Teacher</span>

                </div>


                <div class="login-role-card student-role">

                    <div class="login-role-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <span>Student</span>

                </div>

            </div>


            {{-- ERRORS --}}
            @if ($errors->any())

                <div class="login-error">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <div>
                        {{ $errors->first() }}
                    </div>

                </div>

            @endif


            {{-- LOGIN FORM --}}
            <form
                method="POST"
                action="{{ url('/login') }}"
                class="login-form"
            >

                @csrf


                <div class="login-field">

                    <label for="login">
                        Email or ID Number
                    </label>

                    <div class="login-input-wrap">

                        <i class="bi bi-envelope"></i>

                        <input
                            type="text"
                            id="login"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="Enter your email or ID number"
                            autocomplete="username"
                            required
                            autofocus
                        >

                    </div>

                </div>


                <div class="login-field">

                    <label for="password">
                        Password
                    </label>

                    <div class="login-input-wrap">

                        <i class="bi bi-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="passwordToggle"
                            aria-label="Show password"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                    </div>

                </div>


                <div class="login-options">

                    <label class="remember-control">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        <span>
                            Remember me
                        </span>

                    </label>

                </div>


                <button
                    type="submit"
                    class="login-submit"
                >
                    Sign In

                    <i class="bi bi-arrow-right"></i>
                </button>


                <div class="login-secure">

                    <i class="bi bi-shield-check"></i>

                    Secure K-12 learning platform

                </div>

            </form>

        </div>

    </section>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const toggle = document.getElementById('passwordToggle');

    if (!password || !toggle) {
        return;
    }

    toggle.addEventListener('click', function () {

        const icon = toggle.querySelector('i');

        if (password.type === 'password') {

            password.type = 'text';

            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');

        } else {

            password.type = 'password';

            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');

        }

    });

});
</script>

</body>
</html>