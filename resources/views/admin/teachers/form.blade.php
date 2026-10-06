@extends('layouts.admin')

@php
    $editing = isset($teacher);
@endphp

@section(
    'title',
    $editing
        ? 'Edit Teacher'
        : 'Add Teacher'
)

@section(
    'page-title',
    $editing
        ? 'Edit Teacher'
        : 'Add Teacher'
)

@section('content')

<div class="card form-card">

<div class="card-body p-4">

<form
    method="POST"
    action="{{
        $editing
        ? route(
            'admin.teachers.update',
            $teacher
        )
        : route(
            'admin.teachers.store'
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
            Employee Number
        </label>

        <input
            name="employee_number"
            class="form-control"
            value="{{
                old(
                    'employee_number',
                    $teacher
                    ->employee_number
                    ?? ''
                )
            }}"
        >

    </div>


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
                    $teacher
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
                    $teacher
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
                    $teacher
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
                    $teacher
                    ->suffix
                    ?? ''
                )
            }}"
        >

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
                    $teacher
                    ->email
                    ?? ''
                )
            }}"
        >

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Contact Number
        </label>

        <input
            name="contact_number"
            class="form-control"
            value="{{
                old(
                    'contact_number',
                    $teacher
                    ->contact_number
                    ?? ''
                )
            }}"
        >

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Status
        </label>

        <select
            name="status"
            class="form-select"
        >

            <option
                value="active"
                @selected(
                    old(
                        'status',
                        $teacher->status
                        ?? 'active'
                    )
                    === 'active'
                )
            >
                Active
            </option>

            <option
                value="inactive"
                @selected(
                    old(
                        'status',
                        $teacher->status
                        ?? ''
                    )
                    === 'inactive'
                )
            >
                Inactive
            </option>

        </select>

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
    Save Teacher
</button>

<a
    href="{{
        route(
            'admin.teachers.index'
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