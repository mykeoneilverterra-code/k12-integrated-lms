@extends('layouts.admin')

@php
    $editing = isset($student);
@endphp

@section(
    'title',
    $editing
        ? 'Edit Student'
        : 'Add Student'
)

@section(
    'page-title',
    $editing
        ? 'Edit Student'
        : 'Add Student'
)

@section('content')

<div class="card form-card">

<div class="card-body p-4">

@if ($editing)

    <div
        class="alert
        alert-light
        border"
    >
        Student Number:
        <strong>
            {{
                $student
                ->student_number
            }}
        </strong>
    </div>

@endif


<form
    method="POST"
    action="{{
        $editing
        ? route(
            'admin.students.update',
            $student
        )
        : route(
            'admin.students.store'
        )
    }}"
>

@csrf

@if ($editing)
    @method('PUT')
@endif


<div class="row">

    <div class="col-md-4 mb-3">

        <label class="form-label">
            First Name
        </label>

        <input
            name="first_name"
            class="form-control"
            value="{{
                old(
                    'first_name',
                    $student
                    ->first_name
                    ?? ''
                )
            }}"
        >

    </div>


    <div class="col-md-4 mb-3">

        <label class="form-label">
            Middle Name
        </label>

        <input
            name="middle_name"
            class="form-control"
            value="{{
                old(
                    'middle_name',
                    $student
                    ->middle_name
                    ?? ''
                )
            }}"
        >

    </div>


    <div class="col-md-4 mb-3">

        <label class="form-label">
            Last Name
        </label>

        <input
            name="last_name"
            class="form-control"
            value="{{
                old(
                    'last_name',
                    $student
                    ->last_name
                    ?? ''
                )
            }}"
        >

    </div>


    <div class="col-md-2 mb-3">

        <label class="form-label">
            Suffix
        </label>

        <input
            name="suffix"
            class="form-control"
            value="{{
                old(
                    'suffix',
                    $student->suffix
                    ?? ''
                )
            }}"
        >

    </div>


    <div class="col-md-4 mb-3">

        <label class="form-label">
            Birth Date
        </label>

        <input
            type="date"
            name="birth_date"
            class="form-control"
            value="{{
                old(
                    'birth_date',
                    isset($student)
                    && $student->birth_date
                    ? $student
                        ->birth_date
                        ->format('Y-m-d')
                    : ''
                )
            }}"
        >

    </div>


    <div class="col-md-3 mb-3">

        <label class="form-label">
            Sex
        </label>

        <select
            name="sex"
            class="form-select"
        >

            <option value="">
                Select
            </option>

            <option
                value="Male"
                @selected(
                    old(
                        'sex',
                        $student->sex
                        ?? ''
                    )
                    === 'Male'
                )
            >
                Male
            </option>

            <option
                value="Female"
                @selected(
                    old(
                        'sex',
                        $student->sex
                        ?? ''
                    )
                    === 'Female'
                )
            >
                Female
            </option>

        </select>

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Email
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{
                old(
                    'email',
                    $student->email
                    ?? ''
                )
            }}"
        >

        <small class="text-muted">
            Optional. If blank, the
            system generates an
            internal login email.
        </small>

    </div>


    <div class="col-md-4 mb-3">

        <label class="form-label">
            Contact Number
        </label>

        <input
            name="contact_number"
            class="form-control"
            value="{{
                old(
                    'contact_number',
                    $student
                    ->contact_number
                    ?? ''
                )
            }}"
        >

    </div>


    <div class="col-md-4 mb-3">

        <label class="form-label">
            Status
        </label>

        <select
            name="status"
            class="form-select"
        >

            @foreach (
                [
                    'active',
                    'inactive',
                    'transferred'
                ]
                as $status
            )

                <option
                    value="{{ $status }}"
                    @selected(
                        old(
                            'status',
                            $student->status
                            ?? 'active'
                        )
                        === $status
                    )
                >
                    {{
                        ucfirst(
                            $status
                        )
                    }}
                </option>

            @endforeach

        </select>

    </div>


    <div class="col-12 mb-3">

        <label class="form-label">
            Address
        </label>

        <textarea
            name="address"
            class="form-control"
            rows="3"
        >{{
            old(
                'address',
                $student->address
                ?? ''
            )
        }}</textarea>

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Password
        </label>

        <input
            type="password"
            name="password"
            class="form-control"
        >

        @if ($editing)
            <small class="text-muted">
                Leave blank to keep
                existing password.
            </small>
        @endif

    </div>


    <div class="col-md-6 mb-4">

        <label class="form-label">
            Confirm Password
        </label>

        <input
            type="password"
            name="password_confirmation"
            class="form-control"
        >

    </div>

</div>


@if ($errors->any())

<div class="alert alert-danger">

@foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
@endforeach

</div>

@endif


<button class="btn btn-primary">
    Save Student
</button>

<a
    href="{{
        route(
            'admin.students.index'
        )
    }}"
    class="btn
    btn-outline-secondary"
>
    Cancel
</a>

</form>

</div>

</div>

@endsection