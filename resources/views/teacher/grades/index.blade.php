@extends('layouts.teacher')

@section('title', 'Grades')
@section('page-title', 'Grades')

@section('content')

@include(
    'teacher.classes._tabs'
)


<div class="mb-4">

<form method="GET">

<select
    name="quarter"
    class="form-select"
    style="max-width:220px"
    onchange="
        this.form.submit()
    "
>

@for ($q = 1; $q <= 4; $q++)

<option
    value="{{ $q }}"
    @selected(
        $quarter === $q
    )
>
    Quarter {{ $q }}
</option>

@endfor

</select>

</form>

</div>


<form
    method="POST"
    action="{{
        route(
            'teacher.grades.store',
            $classSubject
        )
    }}"
>

@csrf

<input
    type="hidden"
    name="quarter"
    value="{{ $quarter }}"
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
    <th>Grade</th>
    <th>Status</th>
</tr>

</thead>

<tbody>

@foreach (
    $enrollments
    as $enrollment
)

@php

$grade =
    $grades->get(
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

@if (
    $grade?->status
    === 'finalized'
)

<strong>
    {{ $grade->grade }}
</strong>

@else

<input
    type="number"
    min="0"
    max="100"
    step="0.01"
    name="grades[{{ $enrollment->id }}]"
    class="form-control"
    style="max-width:130px"
    value="{{
        old(
            'grades.' .
            $enrollment->id,
            $grade->grade
            ?? ''
        )
    }}"
>

@endif

</td>

<td>

@if ($grade)

<span
    class="badge
    {{
        $grade->status
        === 'finalized'
        ? 'text-bg-success'
        : 'text-bg-warning'
    }}"
>

{{
    ucfirst(
        $grade->status
    )
}}

</span>

@else

<span class="text-muted">
    Not encoded
</span>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>


<div class="mt-4">

<button
    type="submit"
    name="action"
    value="draft"
    class="btn
    btn-outline-primary"
>
    Save Draft
</button>

<button
    type="submit"
    name="action"
    value="finalize"
    class="btn
    btn-success"
    onclick="
        return confirm(
            'Finalize these grades? Finalized grades will be locked.'
        )
    "
>
    Finalize Grades
</button>

</div>

</form>

@endsection