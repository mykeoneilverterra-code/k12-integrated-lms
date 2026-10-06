@extends('layouts.teacher')

@section('title', 'Assignments')
@section('page-title', 'Assignments')

@section('content')

@include(
    'teacher.classes._tabs'
)


<div
    class="d-flex
    justify-content-between
    mb-4"
>

    <h3>Assignments</h3>

    <a
        href="{{
            route(
                'teacher.assignments.create',
                $classSubject
            )
        }}"
        class="btn btn-primary"
    >
        Add Assignment
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
    <th class="ps-4">Title</th>
    <th>Due</th>
    <th>Points</th>
    <th>Submissions</th>
    <th>Status</th>
    <th
        class="text-end pe-4"
    >
        Actions
    </th>
</tr>
</thead>

<tbody>

@forelse (
    $assignments
    as $assignment
)

<tr>

<td class="ps-4 fw-semibold">
    {{ $assignment->title }}
</td>

<td>
    {{
        $assignment->due_at
        ?->format(
            'M d, Y h:i A'
        )
        ?? '—'
    }}
</td>

<td>
    {{
        $assignment
        ->total_points
    }}
</td>

<td>
    {{
        $assignment
        ->submissions_count
    }}
</td>

<td>
    {{
        $assignment
        ->is_published
        ? 'Published'
        : 'Draft'
    }}
</td>

<td class="text-end pe-4">

<a
    href="{{
        route(
            'teacher.submissions.index',
            [
                $classSubject,
                $assignment
            ]
        )
    }}"
    class="btn
    btn-sm
    btn-outline-success"
>
    Submissions
</a>

<a
    href="{{
        route(
            'teacher.assignments.edit',
            [
                $classSubject,
                $assignment
            ]
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

@empty

<tr>
<td
    colspan="6"
    class="text-center
    py-5
    text-muted"
>
    No assignments.
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection