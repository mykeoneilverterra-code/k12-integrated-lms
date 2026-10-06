@extends('layouts.teacher')

@section('title', 'Lessons')
@section('page-title', 'Lessons')

@section('content')

@include(
    'teacher.classes._tabs'
)


<div
    class="d-flex
    justify-content-between
    mb-4"
>

    <h3>Lessons</h3>

    <a
        href="{{
            route(
                'teacher.lessons.create',
                $classSubject
            )
        }}"
        class="btn btn-primary"
    >
        Add Lesson
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
    <th>Status</th>
    <th>Published</th>
    <th
        class="text-end pe-4"
    >
        Actions
    </th>
</tr>
</thead>

<tbody>

@forelse ($lessons as $lesson)

<tr>

    <td class="ps-4 fw-semibold">
        {{ $lesson->title }}
    </td>

    <td>
        {{
            $lesson->is_published
            ? 'Published'
            : 'Draft'
        }}
    </td>

    <td>
        {{
            $lesson->published_at
            ?->format('M d, Y')
            ?? '—'
        }}
    </td>

    <td class="text-end pe-4">

        @if ($lesson->file_path)

            <a
                href="{{
                    asset(
                        'storage/' .
                        $lesson
                        ->file_path
                    )
                }}"
                target="_blank"
                class="btn
                btn-sm
                btn-outline-success"
            >
                File
            </a>

        @endif


        <a
            href="{{
                route(
                    'teacher.lessons.edit',
                    [
                        $classSubject,
                        $lesson
                    ]
                )
            }}"
            class="btn
            btn-sm
            btn-outline-primary"
        >
            Edit
        </a>


        <form
            method="POST"
            action="{{
                route(
                    'teacher.lessons.destroy',
                    [
                        $classSubject,
                        $lesson
                    ]
                )
            }}"
            class="d-inline"
            onsubmit="
                return confirm(
                    'Delete this lesson?'
                )
            "
        >

            @csrf
            @method('DELETE')

            <button
                class="btn
                btn-sm
                btn-outline-danger"
            >
                Delete
            </button>

        </form>

    </td>

</tr>

@empty

<tr>

<td
    colspan="4"
    class="text-center
    py-5
    text-muted"
>
    No lessons yet.
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection