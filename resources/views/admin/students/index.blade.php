@extends('layouts.admin')

@section('title', 'Students')
@section('page-title', 'Students')

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center
    mb-4"
>

    <form
        class="d-flex gap-2"
        style="max-width:450px"
    >

        <input
            name="search"
            class="form-control"
            placeholder="Search student..."
            value="{{
                request('search')
            }}"
        >

        <button
            class="btn
            btn-outline-primary"
        >
            Search
        </button>

    </form>


    <a
        href="{{
            route(
                'admin.students.create'
            )
        }}"
        class="btn btn-primary"
    >
        Add Student
    </a>

</div>


<div class="card table-card">

<table
    class="table
    table-hover
    align-middle"
>

<thead>
<tr>
    <th class="ps-4">
        Student No.
    </th>
    <th>Name</th>
    <th>Current Placement</th>
    <th>Status</th>
    <th
        class="text-end pe-4"
    >
        Actions
    </th>
</tr>
</thead>

<tbody>

@foreach ($students as $student)

@php
    $currentEnrollment =
        $student
        ->enrollments
        ->first();
@endphp

<tr>

    <td class="ps-4">
        {{
            $student
            ->student_number
        }}
    </td>

    <td class="fw-semibold">
        {{
            $student
            ->full_name
        }}
    </td>

    <td>

        @if ($currentEnrollment)

            {{
                $currentEnrollment
                ->section
                ->gradeLevel
                ->name
            }}

            -

            {{
                $currentEnrollment
                ->section
                ->name
            }}

        @else
            <span class="text-muted">
                Not enrolled
            </span>
        @endif

    </td>

    <td>
        {{
            ucfirst(
                $student->status
            )
        }}
    </td>

    <td
        class="text-end pe-4"
    >

        <a
            href="{{
                route(
                    'admin.students.edit',
                    $student
                )
            }}"
            class="btn
            btn-sm
            btn-outline-primary"
        >
            Edit
        </a>

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-3">
    {{ $students->links() }}
</div>

@endsection