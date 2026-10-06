@extends('layouts.teacher')

@section(
    'title',
    'Submissions'
)

@section(
    'page-title',
    'Assignment Submissions'
)

@section('content')

@include(
    'teacher.classes._tabs'
)


<div class="card dashboard-card mb-4">

<div class="card-body">

<h4>
    {{ $assignment->title }}
</h4>

<p class="text-muted mb-0">
    Total Points:
    {{
        $assignment
        ->total_points
    }}
</p>

</div>

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
        Student
    </th>
    <th>Status</th>
    <th>Submitted</th>
    <th>Score</th>
</tr>

</thead>

<tbody>

@foreach (
    $enrollments
    as $enrollment
)

@php

$submission =
    $submissions->get(
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

@if ($submission)

{{
    ucfirst(
        $submission
        ->status
    )
}}

@else

<span class="text-muted">
    Not submitted
</span>

@endif

</td>

<td>

{{
    $submission
    ?->submitted_at
    ?->format(
        'M d, Y h:i A'
    )
    ?? '—'
}}

</td>

<td>

@if ($submission)

<form
    method="POST"
    action="{{
        route(
            'teacher.submissions.update',
            [
                $classSubject,
                $assignment,
                $submission
            ]
        )
    }}"
    class="d-flex gap-2"
>

@csrf
@method('PUT')

<input
    type="number"
    step="0.01"
    name="score"
    class="form-control
    form-control-sm"
    style="width:90px"
    value="{{
        $submission
        ->score
    }}"
>

<input
    name="feedback"
    class="form-control
    form-control-sm"
    placeholder="Feedback"
    value="{{
        $submission
        ->feedback
    }}"
>

<button
    class="btn
    btn-sm
    btn-primary"
>
    Save
</button>

</form>

@else

—

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection