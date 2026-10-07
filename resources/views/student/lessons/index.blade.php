@extends('layouts.student')

@section('title', 'Lessons')
@section('page-title', 'Lessons')

@section('content')

@include(
    'student.subjects._tabs'
)

<h3 class="mb-4">
    Lessons
</h3>


<div class="card table-card">

<table class="table table-hover align-middle">

<thead>

<tr>
    <th class="ps-4">Lesson</th>
    <th>Published</th>
    <th class="text-end pe-4">
        Action
    </th>
</tr>

</thead>

<tbody>

@forelse($lessons as $lesson)

<tr>

<td class="ps-4">

<strong>
    {{ $lesson->title }}
</strong>

<div class="text-muted small">

{{
    \Illuminate\Support\Str::limit(
        $lesson->description,
        80
    )
}}

</div>

</td>

<td>

{{
    $lesson
        ->published_at
        ?->format('M d, Y')
}}

</td>

<td class="text-end pe-4">

<a
    href="{{
        route(
            'student.lessons.show',
            [
                $classSubject,
                $lesson
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
    colspan="3"
    class="text-center py-5 text-muted"
>
    No published lessons.
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection