<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login | K-12 Integrated LMS
    </title>

    @vite([
        'resources/js/app.js'
    ])

</head>

<body>

<div class="container-fluid login-page">

    <div class="row min-vh-100">

        <div
            class="col-lg-6 d-none d-lg-flex"
        >

            <div class="login-side">

                <i
                    class="bi bi-building fs-1 mb-4"
                ></i>

                <h1>
                    Learn.<br>
                    Grow.<br>
                    Achieve.
                </h1>

                <p class="fs-5 mt-3">
                    Integrated Elementary
                    Learning Management and
                    Student Information System
                </p>

            </div>

        </div>


        <div
            class="col-lg-6
            d-flex
            align-items-center
            justify-content-center
            p-4"
        >

            <div
                class="card login-card p-4"
                style="
                    width:100%;
                    max-width:460px;
                "
            >

                <div class="card-body">

                    <div
                        class="text-center mb-4"
                    >

                        <i
                            class="bi bi-building
                            fs-1 text-primary"
                        ></i>

                        <h3
                            class="fw-bold mt-3"
                        >
                            K-12 Integrated LMS
                        </h3>

                        <p class="text-muted">
                            Elementary Level
                        </p>

                    </div>


                    @if ($errors->any())

                        <div
                            class="alert alert-danger"
                        >
                            {{
                                $errors->first()
                            }}
                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{
                            route(
                                'login.submit'
                            )
                        }}"
                    >

                        @csrf


                        <div class="mb-3">

                            <label
                                class="form-label"
                            >
                                Email /
                                Student Number /
                                Employee Number
                            </label>

                            <input
                                type="text"
                                name="login"
                                class="form-control"
                                value="{{
                                    old('login')
                                }}"
                                required
                                autofocus
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>


                        <div
                            class="form-check mb-4"
                        >

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="form-check-input"
                                id="remember"
                            >

                            <label
                                class="form-check-label"
                                for="remember"
                            >
                                Remember me
                            </label>

                        </div>


                        <button
                            class="btn
                            btn-primary
                            w-100 py-2"
                        >
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>