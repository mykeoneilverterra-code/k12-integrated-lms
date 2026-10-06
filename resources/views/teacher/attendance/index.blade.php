@extends('layouts.teacher')

@section(
    'title',
    'Attendance'
)

@section(
    'page-title',
    'Attendance'
)

@section('content')

@include(
    'teacher.classes._tabs'
)


<form
    method="GET"
    class="mb-4"
>

<div
    class="d-flex gap-2"
    style="max-width:350px"
>

<input
    type="date"
    name="date"
    class="form-control"
    value="{{ $date }}"
>

<button
    class="btn
    btn-outline-primary"
>
    Load
</button>

</div>

</form>


<form
    method="POST"
    action="{{
        route(
            'teacher.attendance.store',
            $classSubject
        )
    }}"
>

@csrf

<input
    type="hidden"
    name="attendance_date"
    value="{{ $date }}"
>


<div class="card table-card">

<table
    class="table
    table-hover
    align-middle"
>

<thead>

<tr>
    <th class="ps-4">
        Student
    </th>
    <th>Attendance</th>
</tr>

</thead>

<tbody>

@foreach (
    $enrollments
    as $enrollment
)

@php

$current =
    $records->get(
        $enrollment->id
    );

@endphp

<tr>

<td class="ps-4 fw-semibold">

{{
    $enrollment
    ->student
    ->full_name
}}

</td>

<td>

<select
    name="attendance[
        {{ $enrollment->id }}
    ]"
    class="form-select"
    style="max-width:180px"
>

@foreach (
    [
        'present',
        'absent',
        'late',
        'excused'
    ]
    as $status
)

<option
    value="{{ $status }}"
    @selected(
        (
            $current->status
            ?? 'present'
        )
        === $status
    )
>
    {{
        ucfirst($status)
    }}
</option>

@endforeach

</select>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>


<button
    class="btn
    btn-primary mt-4"
>
    Save Attendance
</button>

</form>

@endsection