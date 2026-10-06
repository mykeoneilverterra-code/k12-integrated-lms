@extends('layouts.teacher')

@section('title', 'Quizzes')
@section('page-title', 'Quizzes')

@section('content')

@include(
    'teacher.classes._tabs'
)


<div
    class="d-flex
    justify-content-between
    mb-4"
>

<h3>Quizzes</h3>

<a
    href="{{
        route(
            'teacher.quizzes.create',
            $classSubject
        )
    }}"
    class="btn btn-primary"
>
    Add Quiz
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
    <th class="ps-4">Quiz</th>
    <th>Questions</th>
    <th>Attempts</th>
    <th>Status</th>
    <th
        class="text-end pe-4"
    >
        Actions
    </th>
</tr>

</thead>

<tbody>

@forelse ($quizzes as $quiz)

<tr>

<td class="ps-4 fw-semibold">
    {{ $quiz->title }}
</td>

<td>
    {{
        $quiz
        ->questions_count
    }}
</td>

<td>
    {{
        $quiz
        ->attempts_count
    }}
</td>

<td>
    {{
        $quiz->is_published
        ? 'Published'
        : 'Draft'
    }}
</td>

<td class="text-end pe-4">

<a
    href="{{
        route(
            'teacher.quizzes.show',
            [
                $classSubject,
                $quiz
            ]
        )
    }}"
    class="btn
    btn-sm
    btn-outline-success"
>
    Questions
</a>

<a
    href="{{
        route(
            'teacher.quizzes.edit',
            [
                $classSubject,
                $quiz
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
    colspan="5"
    class="text-center
    py-5 text-muted"
>
    No quizzes.
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection