@extends('layouts.student')

@section('title', 'Assignments')
@section('page-title', 'Assignments')

@section('content')

@include(
    'student.subjects._tabs'
)


<h3 class="mb-4">
    Assignments
</h3>


<div class="card table-card">

<table class="table table-hover align-middle">

<thead>

<tr>
    <th class="ps-4">Assignment</th>
    <th>Due</th>
    <th>Points</th>
    <th>Status</th>
    <th class="text-end pe-4">
        Action
    </th>
</tr>

</thead>

<tbody>

@forelse($assignments as $assignment)

@php
    $submission =
        $submissions->get(
            $assignment->id
        );
@endphp

<tr>

<td class="ps-4 fw-semibold">
    {{ $assignment->title }}
</td>

<td>

{{
    $assignment
        ->due_at
        ?->format(
            'M d, Y h:i A'
        )
    ?? '—'
}}

</td>

<td>
    {{ $assignment->total_points }}
</td>

<td>

@if($submission)

<span class="badge text-bg-success">

{{
    ucfirst(
        $submission->status
    )
}}

</span>

@else

<span class="badge text-bg-warning">
    Pending
</span>

@endif

</td>

<td class="text-end pe-4">

<a
    href="{{
        route(
            'student.assignments.show',
            [
                $classSubject,
                $assignment
            ]
        )
    }}"
    class="btn btn-sm btn-primary"
>
    View
</a>

</td>

</tr>

@empty

<tr>

<td
    colspan="5"
    class="text-center py-5 text-muted"
>
    No assignments.
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection